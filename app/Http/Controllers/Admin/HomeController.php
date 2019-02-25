<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;

use App\Models\User;
use App\Models\Video;
use App\Models\Playlist;
class HomeController extends Controller
{
    public function __construct(){
        Content::setModule('home');
    }
    public function getIndex(Request $request)
    {
        return Content::render([
            'title' => __('Trang quản lí'),
            'function' => 'index',
            'userCount' => User::count(),
            'videoCount' => Video::count(),
            'playlistCount' => Playlist::count(),
        ]);
    }
}
