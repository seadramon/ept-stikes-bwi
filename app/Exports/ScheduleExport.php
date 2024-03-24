<?php

namespace App\Exports;

use App\Models\Jadwal;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
    function __construct($ruangId, $pengawasId) {
        $this->ruang_id = $ruangId;
        $this->pengawas_id = $pengawasId;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
    	$ruang = Ruang::find($this->ruang_id);
        $pengawas = User::find($this->pengawas_id);

        $data = Jadwal::whereRaw("NOW() <= START OR NOW() <= END");
        
        if (!empty($this->ruang_id)) {
            $data->where('ruang_id', $this->ruang_id);
        }

        if (!empty($this->pengawas_id)) {
            $data->where('pengawas_id', $this->pengawas_id);
        }

        $data = $data->get();

        return view('admin.report.print.schedule-xls', [
            'data' => $data,
            'ruang' => $ruang,
            'pengawas' => $pengawas
        ]);
    }
}
