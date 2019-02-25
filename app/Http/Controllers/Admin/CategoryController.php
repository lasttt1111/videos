<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;

use App\Models\Category;
class CategoryController extends Controller
{
    public function __construct()
    {
        Content::setModule('category');
    }

    public function getIndex(Request $request)
    {
        return Content::render([
            'title' => __('Danh mục'),
            'function' => 'index',
            'categories' => Category::search($request->get('q', ''))
                                    ->withCount('video')
                                    ->paginate(12)
        ]);
    }

   public function check($alias, &$response, &$category)
   {
        $category = Category::findAlias($alias)->first();

        if (empty($category)){
            $response = Content::error(404);
            return false;
        }
        return true;
   }

    public function getEdit(Request $request, $alias, array $appends = [])
    {
        if(!$this->check($alias, $response, $category)){
            return $response;
        }   

        return Content::render([
            'title' => __('Chỉnh sửa danh mục'),
            'function' => 'edit',
            'category' => $category,
        ] + $appends);
    }

    public function putEdit(\App\Http\Requests\Admin\PutCategoryRequest $request, $alias)
    {
        if(!$this->check($alias, $response, $category)){
            return $response;
        }

        if (!empty($request->alias) && $request->alias != $alias){
            $check = Category::findAlias($request->alias)->first();
            if (!empty($check)){
                return $this->getEdit($request, $alias)->withErrors(['alias.unique' => __('Định danh trùng')]);
            }
            $category->alias = $request->alias;
        }

        $category->fill($request->only(['title']));

        if ($request->hasFile('image')){
            $category->image = Imgur::save($request->file('image'));
        }

        $category->save();

        return $this->getEdit($request, $category->alias, ['success' => __('Thành công')]);
    }

    public function getAdd(Request $request, array $appends = []){
        return Content::render([
            'title' => __('Thêm mới danh mục'),
            'function' => 'add',
        ] + $appends);
    }

    public function postAdd(\App\Http\Requests\Admin\PostCategoryRequest $request)
    {
        if (empty($request->alias)){
            $request->merge(['alias' => str_slug($request->title)]);

            if (empty($request->alias)){
                $request->merge(['alias' => str_random(12)]);
            }
        }

        $category = new Category;

        $check = Category::findAlias($request->alias)->first();

        if (empty($check)){
            $category->alias = $request->alias;
        } else {
            $category->alias = $request->alias.'-'.str_random(12);
        }

        $category->fill($request->only(['title']));
        $category->image = Imgur::save($request->file('image'));
        $category->save();

        return $this->getAdd($request, ['success' => __('Thành công')]);
    }

    public function getDelete(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $category)){
            return $response;
        }

        return Content::render([
            'title' => __('Xóa danh mục'),
            'function' => 'delete',
            'category' => $category,
        ]);
    }

    public function delete(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $category)){
            return $response;
        }
        if ($category->video()->count() > 0){
            return $this->getDelete($request, $alias)
                        ->withErrors([
                            'video.delete' => __('Vui lòng xóa hết video thuộc danh mục này')
                        ]);
        }

        $category->delete();

        return redirect()->route('admin.category.index');
    }

    public function getInfo(Request $request, $alias)
    {
        if(!$this->check($alias, $response, $category)){
            return $response;
        }

        return Content::render([
            'title' => __('Chi tiết danh mục'),
            'function' => 'info',
            'category' => $category,
            'video' => $category->video()
                                ->with('category:id,title') //Gọi lại view viết sẵn nên load lại category
                                ->search($request->get('q'))
                                ->paginate(12),
        ]);
    }
}
