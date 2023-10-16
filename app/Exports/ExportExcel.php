<?php

namespace App\Exports;

use App\Models\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportExcel implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Excel::all();
    }
}
