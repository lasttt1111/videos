<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use Auth;

use App\Models\Playlist;
use App\Models\Video;
class PlaylistController extends Controller
{
	protected $limit = 100;
	public function __construct()
	{
		Content::setModule('playlist');
	}

	public function getIndex(Request $requesst)
	{
		$playlists = Playlist::where('privacy', 0)
							->orderBy('created_at', 'desc')
							->paginate(12);
		return Content::render([
			'title' => __('Danh sách phát'),
			'function' => 'index',
			'playlists' => $playlists
		]);
	}

	public function getPlaylist(Request $requesst, $alias)
	{
		$playlist = Playlist::findAlias($alias)->first();
		if (empty($playlist)){
			return Content::error(404);
		}

		if ($playlist->privacy > 1){
			if (!Auth::check()){
				return redirect()->route('site.login');
			}

			if (Auth::user()->id != $playlist->user_id && !Content::isMod()){
				return Content::error(403);
			}
		}

		$position = (int) $requesst->get('v', 1);
		if($position <= 0){
			$position = 1;
		}

		$video = $playlist->video()
						->wherePivot('position', $position)
						->select(['alias'])
						->with('user:id,name,alias')
						->with('tags:id,alias,title')
						->first();
		if(empty($video)){
			return Content::render([
			'title' => $playlist->title,
			'function' => 'play',
			'playlist' => $playlist,
			'video' => null,
			'list' => $playlist->video()
								->withPivot('position')
								->get(),
			]);
		}

		$VideoController = new VideoController;
		$videoView = $VideoController->getWatch($requesst, $video->alias, true);
		Content::setModule('playlist');
		return Content::render([
			'title' => $playlist->title,
			'function' => 'play',
			'playlist' => $playlist,
			'video' => $videoView,
			'list' => $playlist->video()
								->withPivot('position')
								->get(),
		]);
	}
}