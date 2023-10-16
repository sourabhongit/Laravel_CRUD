<?php

namespace App\Http\Controllers;

use App\Models\ExportCSV;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CsvController extends Controller
{
    protected $_action;
    public function __construct()
    {
        $this->_action = request('_action');
    }
    public function index()
    {
        return view($this->_action['view']);
    }
    public function import(Request $request)
    {
        //* Import selected columns
        $file = $request->file('file');
        $fileContents = file($file->getPathname());

        // Get the headers from the first line of the CSV
        $headers = str_getcsv(array_shift($fileContents));
        $columnsToImport = ['name', 'email'];

        foreach ($fileContents as $line) {
            $data = str_getcsv($line);
            $selectedData = [];

            // Iterate through the headers and find the indexes of the columns to import
            foreach ($columnsToImport as $column) {
                $index = array_search($column, $headers);
                if ($index !== false) {
                    $selectedData[$column] = $data[$index];
                }
            }
            ExportCSV::create($selectedData);
        }

        return redirect()->route($this->_action['redirect'])->with('success', 'CSV file imported successfully.');

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
    }
    public function edit()
    {
        $csvs = ExportCSV::get();
        if ($csvs) {
            return view($this->_action['view'], compact('csvs'));
        }
        return redirect()->route($this->_action['redirect'])->with('error', 'Not able to get data.');
    }
    public function export()
    {
        $exportcsv = ExportCSV::all();
        $csvFileName = 'export.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Name', 'Email']);

        foreach ($exportcsv as $csv) {
            fputcsv($handle, [$csv->name, $csv->email]);
        }

        fclose($handle);

        return Response::make('', 200, $headers);
    }
}
