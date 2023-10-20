<?php

namespace App\Exports;

use App\Models\Categories;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportCategories implements FromCollection, WithHeadings
{
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		return Categories::all();
	}
	public function headings(): array
	{
		return [
			"id",
			"category name",
			"number of items",
			"status",
			"created at",
			"last updated",
			"photo"
		];
	}
}
