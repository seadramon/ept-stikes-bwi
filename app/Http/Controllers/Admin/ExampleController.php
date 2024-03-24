<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Section;
use App\Models\Part;
use App\Models\Example;

use DB;
use Exception;
use Session;
use Storage;
use Log;

class ExampleController extends Controller
{
    //
    public function index(Request $request)
    {
    	$parts = Part::get();
    	$selPart = ["" => "Pilih Part"];
    	foreach ($parts as $part) {
    		$selPart[$part->id] = $part->section->title.' - '. $part->title;
    	}

    	if ($request->search_part) {
            $q = $request->search_part;

            $data = Example::where('part_id', $q)->paginate(10);
        } else {
    	   $data = Example::paginate(10);
        }

        return view('admin.exam.example.index', [
    		'data' => $data,
    		'part' => $selPart
    	]);
    }

    public function create(Request $request)
    {
    	$id = null;
    	$data = null;

    	$parts = Part::get();
    	$selPart = ["" => "Pilih Part"];
    	foreach ($parts as $part) {
    		$selPart[$part->id] = $part->section->title.' - '. $part->title;
    	}

        if ($request->id) {
            $id = $request->id;
            $data = Example::find($id);
        }

    	return view('admin.exam.example.create', [
            'id' => $id,
            'data' => $data,
            'part' => $selPart
    	]);
    }

    public function store(Request $request)
    {
		try {
	        DB::beginTransaction();

			if ($request->id) {
				$data = Example::find($request->id);
			} else {
				$data = new Example;
			}

	        $data->part_id = $request->part_id;
            $data->story = $request->story;
            $data->question = $request->question;
            $data->choice_a = $request->choice_a;
            $data->choice_b = $request->choice_b;
            $data->choice_c = $request->choice_c;
            $data->choice_d = $request->choice_d;
            $data->answer = $request->answer;
            $data->reason = $request->reason;

	        $data->save();

	        $id = $data->id;

	        if ( $request->hasFile('audio') ) {
	            $file = $request->file('audio');
	            $extension = $file->getClientOriginalExtension();
	            $filename = $file->getClientOriginalName();

	            $fullpath = 'exams/example/' . $id.'.'.$extension;
	            Storage::disk('public')->put($fullpath, \File::get($file));

	            $upload = Example::find($id);
	            $upload->filename = $fullpath;
	            $upload->save();
	        }

	        DB::commit();
	        Session::flash('success', 'Data berhasil disimpan');

	        return redirect()->route('admin.exam.example.index');
		} catch(Exception $e) {
			Log::error(__METHOD__." Failed Create Example : ". $e->getMessage());

	        DB::rollback();
	        Session::flash('error', 'Data gagal disimpan');
	        return redirect()->route('admin.exam.example.create');
		}
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = Example::find($id);
            $data->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.exam.example.index');
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Example : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.exam.example.index');
        }
    }
}
