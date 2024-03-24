<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['part_id', 'story', 'question', 'choice_a', 'choice_b', 'choice_c', 'choice_d', 'answer','urutan'];

    public function part()
    {
    	return $this->belongsTo(Part::class, 'part_id', 'id');
    }
}
