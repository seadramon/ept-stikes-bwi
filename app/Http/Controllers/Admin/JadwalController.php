<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Monitoring;
use App\Models\User;
use App\Models\Ruang;
use App\Imports\AssignPeserta;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MonitoringImport;

use DB;
use Log;
use Session;
use Storage;
use Validator;

class JadwalController extends Controller
{
    //
    public function index(Request $request)
    {
        if (\Auth::user()->role == 'pengawas') {
            $data = Jadwal::withCount('monitoring')->where('pengawas_id', \Auth::user()->id)
                // ->whereBetweenColumns(DB::raw("SYSDATE()"), ['start', 'end'])
                ->whereDate('end', '>=', now())
                ->paginate(10);
        } else {
    	   $data = Jadwal::withCount('monitoring')
                ->whereDate('end', '>=', now())
                // ->whereBetweenColumns(DB::raw("SYSDATE()"), ['start', 'end'])
                ->paginate(10);
        }

    	return view('admin.jadwal.index', [
    		'data' => $data
    	]);
    }

    public function create(Request $request)
    {
        $id = $request->id;
    	$data = null;
        $startend = date('d/m/Y 0:00') . ' - ' . date('d/m/Y 23:59');
        $ruang_id = null;
        $pengawas_id = null;
        $paket = null;
        $monitoring = [];

    	$pesertas = User::where('role', 'peserta')->get();
    	$selpeserta = [];
    	foreach ($pesertas as $peserta) {
    		$selpeserta[$peserta->id] = $peserta->name;
    	}

        $ruang = Ruang::get()->pluck('nama', 'id')->toArray();

        if ($id) {
            $data = Jadwal::find($id);
            $ruang_id = $data->ruang_id;
            $pengawas_id = $data->pengawas_id;
            $paket = $data->paket;
            $pengawas = User::where('role', 'pengawas')
                ->get()->pluck('name', 'id')->toArray();

            $startend = date('d/m/Y H:i', strtotime($data->start)) . ' - ' . date('d/m/Y H:i', strtotime($data->end)); 

            $rows = Monitoring::where('jadwal_id', $id)->get();
            if (count($rows) > 0) {
                foreach ($rows as $row) {
                    $monitoring[] = [
                        'id' => $row->user_id,
                        'name' => $row->user->nomor_induk . ' - ' . $row->user->name,
                        'role' => $row->group
                    ];
                }
            }

        } else {
            $pengawas = User::where('role', 'pengawas')
                ->get()->pluck('name', 'id')->toArray();
        }

        $instansi = User::select('instansi')
            ->whereNotNull('instansi')
            ->get()->pluck('instansi', 'instansi')->toArray();

    	return view('admin.jadwal.create', [
            'jadwal_id' => $id,
    		'data' => $data,
            'ruang' => $ruang,
            'pengawas' => $pengawas,
            'ruang_id' => $ruang_id,
            'pengawas_id' => $pengawas_id,
            'startend' => $startend,
    		'peserta' => $selpeserta,
            'instansi' => $instansi,
            'monitoring' => $monitoring,
            'paket' => $paket,
    	]);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'period' => 'required',
                'ruang_id' => 'required',
                'pengawas_id' => 'required'
            ]);

            if ($validator->fails()) {
                Session::flash('error', 'Data gagal disimpan');
                
                return response()->json(['result' => 'failed']);
            }

            $period = explode(" - ", $request->period);
            $start = str_replace("/", "-", $period[0]);
            $end = str_replace("/", "-", $period[1]);

            if ($request->id) {
                $data = Jadwal::find($request->id);
            } else {
                $data = new Jadwal;
            }

            $data->start = date('Y-m-d H:i:s', strtotime($start));
            $data->end = date('Y-m-d H:i:s', strtotime($end));
            $data->paket = $request->paket;
            $data->ruang_id = $request->ruang_id;
            $data->pengawas_id = $request->pengawas_id;

            $data->save();

            $jadwalId = $data->id;
            
            DB::commit();

            Monitoring::where('jadwal_id', $jadwalId)->forceDelete();

            foreach ($request->peserta as $row) {
                $monitoring = new Monitoring;

                $monitoring->jadwal_id = $jadwalId;
                $monitoring->user_id = $row['id'];
                $monitoring->status = 1;
                $monitoring->group = $row['role'];

                $monitoring->save();

                DB::commit();
            }

            return response()->json(['result' => 'success']);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Create Jadwal : ". $e->getMessage());

            DB::rollback();

            return response()->json(['result' => 'failed']);
        }
    }

    public function uploadExcel(Request $request)
    {
        $validation_rules = [
            'inputExcel' => 'required|mimes:xls,xlsx'
        ];

        $validator = Validator::make($request->all(), $validation_rules);
        if ($validator->fails()) {
            return '';
        }

        if ( $request->hasFile('inputExcel') ) {
            $file = $request->file('inputExcel');
            $extension = $file->getClientOriginalExtension();
            $filename = $file->getClientOriginalName();
            $dir = uniqid() . '-' . date('YmdHis');

            $fullpath = $dir . '/' . $filename;
            Storage::disk('public')->put('upload_order_temp/'.$fullpath, \File::get($file));

            return $fullpath;
        }

        return '';
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            Monitoring::where('jadwal_id', $id)->forceDelete();

            $data = Jadwal::find($id)->forceDelete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.jadwal.index');
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Jadwal : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.jadwal.index');
        }
    }

    public function downloadTemplate()
    {
        $file = public_path()."/documents/Participant-in-schedule.xlsx";

        if (file_exists($file)) {
            $headers = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            return \Response::download($file, 'Participant-in-schedule.xlsx',$headers);
        }
    }

    public function getPeserta(Request $request)
    {
        $data = User::where('instansi', $request->instansi)
            ->where('role', 'peserta')
            ->get();

        $selPart = [];
        foreach ($data as $part) {
            $selPart[] = [
                'id' => $part->id . '#' . $part->nomor_induk.' - '.$part->name,
                'text' => $part->nomor_induk.' - '.$part->name
            ];
        }

        return $selPart;
    }
}
