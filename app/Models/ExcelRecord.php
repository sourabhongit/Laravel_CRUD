<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcelRecord extends Model
{
	use HasFactory;

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'number',
		'remark',
		'status',
	];
}
