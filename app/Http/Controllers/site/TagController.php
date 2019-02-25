<?php

namespace App\Http\Controllers\Site;

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

    public function getInfo(Request $request, $alias)
    {
        $tag = Tag::findAlias($alias)->first();
        if (empty($tag)){
            return Content::error(404);
        }

        return Content::render([
            'title' => __('Thẻ :tag', ['tag' => $tag->title]),
            'function' => 'info',
            'tag' => $tag,
            'video' => $tag->video()
                            ->search($request->get('q', ''))
                            ->paginate(12)
        ]);
    }
}
