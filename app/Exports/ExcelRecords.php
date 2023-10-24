<?php

namespace App\Exports;

// use App\Models\ExcelRecord;
use App\Models\Record;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\WithCustomStartCell;


class ExcelRecords implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithMapping, WithEvents
// WithCustomStartCell
{
	/**
	 * @return \Illuminate\Support\Collection
	 */
	protected $counter = 0;
	protected $totalDebit = 0;
	protected $totalCredit = 0;

	// protected $totalPrice = 0;
	// protected $totalPrice1 = 0;
	// protected $totalPrice2 = 0;

	// public function collection()
	// {
	// 	return ExcelRecord::select('first_name', 'last_name')->get();
	// }

	// public function startCell(): string
	// {
	// 	return 'A2';
	// }

	// public function headings(): array
	// {
	// 	return [
	// 		'SN',
	// 		'First Name',
	// 		'Last Name',
	// 	];
	// }

	// public function map($record): array
	// {
	// 	$this->counter++;
	// 	$this->totalPrice += $record->first_name;
	// 	$this->totalPrice1 += $record->last_name;
	// 	return [
	// 		$this->counter,
	// 		$record->first_name,
	// 		$record->last_name,
	// 	];
	// }

	public function styles(Worksheet $sheet)
	{
		$cellRange = 'A1:W1';
		$sheet->getStyle($cellRange)->getFont()->setBold(true);
	}

	// public function registerEvents(): array
	// {
	// 	return [
	// 		AfterSheet::class => function (AfterSheet $event) {
	// 			$now = now()->timezone('Asia/Kolkata');
	// 			$dateTimeRow = [
	// 				'Date' => $now->format('d-m-y'),
	// 				'Time' => $now->format('H:i:s'),
	// 			];
	// 			$event->sheet->getDelegate()->insertNewRowBefore(1);
	// 			$event->sheet->getDelegate()->mergeCells('A1:C1');
	// 			$event->sheet->getDelegate()->setCellValue('A1', 'Date: ' . $dateTimeRow['Date'] . ' | ' . 'Time: ' . $dateTimeRow['Time']);
	// 			$event->sheet->getDelegate()->setCellValue('A' . ($this->counter + 3), 'Total: ');
	// 			$event->sheet->getDelegate()->setCellValue('B' . ($this->counter + 3), $this->totalPrice);
	// 			$event->sheet->getDelegate()->setCellValue('C' . ($this->counter + 3), $this->totalPrice1);
	// 		},
	// 	];
	// }

	//* Records Export
	public function collection()
	{
		return Record::select('date', 'description', 'debit', 'credit')->where('status', 1)->get();
	}

	// public function collection()
	// {
	// 	$records = Record::where('status', 1)->get();
	// 	$this->totalDebit = $records->sum('debit');
	// 	$this->totalCredit = $records->sum('credit');
	// 	$this->closingBalance = $this->totalCredit - $this->totalDebit;

	// 	return $records;
	// }
	public function headings(): array
	{
		return [
			'S.N.',
			'Date',
			'Description',
			'debit',
			'credit',
		];
	}

	public function map($record): array
	{
		$this->counter++;
		$this->totalDebit += $record->debit;
		$this->totalCredit += $record->credit;
		return [
			$this->counter,
			$record->date,
			$record->description,
			$record->debit,
			$record->credit,
		];
	}
	public function registerEvents(): array
	{
		return [
			AfterSheet::class => function (AfterSheet $event) {
				$rowNumber = $event->sheet->getDelegate()->getHighestRow() + 1;
				$event->sheet->getDelegate()->setCellValue('C' . $rowNumber, 'Total: ');
				$event->sheet->getDelegate()->setCellValue('D' . $rowNumber, $this->totalDebit);
				$event->sheet->getDelegate()->setCellValue('E' . $rowNumber, $this->totalCredit);
				$event->sheet->getDelegate()->setCellValue('C' . ($rowNumber + 1), 'Closing Balance: ');
				$event->sheet->getDelegate()->setCellValue('E' . ($rowNumber + 1), $this->totalCredit - $this->totalDebit);
			},
		];
	}
}
