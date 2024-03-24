<?php
namespace App\Services;

use App\Models\User;
use App\Models\Jadwal;
use DB;

/**
 * 
 */
class MonitoringService
{
	
	public function removeJadwalPeserta($jadwal_id)
	{
		$data = User::where('jadwal_id', $jadwal_id)
			->update([
				'jadwal_id' => null,
				'status' => '0'
			]);

		return $data;
	}

	public function discPeserta($jadwal_id)
	{
		$data = User::where('jadwal_id', $jadwal_id)
			->update([
				'status' => '2'
			]);

		return $data;
	}
}