<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';

    public function Categories()
    {
        return $this->belongsTo(Categories::class,'category_id','id');
    }
}
