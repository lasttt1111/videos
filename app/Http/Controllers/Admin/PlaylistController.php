<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;

use Auth;

use App\Models\Playlist;
use App\Models\Video;
use App\Models\User;
class PlaylistController extends Controller
{
    public function __construct()
    {
        Content::setModule('playlist');
    }

    public function getIndex(Request $request)
    {
        return Content::render([
            'title' => __('Quản lí danh sách phát'),
            'function' => 'index',
            'playlists' => Playlist::search($request->get('q', ''), true)
                                    ->with('user:id,name')
                                    ->withCount('video')
                                    ->paginate(12),
        ]);
    }

    public function check($alias, &$response, &$playlist)
    {
        $playlist = Playlist::findAlias($alias)
                            ->with('user:id,alias,name')
                            ->with('video:id,alias,title,image')
                            ->with('video.user:id,alias,name')
                            ->first();
        if (empty($playlist)){
            $response = Content::error(404);
            return false;
        }
        return true;
    }

    public function getVideo(Request $request)
    {
        return Video::select(['id', 'alias', 'title', 'image', 'user_id'])
                    ->with('user:id,alias,name')
                    ->search($request->get('q', ''))
                    ->paginate(100);
    }

    public function getEdit(Request $request, $alias, array $appends = [])
    {
        if (!$this->check($alias, $response, $playlist)){
            return $response;
        }
        //dd($playlist);

        return Content::render([
            'title' => $playlist->title,
            'function' => 'edit',
            'playlist' => $playlist,
        ] + $appends);
    }

    protected function getListVideo(string $str)
    {
        $list = explode(',', $str);
        $list = array_unique($list);
        $video = Video::select(['id'])->whereIn('id', $list)->get();
        $result = array_column($video->toArray(), 'id');
        //Lọc những id tồn tại
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

    protected function action(Request $request, Playlist $playlist)
    {
        $playlist->fill($request->only(['title', 'privacy']));

        if (empty($request->user_alias)){
            $playlist->user_id = Auth::user()->id;
        } else {
            $user = User::select(['id'])->findAlias($request->user_alias)->first();

            if (!empty($user)){
                $playlist->user_id = $user->id;
            } elseif (empty($playlist->user_id)){
                $playlist->user_id = Auth::user()->id;
            }
        }

        if (empty($request->alias)){
            $slug =  str_slug($request->title);
            if (empty($slug)){
                $slug = str_random(20);
            }
            //Playlist mới chưa có alias mới gán
            $request->merge(['alias' => empty($playlist->alias) ? $slug : '']);
        }

        if ($request->alias){
            //Kiểm tra trùng lặp:
            $check = Playlist::select(['id'])->findAlias($request->alias);
            if (!empty($playlist->id)){
                $check->where('id', '<>', $playlist->id);
            }
            $check = $check->first();
            if (empty($check)){
                $playlist->alias = $request->alias;
            } else if (empty($playlists->alias)){
                $playlists->alias = str_limit($request->alias, 100, '') . '-' . str_random(10);
            }
        }

        $list = $request->video ? $this->makeListVideo($request->video) : null;
        
        // if (empty($list)){
        //     return $this->getEdit($request, $alias)->withErrors(['video.required' => __('Vui lòng chọn ít nhất 1 video')]);
        // }

        //Xử lí ảnh
        if ($request->hasFile('image')){
            $playlist->image = Imgur::save($request->file('image'));
        }

        $playlist->save();
        $playlist->video()->sync($list);

        return true;
    }

    public function putEdit (\App\Http\Requests\Admin\PutPlaylistRequest $request, $alias)
    {
        if (!$this->check($alias, $response, $playlist)){
            return $response;
        }

        $this->action($request, $playlist);
        
        
        return $this->getEdit($request, $request->alias, ['success' => __('Thành công')]);
    }

    public function getAdd(Request $request, array $appends = [])
    {
        return Content::render([
            'function' => 'add',
            'title' => __('Thêm mới danh sách phát'),
        ] + $appends);
    }

    public function postAdd(\App\Http\Requests\Admin\PostPlaylistRequest $request)
    {
        $playlist = new Playlist;
        if (!$this->action($request, $playlist)){
            return $this->getAdd($request)->withErrors(['error' => __('Thông tin không hợp lệ')]);
        }
        return $this->getAdd($request, ['success' => __('Thành công')]);
    }

    public function getDelete(Request $request, $alias)
    {
        if (!$this->check($alias, $response, $playlist)){
            return $response;
        }

        return Content::render([
            'title' => __('Xóa danh sách phát'),
            'function' => 'delete',
            'playlist' => $playlist,
        ]);
    }

    public function delete(Request $request, $alias)
    {
        if (!$this->check($alias, $response, $playlist)){
            return $response;
        }

        $playlist->delete();

        return redirect()->route('admin.playlist.index');
    }
}
