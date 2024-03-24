<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Section;
use App\Models\Part;
use App\Models\Example;
use App\Models\Question;
use App\Services\QuestionService;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use App\Imports\QuestionsImportTest;

use DB;
use Exception;
use Session;
use Storage;
use Log;
use Validator;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $parts = Part::get();
    	$selPart = ["" => "Pilih Part"];
    	foreach ($parts as $part) {
    		$selPart[$part->id] = $part->section->title.' - '. $part->title;
    	}

    	if ($request->search_part) {
            $q = $request->search_part;

            $data = Question::where('part_id', $q)->paginate(10);
        } else {
    	   $data = Question::paginate(10);
        }

        return view('admin.exam.question.index', [
    		'data' => $data,
    		'part' => $selPart
    	]);
    }

    public function getPart(Request $request)
    {
        $sectionId = $request->id;
        
        $parts = Part::where('section_id', $sectionId)->get();
        $selPart = [];
        foreach ($parts as $part) {
            $selPart[] = [
                'id' => $part->id,
                'text' => $part->title
            ];
        }

        return $selPart;
    }

    public function create(Request $request)
    {
    	$id = null;
    	$data = null;

    	$sections = Section::get();
        $selSection = ["" => ""];
        foreach ($sections as $section) {
            $selSection[$section->id] = $section->title;
        }

        $parts = [];

        if ($request->id) {
            $id = $request->id;
            $data = Question::find($id);
        }

        $alpha = [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D'
        ];

    	return view('admin.exam.question.create', [
            'id' => $id,
            'data' => $data,
            'alpha' => $alpha,
            'part' => $parts,
            'section' => $selSection
    	]);
    }

    public function store(Request $request)
    {
		try {
	        DB::beginTransaction();

			if ($request->id) {
				$data = Question::find($request->id);

                $data->urutan = $request->urutan; 
			} else {
				$data = new Question;

                $q = new QuestionService;
                $data->urutan = $q->getNextUrutan($request->part_id);
			}

            $data->story = $request->story;
            $data->question = $request->question;

	        $data->part_id = $request->part_id;
            $data->choice_a = $request->choice_a;
            $data->choice_b = $request->choice_b;
            $data->choice_c = $request->choice_c;
            $data->choice_d = $request->choice_d;
            $data->answer = $request->answer;

	        $data->save();

	        $id = $data->id;

	        if ( $request->hasFile('audio') ) {
	            $file = $request->file('audio');
	            $extension = $file->getClientOriginalExtension();
	            $filename = $file->getClientOriginalName();

	            $fullpath = 'exams/question/' . $id.'.'.$extension;
	            Storage::disk('public')->put($fullpath, \File::get($file));

	            $upload = Question::find($id);
	            $upload->filename = $fullpath;
	            $upload->save();
	        }

	        DB::commit();
	        Session::flash('success', 'Data berhasil disimpan');

	        return redirect()->route('admin.exam.question.index');
		} catch(Exception $e) {
			Log::error(__METHOD__." Failed Create Question : ". $e->getMessage());

	        DB::rollback();
	        Session::flash('error', 'Data gagal disimpan');
	        return redirect()->route('admin.exam.question.create');
		}
    }

    public function importExcel()
    {
        $parts = Part::get();
        $selPart = [];
        foreach ($parts as $part) {
            $selPart[$part->id] = $part->section->title.' - '. $part->title;
        }

        return view('admin.exam.question.import', [
            'part' => $selPart
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

    public function storeQuestion(Request $request)
    {
        $partId = $request->part_id;
        $filePath = '/upload_order_temp/' . $request->inputExcel;

        try {
            $data = Excel::import(new QuestionsImport($partId), $filePath, 'public');

            return response()->json(['result' => 'success']);
        } catch(\Exception $e) {
            Log::debug('Upload Peserta Failed : '. $e->getMessage());

            return response()->json(['result' => 'failed']);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $data = Question::find($id);

            Storage::disk('public')->delete($data->filename);
            
            $data->delete();

            DB::commit();
            Session::flash('success', 'Data berhasil dihapus');

            return redirect()->route('admin.exam.question.index');
        } catch(Exception $e) {
            Log::error(__METHOD__." Failed Delete Example : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Data gagal dihapus');
            return redirect()->route('admin.exam.question.index');
        }
    }
}
