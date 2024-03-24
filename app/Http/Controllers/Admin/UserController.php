<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\UsersImport;
use App\Services\UserService;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredential;
use App\Mail\ResetPassword;

use DB;
use Hash;
use Log;
use Session;
use Storage;
use Validator;

class UserController extends Controller
{
    
    public function index(Request $req, $role)
    {
        if ($req->search) {
            $q = $req->search;

            $data = User::where('role', $role)
                ->where(function($query) use($q) {
                    $query->where('name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%')
                        ->orWhere('nomor_induk', 'like', '%'.$q.'%')
                        ->orWhere('phone', 'like', '%'.$q.'%')
                        ->orWhere('instansi', 'like', '%'.$q.'%');
                })
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        } else {
    	   $data = User::where('role', $role)
                ->orderBy('updated_at', 'desc')
                ->paginate(10);
        }

    	return view('admin.user.index', [
    		'role' => $role,
    		'data' => $data,
    	]);
    }

    public function create(Request $req)
    {
    	$role = $req->role;
        $id = null;
        $data = null;

        if ($req->id) {
            $id = $req->id;
            $data = User::find($id);
        }

        $instansi = User::select('instansi')
            ->whereNotNull('instansi')
            ->get()->pluck('instansi', 'instansi')->toArray();

    	return view('admin.user.create', compact('role', 'id', 'data', 'instansi'));
    }

    public function importTest()
    {
        $password = generateRandomString(6);

        /*Mail::send(new UserCredential([
            'recipient' => 'damar.margi@lodi.id',
            'name' => 'Damar Margi',
            'password' => $password
        ]));

        dd('done');*/

        return view('email.user-credential', [
            'recipient' => 'damar.margi@lodi.id',
            'name' => 'Damar Margi',
            'password' => $password
        ]);
    }

    public function importExcel(Request $req)
    {
        $role = $req->role;

        return view('admin.user.import', [
            'role' => $role
        ]);
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

    public function storePeserta(Request $request)
    {
        $filePath = '/upload_order_temp/' . $request->inputExcel;

        try {
            $data = Excel::import(new UsersImport, $filePath, 'public');

            return response()->json(['result' => 'success']);
        } catch(\Exception $e) {
            Log::debug('Upload Peserta Failed : '. $e->getMessage());

            return response()->json(['result' => 'failed']);
        }

    }

    public function store(Request $req)
    {
    	try {
            if ($req->id) {
                $validator = Validator::make($req->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'phone' => 'required'
                ]);
            } else {
                $validator = Validator::make($req->all(), [
                    'nomor_induk' => 'required|unique:users',
                    'name' => 'required',
                    'email' => 'required|unique:users',
                    'phone' => 'required'
                ]);
            }

            if ($validator->fails()) {
                Session::flash('error', 'Data gagal disimpan');
                
                return redirect()->route('admin.user.index', ['role' => $req->role]);
            }

            DB::beginTransaction();

    		if ($req->id) {
    			$data = User::find($req->id);

                if (!empty($req->password)) {
                    // $str = generateRandomString(6, $req->password);
                    $str = $req->password;
                    $data->password = Hash::make($str);
                }
    		} else {
    			$data = new User;

                // $str = generateRandomString(6, $req->password);
                $str = $req->password;
                $data->password = Hash::make($str);

                Mail::send(new UserCredential([
                    'recipient' => $req->email,
                    'name' => $req->name,
                    'password' => $str
                ]));
    		}

            $data->nomor_induk = $req->nomor_induk;
            $data->name = $req->name;
            $data->email = $req->email;
            $data->phone = $req->phone;
            $data->instansi = $req->instansi;
            $data->role = $req->role;

            $data->save();

            DB::commit();

            Session::flash('success', 'Data berhasil disimpan');

            return redirect()->route('admin.user.index', ['role' => $req->role]);
    	} catch(Exception $e) {
    		Log::error(__METHOD__." Failed Create User : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal disimpan');
            return redirect()->route('admin.user.create', ['role' => $req->role]);
    	}
    }

    public function resetPwd(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $role = $request->role;

            // $password = generateRandomString(6, '0123456789');
            $password = '123456';

            $data = User::find($id);
            $data->password = Hash::make($password);

            $data->save();

            DB::commit();
            Session::flash('success', 'Password berhasil direset');

            Mail::send(new ResetPassword([
                'recipient' => $data->email,
                'name' => $data->name,
                'password' => $password
            ]));

            return redirect()->route('admin.user.index', ['role' => $role]);

        } catch(\Exception $e) {
            Log::error(__METHOD__." Failed reset Password : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Password gagal direset');
            return redirect()->route('admin.user.index', ['role' => $role]);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $role = $request->role;

            $data = User::find($id);
            $data->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.user.index', ['role' => $role]);
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Create User : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.user.create', ['role' => $role]);
        }
    }

    public function downloadTemplate()
    {
        $file = public_path()."/documents/Participant.xlsx";

        if (file_exists($file)) {
            $headers = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            return \Response::download($file, 'Participant.xlsx',$headers);
        }
    }
}
