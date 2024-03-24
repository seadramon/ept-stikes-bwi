<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Monitoring;
use App\Models\User;
use App\Models\Jadwal;

use DB;
use Log;
use Session;
use Storage;
use Validator;

class MonitoringController extends Controller
{
    //
    public function index($jadwalId, Request $request)
    {
    	if ($request->search) {
            $q = $request->search;

            $data = Monitoring::whereHas('user', function(Builder $query) use($q){
            		$query->where('nomor_induk', 'like', '%'.$q.'%')
            			->orWhere('name', 'like', '%'.$q.'%');
            	})
            	->where('jadwal_id', $jadwalId)
        		->paginate(20);
        } else {
        	$data = Monitoring::where('jadwal_id', $jadwalId)
        		->paginate(20);
        }

        $jadwal = Jadwal::find($jadwalId);

        $pesertas = User::where('role', 'peserta')
            ->whereDoesntHave('monitoring', function (Builder $query) use($jadwalId){
                $query->where('jadwal_id', $jadwalId);
            })
            ->get();

    	$selpeserta = [];
    	foreach ($pesertas as $peserta) {
    		$selpeserta[$peserta->id] = $peserta->name;
    	}

        $group = [
            'student' => 'Student',
            'lecturer' => 'Lecturer'
        ];

    	return view('admin.monitoring.index', [
    		'data' => $data,
    		'peserta' => $selpeserta,
    		'jadwal_id' => $jadwalId,
            'jadwal' => $jadwal,
            'group' => $group,
    	]);
    }

    public function store(Request $request)
    {
    	try {
            DB::beginTransaction();

            $jadwalid = $request->jadwal_id;

            $exist = Monitoring::where('jadwal_id', $jadwalid)
            	->where('user_id', $request->user_id)
            	->count();

            if ($exist < 1) {
            	$data = new Monitoring;
            	$data->user_id = $request->user_id;
                $data->group = $request->group;
            	$data->jadwal_id = $jadwalid;
            	$data->status = 1;

            	$data->save();
            	
            	DB::commit();
            	Session::flash('success', 'Data berhasil ditambahkan');
            } else {
            	Session::flash('error', 'Data sudah ada');
            }

            return redirect()->route('admin.monitoring.index', ['jadwal_id' => $jadwalid]);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Jadwal : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal ditambahkan');
            return redirect()->route('admin.monitoring.index', ['jadwal_id' => $jadwalid]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            DB::beginTransaction();

            $id = $request->id;

            $data = Monitoring::find($id);
            $data->status = $request->status;
            $data->save();

            DB::commit();
            Session::flash('success', 'Status Berhasil diubah');

            return response()->json(['result' => 'success']);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Change Status Peserta : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Status Gagal diubah');

            return response()->json(['result' => 'failed']);
        }
    }

    public function delete($userid, $jadwalid)
    {
        try {
            DB::beginTransaction();

            $data = Monitoring::where('user_id', $userid)
            	->where('jadwal_id', $jadwalid)
            	->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.monitoring.index', ['jadwal_id' => $jadwalid]);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Jadwal : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.monitoring.index', ['jadwal_id' => $jadwalid]);
        }
    }
}
