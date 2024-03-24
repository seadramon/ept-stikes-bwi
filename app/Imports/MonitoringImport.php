<?php

namespace App\Imports;

use App\Models\Monitoring;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MonitoringImport implements ToModel, WithStartRow
{
    protected $jadwal_id;

    public function __construct($jadwal_id)
    {
        $this->jadwal_id = $jadwal_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nim = $row[0];
        $peserta = User::where('nomor_induk', $nim)->first();

        Monitoring::where('jadwal_id', $this->jadwal_id)
            ->where('user_id', $peserta->id)
            ->delete();

        return new Monitoring([
            'jadwal_id' => $this->jadwal_id,
            'user_id' => $peserta->id,
            'status' => 1
        ]);
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
