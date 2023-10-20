<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecordLog;

class RecordLogsController extends Controller
{
	public function index()
	{
		$logs = RecordLog::get();
		return view('log.index', compact('logs'));
	}
	public function log(Request $request)
	{
		$userID = auth()->user()->id;
		$log = new RecordLog();
		$log->user_id = $userID;
		$log->record_id = $request->record_id;
		$log->new_status = $request->new_status;
		$log->remark = $request->action;
		$log->save();
		return response()->json(['message' => 'log entry created.']);
	}
}
