<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use Illuminate\Pagination\LengthAwarePaginator;

use App;

use App\Models\Language;
class LanguageController extends Controller
{
	public function __construct()
	{
		Content::setModule('language');
	}

	public function getIndex(Request $request)
	{
		return Content::render([
			'title' => __('Ngôn ngữ'),
			'function' => 'index',
			'languages' => Language::search($request->get('q',''))->paginate(12)
		]);
	}

	public function check($alias, &$response, &$language)
	{
		$language = Language::find($alias);
		if(empty($language)){
			$response = Content::error(404);
			return false;
		}
		return true;
	}
}