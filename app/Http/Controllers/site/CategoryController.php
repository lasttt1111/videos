<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;

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
            'function' => 'index',
            'title' => __('Danh mục'),
            'categories' => Category::paginate(12),
        ]);
    }

    public function getInfo(Request $request, $alias)
    {
        $category = Category::select(['id', 'alias', 'title'])
                            ->findAlias($alias)
                            ->first();

        if (empty($category)){
            return Content::error(404);
        }

        $video = $category->video()
                            ->commonSelect()
                            ->where('privacy', 0)
                            ->with(['user' => function($query){
                                $query->info();
                            }])
                            ->paginate(12);

        return Content::render([
            'function' => 'list',
            'video' => $video,
            'category' => $category,
            'title' => $category->title,
        ]);
    }
}
