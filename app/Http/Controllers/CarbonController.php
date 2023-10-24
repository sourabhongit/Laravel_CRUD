<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CarbonController extends Controller
{
	//* Calculate age
	public function index()
	{
		return view('carbon.age.index');
	}
	public function calculateAge(Request $request)
	{
		$this->validate($request, [
			'date_of_birth' => 'required|date',
			'current_date' => 'required|date',
		]);

		$birthDate = Carbon::parse($request->input('date_of_birth'));
		$currentDate = Carbon::parse($request->input('current_date'));
		$age = $currentDate->diffInYears($birthDate);
		return response()->json($age);
	}
}
