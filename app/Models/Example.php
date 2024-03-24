<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Example extends Model
{
    use HasFactory, SoftDeletes;

    public function part()
    {
    	return $this->belongsTo(Part::class, 'part_id', 'id');
    }
}
