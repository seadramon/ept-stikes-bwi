<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory, SoftDeletes;

    public function section()
    {
    	return $this->belongsTo(Section::class, 'section_id', 'id');
    }

    public function question()
    {
    	return $this->hasMany(Question::class, 'part_id', 'id');
    }
}
