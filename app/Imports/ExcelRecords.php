<?php

namespace App\Imports;

// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ExcelRecords implements ToCollection
{
	public function collection(Collection $rows)
	{
		dd($rows);
	}
	// protected $b1Value = null;
	// public function headingRow(): int
	// {
	// 	return 2;
	// }
	// public function model(array $row)
	// {
	// 	if ($this->b1Value === null) {
	// 		$this->b1Value = $this->getB1Value();
	// 	}

	// 	$columnMapping = [
	// 		'first_name' => 'first_name',
	// 		'last_name' => 'last_name',
	// 		'email' => 'email',
	// 		'number' => 'number',
	// 		'remark' => 'remark',
	// 	];
	// 	$data = [];
	// 	foreach ($columnMapping as $header => $attribute) {
	// 		if (array_key_exists($header, $row)) {
	// 			$data[$attribute] = $row[$header];
	// 		}
	// 		$data['status'] = $this->b1Value;
	// 	}

	// 	return new ExcelRecord($data);
	// }

	// private function getB1Value()
	// {
	// 	$excelFile = public_path('storage/files/tempFile.xlsx');

	// 	$spreadsheet = IOFactory::load($excelFile);
	// 	$worksheet = $spreadsheet->getActiveSheet();

	// 	$b1Value = $worksheet->getCell('B1')->getValue();

	// 	return $b1Value;
	// }
}
