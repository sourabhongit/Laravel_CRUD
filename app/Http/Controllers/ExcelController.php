<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel as ExcelPack;
use App\Imports\ImportExcel;
use App\Exports\ExportExcel;
use App\Models\Excel;

class ExcelController extends Controller
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
        ExcelPack::import(new ImportExcel, $request->file('file')->store('files'));
        return redirect()->route($this->_action['redirect']);
    }
    public function export()
    {
        return ExcelPack::download(new ExportExcel, 'data.xlsx');
    }
    public function edit()
    {
        $excels = Excel::all();
        if ($excels) {
            return view($this->_action['view'], compact('excels'));
        }
    }
}
