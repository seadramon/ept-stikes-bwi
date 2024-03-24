<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruang;

use DB;
use Hash;
use Log;
use Session;
use Storage;
use Validator;

class RuangController extends Controller
{
    //
    public function index(Request $req)
    {
    	if ($req->search) {
            $q = $req->search;

            $data = Ruang::where('nama', 'like', '%'.$q.'%')->paginate(10);
        } else {
    	   $data = Ruang::paginate(10);
        }

    	return view('admin.ruang.index', [
    		'data' => $data,
    	]);
    }

    public function create(Request $req)
    {
    	$id = null;
    	$data = null;

        if ($req->id) {
            $id = $req->id;
            $data = Ruang::find($id);
        }

    	return view('admin.ruang.create', [
            'id' => $id,
            'data' => $data
    	]);
    }

    public function store(Request $req)
    {
    	try {
            DB::beginTransaction();

    		if ($req->id) {
    			$data = Ruang::find($req->id);
    		} else {
    			$data = new Ruang;
    		}

            $data->nama = $req->nama;

            $data->save();

            DB::commit();
            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('admin.ruang.index', ['role' => $req->role]);
    	} catch(Exception $e) {
    		Log::error(__METHOD__." Failed Create Ruang : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('admin.ruang.create', ['role' => $req->role]);
    	}
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $role = $request->role;

            $data = Ruang::find($id);
            $data->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.ruang.index', ['role' => $role]);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete ruang : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.ruang.create', ['role' => $role]);
        }
    }
}
