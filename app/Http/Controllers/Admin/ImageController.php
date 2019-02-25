<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use App\Helpers\Imgur;

use App\Models\Image;
class ImageController extends Controller
{
	public function __construct()
	{
		Content::setModule('image');
	}

	public function getIndex(Request $request)
	{
		return Content::render([
			'title' => __('Quản lí ảnh'),
			'function' => 'index',
			'images' => Image::with('user:id,alias,name')->paginate(12)
		]);
	}

	public function getInfo(Request $request, $id)
	{
		$image = Image::with('user:id,alias,name')->find($id);

		if(empty($image)){
			return Content::error(404);
		}

		return Content::render([
			'title' => __('Hình ảnh'),
			'function' => 'info',
			'image' => $image
		]);	
	}

	public function getDelete(Request $request, $id)
	{
		$image = Image::with('user:id,alias,name')->find($id);

		if(empty($image)){
			return Content::error(404);
		}

		return Content::render([
			'title' => __('Xóa hình ảnh'),
			'function' => 'delete',
			'image' => $image
		]);
	}

	public function delete(Request $request, $id)
	{
		$image = Image::with('user:id,alias,name')->find($id);

		if(empty($image)){
			return Content::error(404);
		}

		Imgur::delete($image);

		return redirect()->route('admin.image.index');
		
	}
}