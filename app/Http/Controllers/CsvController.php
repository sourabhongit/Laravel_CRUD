<?php

namespace App\Http\Controllers;

use App\Models\Record;
use App\Imports\CsvRecords;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\csvRecords as ExportCsvRecords;
// use App\Models\CsvRecord;
// use App\Exports\csvRecords as ExportCsvRecords;

class CsvController extends Controller
{
	protected $_action;
	public function __construct()
	{
		$this->_action = request('_action');
	}
	// public function index()
	// {
	// 	$sn = 1;
	// 	$csvRecords = CsvRecord::all();
	// 	if ($csvRecords) {
	// 		return view($this->_action['view'], compact('csvRecords', 'sn'));
	// 	}
	// 	return view($this->_action['view']);
	// }
	// public function import(Request $request)
	// {
	//* Import selected columns
	// $file = $request->file('file');
	// $fileContents = file($file->getPathname());
	// Specify how many rows you need from the file.
	// $fileContents = array_slice($fileContents, 0, 5);
	// Get the headers from the first line of the CSV
	// $headers = str_getcsv(array_shift($fileContents));

	// Converting into lowers case and reassigning values to $headers array
	// foreach ($headers as $key => $header) {
	// 	$headers[$key] = strtolower($header);
	// }
	// $columnsToImport = [
	// 	'first_name',
	// 	'last_name',
	// 	'email',
	// 	'number',
	// 	'remark',
	// ];

	// foreach ($fileContents as $line) {
	// 	$data = str_getcsv($line);
	// 	$selectedData = [];

	// 	// Iterate through the headers and find the indexes of the columns to import
	// 	foreach ($columnsToImport as $column) {
	// 		$column = strtolower($column);
	// 		$index = array_search($column, $headers);
	// 		if ($index !== false) {
	// 			$selectedData[$column] = $data[$index];
	// 		}
	// 		$selectedData['status'] = 'exampleStatus';
	// 	}
	// 	CsvRecord::create($selectedData);
	// }

	// return redirect()->route($this->_action['redirect'])->with('success', 'CSV file imported successfully.');

	//* Import whole document
	// $file = $request->file('file');
	// $fileContents = file($file->getPathname());
	// dd($fileContents);


	// foreach ($fileContents as $line) {
	//     $data = str_getcsv($line);

	//     ExportCSV::create([
	//         'name' => $data[0],
	//         'email' => $data[1],
	//     ]);
	// }
	// return redirect()->route($this->_action['redirect'])->with('success', 'CSV file imported successfully.');
	// }
	// public function export()
	// {
	// 	return Excel::download(new ExportCsvRecords, 'data.csv', \Maatwebsite\Excel\Excel::CSV, [
	// 		'Content-Type' => 'text/csv',
	// 	]);
	// }
	//* Export without maatwebsite
	// public function export()
	// {
	// 	$exportcsv = ExportCSV::all();
	// 	$csvFileName = 'export.csv';
	// 	$headers = [
	// 		'Content-Type' => 'text/csv',
	// 		'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
	// 	];

	// 	$handle = fopen('php://output', 'w');
	// 	fputcsv($handle, ['Name', 'Email']);

	// 	foreach ($exportcsv as $csv) {
	// 		fputcsv($handle, [$csv->name, $csv->email]);
	// 	}

	// 	fclose($handle);

	// 	return Response::make('', 200, $headers);
	// }
	// function transposeData($data)
	// {
	// 	$retData = array();

	// 	foreach ($data as $row => $columns) {
	// 		foreach ($columns as $row2 => $column2) {
	// 			$retData[$row2][$row] = $column2;
	// 		}
	// 	}
	// 	return $retData;
	// }

	//* Records export & import
	public function index()
	{
		$records = Record::get();
		if ($records) {
			return view($this->_action['view'], compact('records'));
		}
	}

	public function import(Request $request)
	{
		$importedData = Excel::toCollection(new CsvRecords, $request->file('recordsFile'));
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

	public function export()
	{
		return Excel::download(new ExportCsvRecords, 'dataRecords.csv');
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
