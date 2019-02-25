<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Content;

use App\Models\Video;
use App\Models\Category;
class HomeController extends Controller
{
    public function getIndex()
    {
        //Xem nhiều nhất
        $most = Video::commonSelect()
                    ->with(['user' => function($query){
                        $query->select(['id', 'alias', 'name']);
                    }])
                    ->where('privacy', 0)
                    ->orderBy('views', 'desc')
                    ->limit(10)
                    ->get();

        $categories = Category::select(['alias', 'title', 'image'])
                                ->get();


        $newest = Video::commonSelect()
                        ->orderBy('created_at', 'desc')
                        ->with(['user' => function($query){
                            $query->select(['id', 'alias', 'name']);
                        }])
                        ->limit(12)
                        ->get();
        return Content::render([
            'title' => __('Trang chia sẻ video'),
            'module' => 'home',
            'function' => 'index',
            'most' => $most,
            'categories' => $categories,
            'newest' => $newest,
            'numberVideo' => Video::where('privacy', 0)->count(),
        ]);
    }
}
