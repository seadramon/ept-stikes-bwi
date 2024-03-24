<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Part;
use App\Models\Section;

use DB;
use Exception;
use Log;
use Session;
use Storage;

class PartController extends Controller
{
    //
    public function index()
    {
    	$data = Part::paginate(10);

    	return view('admin.exam.part.index', [
    		'data' => $data
    	]);
    }

    public function create(Request $request)
    {
    	$id = null;
    	$data = null;

    	$section = Section::get()->pluck('title', 'id')->toArray();
    	$labelSection = ["" => "Pilih Section"];
    	$section = $labelSection + $section;

        if ($request->id) {
            $id = $request->id;
            $data = Part::find($id);
        }

        $paket = [
            'a' => 'A',
            'b' => 'B'
        ];

    	return view('admin.exam.part.create', [
            'id' => $id,
            'data' => $data,
            'section' => $section,
            'paket' => $paket
    	]);
    }

    public function store(Request $request)
    {
		try {
	        DB::beginTransaction();

			if ($request->id) {
				$data = Part::find($request->id);
			} else {
				$data = new Part;
			}

	        $data->section_id = $request->section_id;
            $data->title = $request->title;
            $data->paket = $request->paket;
            $data->direction = $request->direction;

	        $data->save();
            $id = $data->id;

            if ( $request->hasFile('audio') ) {
                $file = $request->file('audio');
                $extension = $file->getClientOriginalExtension();
                $filename = $file->getClientOriginalName();

                $fullpath = 'exams/part/' . $id.'.'.$extension;
                Storage::disk('public')->put($fullpath, \File::get($file));

                $upload = Part::find($id);
                $upload->audio = $fullpath;
                $upload->save();
            }

	        DB::commit();
	        Session::flash('success', 'Data berhasil disimpan');

	        return redirect()->route('admin.exam.part.index');
		} catch(Exception $e) {
			Log::error(__METHOD__." Failed Create Part : ". $e->getMessage());

	        DB::rollback();
	        Session::flash('error', 'Data gagal disimpan');

	        return redirect()->route('admin.exam.part.index');
		}
    }

    public function delete($id)
    {
    	try {
            DB::beginTransaction();

            $data = Part::find($id);
            $data->question()->delete();
            $data->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.exam.part.index');
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Part : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.exam.part.index');
        }
    }
}
