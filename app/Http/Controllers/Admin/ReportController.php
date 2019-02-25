<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;

use App\Models\Report;
class ReportController extends Controller
{
	public function __construct()
	{
		Content::setModule('report');
	}

	public function getIndex(Request $request)
	{
		return Content::render([
			'title' => __('Báo cáo'),
			'function' => 'index',
			'reports' => Report::with('user:id,alias,name')->paginate(12)
		]);
	}

	public function getInfo(Request $request, $id)
	{
		$report = Report::with('user:id,alias,name')->find($id);
		if(empty($report)){
			return Content::error(404);
		}

		return Content::render([
			'title' => __('Chi tiết báo cáo'),
			'function' => 'info',
			'report' => $report
		]);
	}

	public function getDelete(Request $request, $id)
	{
		$report = Report::find($id);
		if(empty($report)){
			return Content::error(404);
		}

		return Content::render([
			'title' => __('Xóa báo cáo'),
			'function' => 'delete',
			'report' => $report
		]);
	}

	public function delete(Request $request, $id)
	{
		$report = Report::find($id);
		if(empty($report)){
			return Content::error(404);
		}

		$report->delete();
		return redirect()->route('admin.report.index');
	}
}	