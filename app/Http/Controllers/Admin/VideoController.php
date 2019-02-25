<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;
use App\Helpers\GetLink;
use Auth;

use App\Models\Video;
use App\Models\Category;
use App\Models\Language;
use App\Models\User;
use App\Models\Tag;
class VideoController extends Controller
{
	public function __construct()
	{
		Content::setModule('video');
	}

	public function getIndex(Request $request)
	{
		return Content::render([
			'video' => Video::search($request->get('q',''))
				->with('category', 'user:id,alias')
				->orderBy('created_at', 'desc')
				->paginate(12),
				'function' => 'index',
				'title' => __('Danh sách video')
		]);
	}

	public function check($alias, &$response, &$video)
	{
		$video = Video::with('category:id,alias,title', 'user:id,alias,name', 'tags:id,alias,title')
			->findAlias($alias)
			->first();
		if(empty($video)){
			$response = Content::error(404);
			return false;
		}

		return true;
	}

	protected function make(&$categories, &$languages, &$tags)
	{
		//Danh mục
		$categoryList = Category::select(['id', 'title'])->get();
		$categories = [];
		foreach ($categoryList as $c)
		{
			$categories[$c->id] = $c->title;
		}

		//Ngôn ngữ
		$languageList = Language::select(['id', 'name'])->get();
		$languages = [];
		foreach ($languages as $l) {
			$languages[$l->id] = $l->name;
		}
		$languages['oth'] = __('Khác');
		//Thẻ
		$tagList = Tag::select(['id', 'title'])->get();
		$tags = [];
		foreach ($tagList as $t)
		{
			$tags[$t->id] = $t->title;
		}
	}

	public function getEdit(Request $request, $alias, array $appends = [])
	{

		if (!$this->check($alias, $response, $video)){
			return $response;
		}
		$this->make($categories, $languages, $tags);

		return Content::render([
			'video' => $video,
			'function' =>'edit',
			'title' => __('Chỉnh sửa video'),
			'categories' => $categories,
			'languages' => $languages,
			'tags' => $tags,
		] + $appends);
	}

	public function addTags(Video $video, $tags)
	{
		//Kiểm tra tags được truyền vào
		if (empty($tags) || !is_array($tags)){
			return;
		}

		foreach ($tags as $tag){
			if (!is_string($tag)){
				return;
			}
		}

		$tags = Tag::select(['id'])->whereIn('id', $tags)->get();
		$tags = $tags->pluck('id')->all();
		$video->tags()->sync($tags);
	}

	public function putEdit(\App\Http\Requests\Admin\PutVideoRequest $request, $alias)
	{
		if(!$this->check($alias, $response, $video)){
			return $response;
		}

		$video->fill($request->only(['title', 'label', 'description', 'privacy', 'password']));

		if($request->alias != $alias){
			//Kiểm tra trùng
			$v = Video::select(['id'])->findAlias($request->alias)->first();
			if(!empty($v)){
				return $this->getEdit($request, $alias)
					->withErrors(['alias.unique' => __('Định danh bị trùng')]);
			}
			$video->alias = $alias;
		}

		if(!$request->has('user_alias')){
			$video->user_id = Auth::user()->id;
		} else {
			$user = User::select(['id'])->findAlias($request->user_alias)->first();

			if(empty($user)){
				$video->user_id = Auth::user()->id;
			}
			else {
				$video->user_id = $user->id;
			}
		}

		if($request->has('remove-password')){
			$video->password = null;
		}

		$video->language = $request->language;
		$video->category_id = $request->category;

		if($request->hasFile('image')){
			$video->image = Imgur::save($request->file('image'));
		}

		$video->save();

		$this->addTags($video, $request->get('tags'));

		return redirect()->route('admin.video.edit', ['alias' => $video->alias]);
	}	

	public function getAdd(Request $request, array $appends = [])
	{
		$this->make($categories, $languages, $tags);

		return Content::render([
			'function' => 'add',
			'title' => __('Thêm mới video'),
			'categories' => $categories,
			'languages' => $languages,
			'tags' => $tags
		] + $appends);
	}

	public function postVideo(\App\Http\Requests\Admin\PostVideoRequest $request)
	{
		$video = new Video;

		if(empty($request->alias)){
			//Kiểm tra trùng :
			$request->merge(['alias' => str_slug($request->title)]);
		}
		//Kiểm tra alias có trùng không?
		$v = Video::select(['id'])->findAlias($request->alias)->first();
		if (!empty($v) || empty($request->alias)){
			$request->merge(['alias' => str_limit($request->alias, 100, ''). '-'. str_random(10) ]);
		}

		if(empty($request->user_alias)){
			$video->user_id = Auth::user()->id;
		} else {
			$user = User::select(['id'])->findAlias($request->user_alias)->first();
			if (empty($user)){
				$video->user_id = Auth::user()->id;
			} else {
				$video->user_id = $user->id;
			}
		}
		if ($request->has('remove-password')){
			$video->password = null;
		}
		$video->fill($request->only(['title', 'label', 'description', 'privacy', 'password', 'alias']));
	
		if($request->hasFile('video')){
			$file = $request->file('video');
			$fileName = $file->getClientOriginalName();
			$path = public_path().'\uploads\\';
            $file->move($path, $fileName);
            $link = 'http://localhost:81/videos/public/uploads/' . $fileName;
		}
		$video->link = $link;
		$video->language = $request->language;
		$video->category_id = $request->category;
		$video->image = Imgur::save($request->file('image'));

		$video->save();

		$this->addTags($video, $request->get('tags'));

		return redirect()->route('admin.video.edit', ['alias' => $video->alias]);
	}

	public function getDelete(Request $request, $alias)
	{
		if(!$this->check($alias, $response, $video)){
			return $response;
		}

		return Content::render([
			'title' => __('Xóa video'),
			'function' => 'delete',
			'video' => $video
		]);
	}

	public function delete(Request $request, $alias)
	{
		if(!$this->check($alias, $response, $video)){	
			return $response;
		}
		$video->delete();

		return redirect()->route('admin.video.index');
	}
}