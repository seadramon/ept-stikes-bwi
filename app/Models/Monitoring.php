<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jadwal_id', 'status', 'section1_answer', 'section2_answer', 'section3_answer', 'section_1', 'section_2', 'section_3', 'total', 'start', 'finish'];

    public function user()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function jadwal()
    {
    	return $this->belongsTo(Jadwal::class, 'jadwal_id', 'id');
    }
}
