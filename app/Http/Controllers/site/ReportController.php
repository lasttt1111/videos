<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;
use Auth;

use App\Models\Video;
use App\Models\Report;
class ReportController extends Controller
{
	public function __construct()
	{
		Content::setModule('report');
	}

	public function check($request, $alias, &$response, &$video)
	{
		$video = Video::commonSelect()->findAlias($alias)->first();
		if(empty($video)){
			$response = Content::error(404);
			return false;
		}

		$checkView = [];

		$app = new VideoController;
		$app->checkView($request, $video, $checkView);

		if (!$app->checkTotal($checkView)){
			$response = Content::error(403);
			return false;
		}
		return true;
	}

	public function getReport(Request $request, $alias, array $appends = [])
	{
		if (!$this->check($request, $alias, $response, $video)){
			return $response;
		}

		Content::setModule('report');
		return Content::render([
			'title' => __('Báo cáo'),
			'function' => 'index',
			'video' => $video,
		] + $appends);
	}

	public function postReport(\App\Http\Requests\Site\PostReportRequest $request, $alias)
	{
		if (!$this->check($request, $alias, $response, $video)){
			return $response;
		}

		Report::create([
			'video_id' => $video->id,
			'message' => $request->message,
			'user_id' => Auth::user()->id,
			'ip' => $request->ip(),
		]);

		return $this->getReport($request, $alias, ['success' => __('Thành công')]);
	}
}