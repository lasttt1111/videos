<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;
use Auth;

use App\Models\User;
class UserController extends Controller
{
    public function __construct()
    {
        Content::setModule('user');
    }

    public function getIndex(Request $request)
    {
        return Content::render([
            'title' => __('Danh sách thành viên'),
            'function' => 'index',
            'users' => User::withCount(['video', 'playlist'])
                            ->search($request->get('q', ''))
                            ->paginate(12)
        ]);
    }

    public function findUser($alias, &$response, &$user)
    {
        $user = User::findAlias($alias)->first();
        if (empty($user)){
            $response = Content::error(404);
            return false;
        }

        if ($user->permission < Auth::user()->permission){
            $response = Content::error(403);
            return false;
        }
        return true;
    }

    public function getEdit(Request $request, $alias, array $appends = [])
    {
        $user = User::findAlias($alias)->first();
        if (empty($user)){
            return Content::error(404);
        }
        return Content::render([
            'title' => __('Chỉnh sửa thành viên'),
            'function' => 'edit',
            'user' => $user,
        ] + $appends);
    }

    public function putEdit(\App\Http\Requests\Admin\PutUserRequest $request, $alias)
    {
        if (!$this->findUser($alias, $response, $user)){
            return $response;
        }

        //Kiểm tra alias:
        if ($alias != $request->alias){
            //Kiểm tra có trùng hay không?
            $test = User::select(['id'])
                        ->where('alias', $request->alias)
                        //->where('id', '<>', $user->id)
                        ->first();
            if (!empty($test)){
                //Trùng, báo lỗi
                return $this->getEdit($request, $alias)->withErrors(['alias.unique' => __('Định danh trùng')]);
            }
        }

        $user->fill($request->only(['alias', 'name', 'password']));

        if ($user->permission > 0){
            $user->permission = $request->permission;
        }

        //Phù hợp, chỉ việc upload ảnh nếu có:
        if ($request->hasFile('avatar')){
            $user->avatar = Imgur::save($request->file('avatar'));
        }

        if ($request->hasFile('cover')){
            $user->cover = Imgur::save($request->file('cover'));
        }
        $user->save();
        return $this->getEdit($request, $alias, ['success' => __('Thành công')]);
    }

    public function getDelete(Request $request, $alias)
    {
        if (!$this->findUser($alias, $response, $user)){
            return $response;
        }

        return Content::render([
            'title' => __('Xóa thành viên'),
            'function' => 'delete',
            'user' => $user,
        ]);
    }

    public function delete(Request $request, $alias)
    {
        if (!$this->findUser($alias, $response, $user)){
            return $response;
        }

        if ($user->permission > 0 && $user->id != Auth::user()->id) {
            if ($user->video()->count() > 0 || $user->playlist()->count() > 0){
                return $this->getDelete($request, $alias)
                            ->withErrors([
                                'not_empty' => __('Vui lòng hủy hết video hoặc playlist của người dùng này')
                            ]);
            }
            $user->delete();
        }

        return redirect()->route('admin.user.index');
    }

    public function getInfo(Request $request, $alias)
    {
        if (!$this->findUser($alias, $response, $user)){
            return $response;
        }

        return Content::render([
            'title' => __('Thông tin thành viên'),
            'function' => 'info',
            'user' => $user,
            'video' => $user->video()
                            ->search($request->get('q', ''))
                            ->paginate(12)
        ]);
    }
}
