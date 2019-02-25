<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Content;

use App\Models\Tag;
class TagController extends Controller
{
    public function __construct()
    {
        Content::setModule('tag');
    }

    public function getIndex(Request $request)
    {
        return Content::render([
            'title' => __('Danh mục'),
            'function' => 'index',
            'tags' => Tag::search($request->get('q', ''))
                                    ->withCount('video')
                                    ->paginate(12)
        ]);
    }

   public function check($alias, &$response, &$tag)
   {
        $tag = Tag::findAlias($alias)->first();

        if (empty($tag)){
            $response = Content::error(404);
            return false;
        }
        return true;
   }

    public function getEdit(Request $request, $alias, array $appends = [])
    {
        if(!$this->check($alias, $response, $tag)){
            return $response;
        }   

        return Content::render([
            'title' => __('Chỉnh sửa danh mục'),
            'function' => 'edit',
            'tag' => $tag,
        ] + $appends);
    }

    public function putEdit(\App\Http\Requests\Admin\PutTagRequest $request, $alias)
    {
        if(!$this->check($alias, $response, $tag)){
            return $response;
        }

        if (!empty($request->alias) && $request->alias != $alias){
            $check = Tag::findAlias($request->alias)->first();
            if (!empty($check)){
                return $this->getEdit($request, $alias)->withErrors(['alias.unique' => __('Định danh trùng')]);
            }
            $tag->alias = $request->alias;
        }

        $tag->fill($request->only(['title']));

        $tag->save();

        return $this->getEdit($request, $tag->alias, ['success' => __('Thành công')]);
    }

    public function getAdd(Request $request, array $appends = []){
        return Content::render([
            'title' => __('Thêm mới danh mục'),
            'function' => 'add',
        ] + $appends);
    }

    public function postAdd(\App\Http\Requests\Admin\PostTagRequest $request)
    {
        if (empty($request->alias)){
            $request->merge(['alias' => str_slug($request->title)]);

            if (empty($request->alias)){
                $request->merge(['alias' => str_random(12)]);
            }
        }

        $tag = new Tag;

        $check = Tag::findAlias($request->alias)->first();

        if (empty($check)){
            $tag->alias = $request->alias;
        } else {
            $tag->alias = $request->alias.'-'.str_random(12);
        }

        $tag->fill($request->only(['title']));

        $tag->save();

        return $this->getAdd($request, ['success' => __('Thành công')]);
    }

    public function getDelete(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $tag)){
            return $response;
        }

        return Content::render([
            'title' => __('Xóa danh mục'),
            'function' => 'delete',
            'tag' => $tag,
        ]);
    }

    public function delete(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $tag)){
            return $response;
        }

        $tag->delete();

        return redirect()->route('admin.tag.index');
    }

    public function getInfo(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $tag)){
            return $response;
        }

        return Content::render([
            'title' => __('Chi tiết thẻ'),
            'function' => 'info',
            'tag' => $tag,
            'video' => $tag->video()
                            ->with('tag:id,title') //Gọi lại view viết sẵn nên load lại tag
                            ->search($request->get('q'))
                            ->paginate(12),
        ]);
    }
}
