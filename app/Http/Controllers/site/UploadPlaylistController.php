<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;
use Auth;

use App\Models\Playlist;
use App\Models\Video;

class UploadPlaylistController extends Controller
{
    protected $limit = 100;
    public function __construct()
    {
    	Content::setModule('upload_playlist');
    }

    public function getUpload(Request $request)
    {
        return Content::render([
            'function' => 'add',
            'title' => __('Thêm mới danh sách phát'),
        ]);
    }

    public function getSearch(Request $request)
    {
        if (!empty($request->video) && is_string($request->video)){
            $video = Video::select(['id'])->findAlias($request->video)->first();
            if (!empty($video)){
                return $this->getSearchPlaylist($video->id, $request->get('q', ''));
            }
        } else if (!empty($request->playlist) && is_string($request->playlist)){
            $playlist = Playlist::select(['id'])->findAlias($request->playlist)->first();
            if (!empty($playlist)){
                return $this->getSearchVideo($playlist->id, $request->get('q', ''));
            }
        }
        return response()->json(['data' => []]);
    }

    protected function getSearchVideo($playlistId, $search)
    {
        return Video::select(['id', 'alias', 'title', 'image'])
                        ->where(function($query){
                            //Video thuộc sở hữu của mình hoặc video công khai khác
                            $query->where('user_id', Auth::user()->id);
                            $query->orWhere('privacy', 0);
                        })
                        ->search($search)
                        ->whereDoesntHave('playlists', function($query) use($playlistId){
                            $query->where('playlist_id', $playlistId);
                        })
                        ->paginate(12);
    }

    protected function getSearchPlaylist($videoId, $search)
    {
        return Playlist::select(['id', 'alias', 'title', 'image'])
                        ->where('user_id', Auth::user()->id)
                        ->search($search)
                        ->whereDoesntHave('video', function($query) use($videoId){
                            $query->where('video_id', $videoId);
                        })
                        ->paginate(12);
    }

    public function postUpload(\App\Http\Requests\Site\PostPlaylistRequest $request)
    {
        $alias = str_slug($request->title);
        if (empty($alias)){
            $alias = str_random(15);
        } else {
            $check = Playlist::select(['id'])->findAlias($alias)->first();
            if (!empty($alias)){
                $alias = str_limit($alias, 100, '') . '-' . str_random(15);
            }
        }
        
        Playlist::create($request->only(['title', 'privacy']) + [
            'alias' => $alias,
            'image' => Imgur::save($request->file('image')),
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('site.user.playlist', ['alias' => Auth::user()->alias]);
    }

    public function check($alias, &$response, &$playlist){
        $playlist = Playlist::findAlias($alias)
                    ->with('video:id,alias,title,image')
                    ->with('video.user:id,name')
                    ->first();

        if(empty($playlist)){
            $response = Content::error(404);
            return false;
        }

        if($playlist->user_id != Auth::user()->id && Auth::user()->permission > 2){
            $response = Content::error(403);
            return false;
        }

        return true;    
    }

    public function delete(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $playlist)){
            return $response;
        }
        
        $playlist->delete();

        return response()->json(['status' => 200], 200);
    }

    public function postAddTo(Request $request)
    {
        if (empty($request->playlist) || !is_string($request->playlist) || empty($request->video) || !is_string($request->video))
        {
            return response()->json(['status' => 400], 400);
        }

        if (!$this->check($request->playlist, $response, $playlist)){
            return $response;
        }

        if ($playlist->video()->count() >= $this->limit){
            return response()->json(['status' => 409], 409);
        }

        $video = Video::findAlias($request->video)->first();
        if (empty($video)){
            return response()->json(['status' => 404], 404);
        }

        $playlist->video()->syncWithoutDetaching([$video->id]);
        return response()->json(['status' => 200], 200);
    }

    public function getEdit(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $playlist)){
            return $response;
        }

        return Content::render([
            'title' => __('Chỉnh sửa danh sách :title', ['title' => $playlist->title]),
            'function' => 'edit',
            'playlist' => $playlist,
        ]);
    }

    protected function getListVideo(string $str)
    {
        $list = explode(',', $str);
        $list = array_unique($list);
        $video = Video::select(['id'])->whereIn('id', $list)->get();
        $result = array_column($video->toArray(), 'id');
        //Lọc những id tồn tại, giới hạn số lượng
        return array_intersect($list, $result);
    }

    protected function makeListVideo(string $str)
    {
        $list = $this->getListVideo($str);

        $i = 1;
        $result = [];

        foreach ($list as $l)
        {
            $result[$l] = ['position' => $i++];
        }
        return $result;
    }

    public function putEdit(\App\Http\Requests\Site\PutPlaylistRequest $request, $alias)
    {
        if (!$this->check($alias, $response, $playlist)){
            return $response;
        }

        $video = empty($request->video) ? [] : $this->makeListVideo($request->video);

        $playlist->fill($request->only(['title', 'privacy']));

        if ($request->hasFile('image')){
            $playlist->image = Imgur::save($request->file('image'));
        }

        $playlist->save();

        $playlist->video()->sync($video);

        return $this->getEdit($request, $alias);
    }
}