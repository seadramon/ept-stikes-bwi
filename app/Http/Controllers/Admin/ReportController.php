<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Ruang;
use App\Models\Jadwal;
use App\Models\Monitoring;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantsExport;
use App\Exports\ScheduleExport;
use App\Exports\RoomExport;
use DB;

class ReportController extends Controller
{
    
    public function participantLink()
    {
    	$instansi = User::select('instansi')
    		->where('role', 'peserta')
    		->groupBy('instansi')
    		->get()->pluck('instansi', 'instansi')->toArray();

    	return view('admin.report.form.participant', [
    		'instansi' => $instansi
    	]); 
    }

    public function participantPdf(Request $request)
    {
    	$instansi = $request->instansis;

    	if (!empty($instansi)) {
	    	$data = User::where('role', 'peserta')
	    		->where('instansi', $instansi)
	    		->get();
	    } else {
	    	$instansi = "All";
	    	$data = User::where('role', 'peserta')
	    		->get();
	    }

    	$pdf = Pdf::loadView('admin.report.print.participant', [
            'data' => $data,
            'instansi' => $instansi
        ]);

        $filename = "Participant-Report";

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }

    public function participantXls(Request $request)
    {
        $instansi = $request->instansis;
        
    	return Excel::download(new ParticipantsExport($instansi), 'Participant.xlsx');
    }

    public function roomLink()
    {
        $jadwal = Jadwal::select(
            DB::raw("CONCAT(date(start),' to ',date(end)) AS period"), 'id')->get()->pluck('period', 'id')->toArray();
        $rooms = Ruang::get()->pluck('nama', 'id')->toArray();

    	return view('admin.report.form.room', [
            'jadwal' => $jadwal,
            'rooms' => $rooms,
        ]);
    }

    public function roomPdf(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $ruangId = $request->ruang_id;

        if (!empty($jadwalId)) {
            $ruang = Ruang::find($ruangId);
            $jadwal = Jadwal::find($jadwalId);

            $data = Monitoring::where('jadwal_id', $jadwalId)->get();

            $pdf = Pdf::loadView('admin.report.print.room', [
                'data' => $data,
                'ruang' => $ruang,
                'jadwal' => $jadwal
            ]);

            $filename = "Room-Report";

            return $pdf->setPaper('a4', 'portrait')
                ->stream($filename . '.pdf');
        } else {
            return back();
        }
    }

    public function roomXls(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $ruangId = $request->ruang_id;
        
        return Excel::download(new RoomExport($jadwalId, $ruangId), 'Room.xlsx');
    }


    public function scheduleLink()
    {
        $ruang = Ruang::get()->pluck('nama', 'id')->toArray();

        $pengawas = User::where('role', 'pengawas')
                ->get()->pluck('name', 'id')->toArray();

		return view('admin.report.form.schedule', [
            'ruang' => $ruang,
            'pengawas' => $pengawas
        ]);
    }

    public function schedulePdf(Request $request)
    {
        $ruangId = $request->ruang_id;
        $pengawasId = $request->pengawas_id;

        $ruang = Ruang::find($ruangId);
        $pengawas = User::find($pengawasId);

        $data = Jadwal::whereRaw("NOW() <= START OR NOW() <= END");
        
        if (!empty($ruangId)) {
            $data->where('ruang_id', $ruangId);
        }

        if (!empty($pengawasId)) {
            $data->where('pengawas_id', $pengawasId);
        }

        $data = $data->get();

        $pdf = Pdf::loadView('admin.report.print.schedule', [
            'data' => $data,
            'ruang' => $ruang,
            'pengawas' => $pengawas,
        ]);

        $filename = "Schedule-Report";

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }

    public function scheduleXls(Request $request)
    {
        $ruangId = $request->ruang_id;
        $pengawasId = $request->pengawas_id;
        
        return Excel::download(new ScheduleExport($ruangId, $pengawasId), 'Schedule.xlsx');
    }

    public function getRooms(Request $request)
    {
        // dd($request->ruang_id);
        $data = Jadwal::where('ruang_id', $request->ruang_id)
            ->whereRaw("(NOW() <= START OR NOW() <= END)")
            ->select(DB::raw("CONCAT(date(start),' to ',date(end)) AS period"), 'id')
            ->get()
            ->pluck('period', 'id')
            ->toArray();

        return response()->json($data);
    }
}
