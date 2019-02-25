<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Helpers\Content;

use App\Models\Log;
class LogController extends Controller
{
	public function __construct()
	{
		Content::setModule('log');
	}

	public function getIndex(Request $request)
	{
		$list = ['normal', 'error', 'info', 'warning'];

		$logs = Log::search($request->get('q',''))
					->with('user:id,name,alias');
					
		if(!empty($request->level) && is_string($request->level) && in_array($request->level, $list)){
			$logs->where('level', $request->level);
		}

		$level = [];
		foreach ($list as $l) {
			$level[$l] = __($l);
		}

		return Content::render([
			'function' => 'index',
			'title' => __('Nhật kí'),
			'logs' => $logs->orderBy('created_at', 'desc')->paginate(12),
			'levels' => $level
		]);
	}

	public function getInfo(Request $request, $id)
	{
		$log = Log::with('user:id,name')->find($id);
		if(empty($log)){
			return Content::error(404);
		}

		return Content::render([
			'function' => 'info',
			'title' => __('Nhật kí'),
			'log' => $log
		]);
	}

	public function getDelete(Request $request, $id)
	{
		$log = Log::find($id);
		if (empty($log)){
			return Content::error(404);
		}

		return Content::render([
			'title' => __('Xóa nhật ký'),
			'function' => 'delete',
			'log' => $log,
		]);
	}

	public function delete(Request $request, $id)
	{
		$log = Log::find($id);
		if (empty($log)){
			return Content::error(404);
		}

		$log->delete();
		return redirect()->route('admin.log.index');
	}

}	