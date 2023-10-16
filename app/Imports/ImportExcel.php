<?php

namespace App\Imports;

use App\Models\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportExcel implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $columnMapping = [
            'name' => 'name',
            'email' => 'email',
        ];

        $data = [];
        foreach ($columnMapping as $header => $attribute) {
            dd($row);
            if (array_key_exists($header, $row)) {
                $data[$attribute] = $row[$header];
            }
        }

        return new Excel($data);
    }
}
