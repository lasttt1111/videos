<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\GetLink;
use App\Helpers\Imgur;

use App\Models\Category;
use App\Models\Video;
use App\Models\Language;
use App\Models\Tag;

use Auth;

class UploadVideoController extends Controller
{
	public function __construct()
	{
		Content::setModule('upload_video');
	}

	protected function make(&$categories, &$languages, &$tags)
	{
		$categoryList = Category::select(['id', 'title'])->get();
		$categories = [];
		foreach ($categoryList as $c)
		{
			$categories[$c->id] = $c->title;
		}

		$languageList = Language::select(['id', 'name'])->get();
		$languages = [];
		foreach ($languageList as $l)
		{
			$languages[$l->id] = $l->name;
		}
		$languages['oth'] = __('Khác');

		$tagList = Tag::select(['id', 'title'])->get();
		$tags = [];
		foreach ($tagList as $t)
		{
			$tags[$t->id] = $t->title;
		}
	}

	public function addTags(Video $video, $tags)
	{
		if(empty($tags) || !is_array($tags)){
			return;
		}

		foreach ($tags as $tag){
			if (!is_string($tag)){
				return;
			}
		}

		$tags = Tag::select(['id'])->whereIn('id', $tags)->get();
		$tags = $tags->pluck('id')->all();
		$video->tags()->sync($tags);
	}

	public function getUpload(Request $request)
	{
		$this->make($categories, $languages, $tags);

		return Content::render([
			'title' => __('Thêm video mới'),
			'function' => 'add',
			'categories' => $categories,
			'languages' => $languages,
			'tags' => $tags,
		]);
	}

	public function postUpload(\App\Http\Requests\Site\PostVideoRequest $request)
	{
		$alias = str_slug($request->title);
		$check = Video::select(['id'])->findAlias($alias)->first();

		if (!empty($check)){
			$alias = str_limit($alias, 100, '');
			$alias .= "-" . str_random(15);
		}

		if ($request->language != 'oth'){
			$check = Language::find($request->language);
			if (empty($check)){
				return $this->getUpload($request)
							->withErrors(['language.*' => __('Ngôn ngữ không chính xác')]);
			}
		}

		if($request->hasFile('video')){
			$file = $request->file('video');
			$fileName = $file->getClientOriginalName();
			$path = public_path().'\uploads\\';
            $file->move($path, $fileName);
			$link = 'http://localhost:81/videos/public/uploads/' . $fileName;
		}

		$video = Video::create(
			$request->only(['title', 'label', 'description', 'language', 'privacy', 'password', 'price'])
			+ [
				'alias' => $alias,
				'image' => Imgur::save($request->file('image')),
				'user_id' => Auth::user()->id,
				'category_id' => $request->category,
				'link' => $link,
		]);

		//Đồng bộ tags
		$this->addTags($video, $request->get('tags'));

		return redirect()->route('site.watch', ['alias' => $alias]);
	}

	public function getEdit(Request $request, $alias)
	{
		//Tìm Video
		$video = Video::findAlias($alias)
						->with('tags:id,title')
						->first();
		if (empty($video)){
			return Content::error(404);
		}

		if(Auth()->user()->permission > 2 && $video->user_id != Auth::user()->id){
			return Content::error(403);
		}

		$this->make($categories, $languages, $tags);

		return Content::render([
			'title' => __('Chỉnh sửa video :video',['video' => $video->title]),
			'function' => 'edit',
			'video' => $video,
			'categories' => $categories,
			'languages' => $languages,
			'tags' => $tags,
		]);
	}

	public function putEdit(\App\Http\Requests\Site\PutVideoRequest $request, $alias)
    {
    	
        $video = Video::findAlias($alias)->first();
        if (empty($video)){
            return Content::error(404);
        }

        if (Auth::user()->permission > 2 && $video->user_id != Auth::user()->id){
            return Content::error(403);
        }

        if ($request->language != 'oth'){
            $check = Language::find($request->language);
            if (empty($check)){
                return $this->getUpload($request)
                            ->withErrors(['language.*' => __('Ngôn ngữ không chính xác')]);
            }
        }

        $video->fill($request->only(['title', 'description', 'language', 'privacy', 'price', 'password', 'price']));

        $video->category_id = $request->category;

        if ($request->hasFile('image')){
            $video->image = Imgur::save($request->file('image'));
        }

        if ($request->has('remove-password')){
            $video->password = null;
        }

        $video->save();

        //Đồng bộ tags
        $this->addTags($video, $request->get('tags'));

        return $this->getEdit($request, $alias);
    }

    public function delete(Request $request, $alias)
    {
        $video = Video::findAlias($alias)->first();
        if (empty($video)){
            return response()->json(['status' => 404], 404);
        }

        if (Auth::user()->permission > 2 && $video->user_id != Auth::user()->id){
           return response()->json(['status' => 403], 403);
        }

        $video->delete();

        return response()->json(['status' => 200], 200);
    }
}