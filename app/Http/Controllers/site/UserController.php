<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;
use App\Helpers\Api;
use Auth;

use App\Models\User;
use App\Models\Subscriber;
use App\Models\Playlist;
class UserController extends Controller
{
    public function __construct(){
        Content::setModule('user');
    }
    //ajax
    public function postSubscribe(Request $request, $alias)
    {
        $user = User::findAlias($alias)->first();

        if (empty($user)){
            return response()->json(['status' => 404], 404);
        }

        if (Auth::user()->id == $user->id){
            return response()->json(['status' => 400], 400);
        }

        Auth::user()->subscription()->toggle([$user->id]);
        return response()->json(['status' => 200], 200);
    }

    public function getProfile($alias = '')
    {
        if ($alias == ''){
            if (!Auth::check()){
                return redirect()->route('site.login');
            }
            $user = Auth::user();
        } else {
            $user = User::findAlias($alias)->first();
        }

        if (empty($user)){
            return Content::error(404);
        }
        $query = $user->video()->orderBy('created_at', 'desc');

        if ($alias != '' && !Content::isMod()){
            $query->where('privacy', 0);
        }

        return Content::render([
            'title' => $user->name,
            'function' => 'profile',
            'user' => $user,
            'video' => $query->paginate(12),
        ]);
    }

    public function getSubscription(Request $request, $alias)
    {
        $user = User::findAlias($alias)->first();
        if (empty($user)){
            return Content::error(404);
        }

        return Content::render([
            'title' => $user->name,
            'function' => 'subscribe',
            'user' => $user,
            'subscribers' => $user->subscribers()->paginate(12),
        ]);

    }

    public function getLogout(){
        Auth::logout();
        return redirect()->back();
    }

    public function getInfo (Request $request, $alias, array $appends = [])
    {
        if (Auth::user()->alias != $alias){
            return Content::error(403);
        }
        $user = Auth::user();
        return Content::render([
            'title' => $user->name,
            'function' => 'info',
            'user' => $user,
        ] + $appends);
    }

    public function putInfo(\App\Http\Requests\Site\PostUserRequest $request, $alias)
    {
        if (Auth::user()->alias != $alias){
            return Content::error(403);
        }
        $user = Auth::user();
        $user->fill($request->only(['name', 'password']));

        if ($request->hasFile('avatar')){
            $user->avatar = Imgur::save($request->file('avatar'));
        }

        if ($request->hasFile('cover')){
            $user->cover = Imgur::save($request->file('cover'));
        }
        $user->save();
        return $this->getInfo($request, $alias, ['success' => __('Thành công')]);
    }

    public function getPlaylist(Request $request, $alias = '')
    {
        if (empty($alias)){
            if (Auth::check()){
                $user = Auth::user();
            }
            return redirect()->route('site.login');
            
        } else {
            $user = User::findAlias($alias)->first();
            if (empty($user)){
                return Content::error(404);
            }
        }

        $playlist = $user->playlist();

        if (!Auth::check() || Auth::user()->id != $user->id){
            $playlist->where('privacy', 0);
        }

         return Content::render([
            'title' => $user->name,
            'function' => 'playlist',
            'user' => $user,
            'playlists' => $playlist->orderBy('created_at', 'desc')
                                    ->withCount('video')
                                    ->paginate(12),
        ]);
    }

    public function getLogin(Request $request, $message = '')
    {
        return Content::render([
            'title' => 'login',
            'function' => 'login',
            'error' => $message
        ]);
    }

    public function postLogin(Request $request){
        $user = User::select(['id', 'alias', 'password'])
                    ->where('email', $request->email)
                    ->first();
        if (empty($user)){
            return $this->getLogin($request,'Tên đăng nhập hoặc mật khẩu không chính xác');
        }

        if (!\Hash::check($request->password, $user->password)){
            return $this->getLogin($request,'Tên đăng nhập hoặc mật khẩu không chính xác');
        }
        Auth::loginUsingId($user->id);
        return redirect()->route('site.index');

    }

    public function getRegister(Request $request)
    {
        return Content::render([
            'title' => 'register',
            'function' => 'register',
        ]);
    }

    public function postRegister(\App\Http\Requests\Site\PostRegisterRequest $request)
    {
        $alias = $request->name;
        $check = User::findAlias($alias)->first();
        if (!empty($check)){
            $alias .= '-' . str_random(15);
        }
        User::create($request->only(['name', 'password', 'email']) + ['alias' => $alias]);
        return redirect()->route('site.login');
    }
}
