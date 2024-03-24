<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function part()
    {
    	return $this->hasMany(Part::class, 'section_id', 'id');
    }
}
