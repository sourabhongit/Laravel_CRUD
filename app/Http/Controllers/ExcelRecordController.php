<?php

namespace App\Http\Controllers;

// use App\Models\ExcelRecord;
use App\Models\Record;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelRecords;
use PHPUnit\Framework\Constraint\ArrayHasKey;

use App\Exports\ExcelRecords as ExportExcelRecords;

class ExcelRecordController extends Controller
{
	protected $_action;

	public function __construct()
	{
		$this->_action = request('_action');
	}
	// public function index()
	// {
	// 	$sn = 1;
	// 	$ExcelRecords = ExcelRecord::all();
	// 	if ($ExcelRecords) {
	// 		return view($this->_action['view'], compact('ExcelRecords', 'sn'));
	// 	}
	// }
	// public function import(Request $request)
	// {
	// 	$name = 'tempFile.xlsx';
	// 	Excel::import(new ImportExcelRecords, $request->file('file')->storeAs('files', $name, 'local'));
	// 	return redirect()->route($this->_action['redirect']);
	// }
	// public function export()
	// {
	// 	return Excel::download(new ExportExcelRecords, 'data.xlsx');
	// }
	//* With records modal view and status
	public function index()
	{
		$records = Record::all();
		if ($records) {
			return view($this->_action['view'], compact('records'));
		}
	}

	public function import(Request $request)
	{
		$importedData = Excel::toCollection(new ExcelRecords, $request->file('recordsFile'));
		// $importedData = Excel::import($import, $request->file('recordsFile'));
		$data = $importedData[0];
		return response()->json($data);
	}
	public function saveData(Request $request)
	{
		try {
			for ($i = 0; $i < count($request->date); $i++) {
				$record = new Record;
				$date = date_create_from_format('d M Y', $request->date[$i]);
				$record->date = $date ? $date->format('Y-m-d') : null;
				$record->type = $request->type[$i];
				$record->description = $request->description[$i];
				$record->debit = ($request->debit[$i] === 'null') ? null : $request->debit[$i];
				$record->credit = ($request->credit[$i] === 'null') ? null : $request->credit[$i];
				$record->status = $request->has('status.' . $i) ? 1 : 0;
				$record->save();
			}
		} catch (\Throwable $th) {
			return redirect()->back()->with('error', 'An error occurred while saving records.');
		}
	}

	public function updateStatus(Request $request)
	{
		$recordId = $request->input('record_id');
		$recordStatus = $request->input('record_status');
		$record = Record::find($recordId);

		if ($record) {
			$record->status = $recordStatus;
			$record->save();
		}
	}

	public function export()
	{
		return Excel::download(new ExportExcelRecords, 'dataRecords.xlsx');
	}
}
