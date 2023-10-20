<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordLog extends Model
{
	use HasFactory;
	protected $fillable = [
		'user_id',
		'record_id',
		'new_status',
		'remark',
	];

	public function users()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
