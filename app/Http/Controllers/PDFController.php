<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Categories;

class PDFController extends Controller
{
	public function generatePDF()
	{
		$categories = Categories::get();
		$pdf = PDF::loadView('categories_pdf', compact('categories'));
		// return $pdf->download('categories.pdf');
		return $pdf->stream();
	}
}
