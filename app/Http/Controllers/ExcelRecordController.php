<?php

namespace App\Http\Controllers;

// use App\Models\ExcelRecord;
use App\Models\Record;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelRecords;
// use App\Exports\ExcelRecords as ExportExcelRecords;

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
		$Records = Record::all();
		if ($Records) {
			return view($this->_action['view'], compact('Records'));
		}
	}

	public function import(Request $request)
	{
		$import = new ExcelRecords;
		$importedData = Excel::toCollection($import, $request->file('recordsFile'));
		// $importedData = Excel::import($import, $request->file('recordsFile'));
		$data = $importedData[0];
		return response()->json($data);
	}
	public function saveData(Request $request)
	{
		dd($request->all());
		$requestedRecords = $request->input('records');
		$recordsToInsert = [];
		foreach ($requestedRecords as $requestedRecord) {
			$record = new Record;
			array_shift($requestedRecord);
			$dateString = $requestedRecord[0];
			$date = date_create_from_format('d M Y', $dateString);
			$record = [
				'date' => $date ? $date->format('Y-m-d') : null,
				'type' => $requestedRecord[1],
				'description' => $requestedRecord[2],
				'debit' => ($requestedRecord[3] === 'null') ? null : $requestedRecord[3],
				'credit' => ($requestedRecord[4] === 'null') ? null : $requestedRecord[4],
				'status' => ($requestedRecord[5] === 'false') ? 0 : 1,
			];
			$recordsToInsert[] = $record;
		}
		if (!empty($recordsToInsert)) {
			Record::insert($recordsToInsert);
		}
		return response()->json($data = ['redirect' => 'admin.records.index'], 200);
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
}
