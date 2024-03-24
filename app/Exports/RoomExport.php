<?php

namespace App\Exports;

use App\Models\Monitoring;
use App\Models\Ruang;
use App\Models\Jadwal;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RoomExport implements FromView
{
	function __construct($jadwalId, $ruangId) {
        $this->ruang_id = $ruangId;
        $this->jadwal_id = $jadwalId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$jadwalId = $this->jadwal_id;
        $ruangId = $this->ruang_id;

    	if (!empty($jadwalId)) {
            $ruang = Ruang::find($this->ruang_id);
            $jadwal = Jadwal::find($this->jadwal_id);

            $data = Monitoring::where('jadwal_id', $this->jadwal_id)->get();
        }

        return view('admin.report.print.room-xls', [
            'data' => $data,
            'ruang' => $ruang,
            'jadwal' => $jadwal
        ]);
    }
}
