<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//Class helper
use App\Helpers\Content;
use App\Helpers\GetLink;
use Auth, Session, Cache;

use App\Models\Video;
use App\Models\Transaction;
use App\Models\View;
use App\Models\VideoReaction;
use App\Models\Subscriber;
class VideoController extends Controller
{
	protected $cache = 1;

	public function __construct()
	{
		Content::setModule('video');
	}

	public function getIndex(Request $request)
	{
		return Content::render([
			'title' => __('Danh sách video'),
			'function' => 'list',
			'video' => Video::with('user:id,alias,name,avatar')->orderBy('created_at', 'desc')->paginate(12)
		]);
	}

	public function checkTotal(array $check){
		foreach ($check as $c){
			if(!$c){
				return false;
			}
		}
		return true;
	}

	public function checkView($request, $video, array &$checkWatch)
	{
		//Chỉ kiểm tra đối với người chưa đăng nhập, hoặc không phải sở hữu video và ko phải admin
		if(!Auth::check() || (Auth::user()->permission > 2 && Auth::user()->id != $video->user_id))
		{
			//1. Kiểm tra mật khẩu
			if($video->has_password){
				if(!$request->session()->has('video.unlock.'. $video->id)){
					$checkWatch['password'] = false;
				} else if (!\Hash::check($request->session()->get('video.unlock.'. $video->id), $video->password)){
				//Đã nhập nhưng mật khẩu không chính xác
                //Lưu session nên nếu chủ video chưa đổi password thì sẽ vào được mà không cần nhập lại
                //Ngược lại sẽ phải nhập lại
					$checkWatch['password'] = false;
				}
			}
 			//2. Kiểm tra quyền riêng tư
			if($video->privacy >= 2){
				//Riêng tư
				$checkWatch['privacy'] = false;
			}

			//3. Video tính phí	
			if ($video->price > 0){
				//Kiểm tra đã mua chưa?
				if(!Auth::check()){
					$checkWatch['paid'] = flase;
				} else {
					//Mua hay chưa = cách kiểm tra giao dịch
					$checkWatch['pail'] = false;
				}
			}
		}
	}

	protected function cacheCheck($request, $id){
		$username = Auth::check() ? Auth::user()->id : $request->ip();
		$key = md5('video.' . $username . '.' . $id);
		if(!Cache::has($key)){
			Cache::put($key, 1, $this->cache);
		}
	}

	protected function loadUserReaction($video){
		if(Auth::check()){
			$reaction = VideoReaction::select(['reaction'])
							->where('video_id', $video->id)
							->where('user_id', Auth::user()->id)
							->first();
			if(empty($reaction)){
				return 'none';
			}
			return $reaction->reaction;
		}
		return 'none';
	}

	protected function loadUserSubscribe($video){
		if (Auth::check()){
			$sub = Subscriber::select(['subscriber_id'])
							->where('subscriber_id', Auth::user()->id)
							->where('user_id', $video->user_id)
							->first();
			return !empty($sub);
		}
		return false;
	}

	public function getWatch(Request $request, $alias, $dataOnly = false)
	{

		$video = Video::commonSelect()
						->addSelect(['category_id', 'link'])
						->with('user:id,alias,avatar,name')
						->with('category:id,alias,title')
						->with(['reactions' => function($query){
							$query->selectRaw('count(reaction) as number, reaction, video_id');
							$query->groupBy(['reaction', 'video_id']);
							}
						])
						->with('tags:id,alias,title')
						->findAlias($alias)
						->first();
		if (empty($video)){
			return Content::error(404);
		}
		//Biến kiếm
		$checkWatch = [
			'password' => true,
			'privacy' => true,
			'paid' => true,
		];

		$this->checkView($request, $video, $checkWatch);
		//Tăng lượt xem

		if($canView = $this->checkTotal($checkWatch)){
			//Nếu đã vượt qua toàn bộ thì lưu lại
			$this->cacheCheck($request, $video->id);
			//xử lí lượt xem
			$v = View::where([
								'video_id' => $video->id,
								'ip' => $request->ip(),
								'user_id' => Auth::check() ? Auth::user()->id : 0
							])
						->where('created_at', '>', \Carbon\Carbon::now()->subMinutes($this->cache)->format('Y-m-d H:i:s'))
						->first();
			//Nếu không tìm thấy thì tăng lượt xem
			if (empty($v)){
				$video->increment('views');
				View::create([
					'video_id' => $video->id,
					'ip' => $request->ip(),
					'user_id' => Auth::check() ? Auth::user()->id : 0
				]);
			}
		}
		//Gửi dữ liệu về view
		$data = [
			'title' => $video->title,
			'function' => 'watch',
			'video' => $video,
			'checkWatch' => $checkWatch,
			'reactions' => Content::formatReaction($video->reactions),
			'canView' => $canView,
			'userReaction' => $this->loadUserReaction($video),
			'userSubscribe' => $this->loadUserSubscribe($video),
		];

		return $dataOnly ? $data : Content::render($data);
	}

	public function postWatch(Request $request, $alias){
		$video = Video::select(['id', 'password'])->findAlias($alias)->first();
		if (empty($video)){
			return Content::error(404);
		}
		// dd($request->password);
		if ($request->has('password') && is_string($request->password)){
			if (\Hash::check($request->password, $video->password)){
				$request->session()->put('video.unlock.' .$video->id, $request->password);
				if ($request->query->get('redirect')) {
					return redirect()->to($request->query->get('redirect'));
				}
			}
		}

		return $this->getWatch($request, $alias);
	}

	public function postReaction(Request $request, $alias)
	{
		$video = Video::select(['id', 'password', 'alias', 'price', 'privacy', 'link'])
						->findAlias($alias)
						->first();
		$reaction = $request->get('reaction');
		if (empty($video) || !is_string($reaction) || !in_array($reaction, ['like', 'dislike'])){
			return response()->json(['status' => 404], 404);
		}

		$checkWatch = [];
		$this->checkView($request, $video, $checkWatch);
		if (!Auth::check() || !$this->checkTotal($checkWatch)){
			return response()->json(['status' => 403], 403);
		}

		$react = VideoReaction::where([
									'video_id' => $video->id,
									'user_id' => Auth::user()->id
								])
								->first();

		if (empty($react)){
			VideoReaction::create([
				'video_id' => $video->id,
				'user_id' => Auth::user()->id,
				'reaction' => $reaction,
			]);
		}
		elseif ($react->reaction == $reaction){
			$react->delete();
		} else {
			$react->reaction = $reaction;
			$react->save();
		}
		return response()->json(['status' => 200]);
	}

	public function getLink(Request $request, $alias){
		$video = Video::select(['id', 'password', 'alias', 'price', 'privacy', 'link'])
						->findAlias($alias)
						->first();

		if (empty($video)){
			return response()->json(['status' => 404], 404);
		}

		$checkWatch = [];
		$this->checkView($request, $video, $checkWatch);
	
		if (!$this->checkTotal($checkWatch)){
			return response()->json(['status' => 404], 404);
		}

		if (empty($video->link)){
			return response()->json(['status' => 404], 404);
		}
		
		return response()->json(['status' => 200, 'data' => $video]);
	}

	public function getSearch(Request $request)
	{
		$search = $request->get('q', '');
		return Content::render([
			'title' => __('Tìm kiếm :keyword', ['keyword' => $search]),
			'function' => 'list',
			'video' => Video::search($search)->with('user:id,alias,name,avatar')->paginate(12)
		]);
	}
}