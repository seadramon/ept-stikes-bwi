<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ParticipantsExport implements FromView
{
	function __construct($instansi) {
        $this->instansi = $instansi;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        if (!empty($this->instansi)) {
	    	$data = User::where('role', 'peserta')
	    		->where('instansi', $this->instansi)
	    		->get();
	    } else {
	    	$data = User::where('role', 'peserta')
	    		->get();
	    }

        return view('admin.report.print.participant-xls', [
            'data' => $data,
            'instansi' => $this->instansi
        ]);
    }
}
