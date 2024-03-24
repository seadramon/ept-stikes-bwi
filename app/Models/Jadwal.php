<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    public function ruang()
    {
    	return $this->belongsTo(Ruang::class, 'ruang_id', 'id');
    }

    public function pengawas()
    {
    	return $this->belongsTo(User::class, 'pengawas_id', 'id');
    }

    public function monitoring()
    {
    	return $this->hasMany(Monitoring::class, 'jadwal_id', 'id');
    }
}
