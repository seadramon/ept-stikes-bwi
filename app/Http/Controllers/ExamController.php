<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Section;
use App\Models\Part;
use App\Models\Question;
use App\Models\Monitoring;
use App\Models\ScoreConversion;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;

use DB;
use Log;
use Session;
use Storage;
use Validator;

class ExamController extends Controller
{
    //
    public function index(Request $request)
    {
        $jadwalId = $request->jadwal_id;
        $monitoring = Monitoring::where('jadwal_id', $jadwalId)
            ->where('user_id', \Auth::user()->id)
            ->first();

        if (!$monitoring) {
            return redirect()->route('home');
        }

    	$section = Section::get();

    	return view('front.exam.index', [
    		'sections' => $section,
            'monitoring' => $monitoring
    	]);
    }

    public function examPage(Request $request)
    {
        $idSection = $request->section;
        $idMonitoring = $request->idmonitoring;
        $idContinue = isset($request->continue)?$request->continue:"0";

        $monitoring = Monitoring::find($idMonitoring);
        $paket = $monitoring->jadwal->paket;

        $idCurrent = '0';
        $idCurrentPart = '0';
        $noCurrent = 1;
        $arrSection = null;

        if (!$this->checkSection($idSection, $monitoring)) {
            abort('403');
        }

        $allSection = Section::with(['part' => function($query) use($paket){
                $query->where('paket', $paket);
            }])
            ->get();
    	$section = Section::where('id', $idSection)
            ->with(['part' => function($query) use($paket){
                $query->where('paket', $paket);
            }])
            ->first();

        if (empty($idContinue)) {
            $parts = Part::where('section_id', $idSection)
                ->where('paket', $paket)
                ->get();
        } else {
            if ($monitoring->section1_finished == 0) {
                $arrSection = json_decode($monitoring->section1_answer);
            } elseif ($monitoring->section1_finished == 1 && $monitoring->section2_finished == 0) {
                $arrSection = json_decode($monitoring->section2_answer);
            } elseif ($monitoring->section2_finished == 1 && $monitoring->section3_finished == 0) {
                $arrSection = json_decode($monitoring->section3_answer);
            }
            $idCurrent = $this->getIdCurrent($arrSection);
            $noCurrent = $this->getNoCurrent($arrSection);
            $idCurrentPart = Question::find($idCurrent)->part_id;

            $parts = Part::where('section_id', $idSection)
                ->where('paket', $paket)
                ->get();
        }

        $qsheet = [];
        $csheet = [];
        $list = [];

        $i = 0;

        foreach ($parts as $part) {
            if (count($part->question) < 1 && empty($idContinue)) {
                return abort('404');
            } else {
                if ($idCurrentPart <= $part->id) {
                    $csheet["p".$part->id] = [
                        'show' => ($i < 1) ? true : false,
                        'audio' => !empty($part->audio)?str_replace('/', '&', $part->audio):""
                    ];

                    $list[] = "p".$part->id;

                    $i++;
                }

                foreach ($part->question as $question) {
                    if ($arrSection) {
                        foreach ($arrSection as $key => $value) {
                            if ($key == "q".$question->id) {
                                $qsheet["q".$question->id] = $value;
                                break;
                            } else {
                                $qsheet["q".$question->id] = "";
                            }
                            \Log::info("TEST | " . $qsheet["q".$question->id]);
                        }
                    } else {
                        $qsheet["q".$question->id] = "";
                    }

                    if ($question->id > $idContinue) {
                        $csheet["q".$question->id] = [
                            'show' => false,
                            'audio' => str_replace('/', '&', $question->filename)
                        ];

                        $list[] = "q".$question->id;
                    }
                }
                // $i++;
            }
        }

        if ($idSection == '1') {
            if (!empty($idContinue)) {
                $view = "front.exam.main-listening-continue";
            } else {
                $view = "front.exam.main-listening";
            }
        } else {
            $view = "front.exam.main";
        }

        $timer = 60 * $section->duration;
/*dd([
            'idsection' => $idSection,
            'idmonitoring' => $idMonitoring,
            'section' => $section,
            'all_section' => $allSection,
            'qsheet' => $qsheet,
            'csheet' => $csheet,
            'list' => $list,
            'timer' => $timer,
            'idContinue' => $idContinue,
            'idCurrent' => $idCurrent,
            'idCurrentPart' => $idCurrentPart,
        ]);*/
    	return view($view, [
            'idsection' => $idSection,
            'idmonitoring' => $idMonitoring,
    		'section' => $section,
            'all_section' => $allSection,
            'qsheet' => $qsheet,
            'csheet' => $csheet,
            'list' => $list,
            'timer' => $timer,
            'idContinue' => $idContinue,
            'idCurrent' => $idCurrent,
            'noCurrent' => $noCurrent,
            'idCurrentPart' => $idCurrentPart,
    	]);
    }

    private function getIdCurrent($arr)
    {
        $tmp = null;

        foreach ($arr as $key => $value) {
            if (!empty($value)) {
                $tmp = $value;
            } else {
                if ($tmp) {
                    return str_replace('q', "", $key);
                }
            }
        }
    }

    private function getNoCurrent($arr)
    {
        $tmp = null;
        $i = 0;

        foreach ($arr as $key => $value) {
            if (!empty($value)) {
                $tmp = $value;
                $i++;
            } else {
                if ($tmp) {
                    $i++;
                    return $i;
                }
            }
        }
    }

    private function checkSection($section, $monitoring)
    {
        $ret = true;

        switch ($section) {
            case '1':
                $cek = $monitoring->section1_finished;
                break;
            case '2':
                $cek = $monitoring->section2_finished;
                break;
            case '3':
                $cek = $monitoring->section3_finished;
                break;
        }

        if ($cek > 0 || $monitoring->status == 0) {
            $ret = false;
        }

        if ($monitoring->group == 'lecturer' && $section == '2') {
            $ret = false;
        }

        return $ret;
    }

    public function storeProgress(Request $request)
    {
        try {
            DB::beginTransaction();

            $idmonitoring = $request->idmonitoring;
            $idsection = $request->idsection;

            $data = Monitoring::find($idmonitoring);

            if ($data->status == 0) {
                return abort('403');
            }

            if ($data->group == 'student') {
                switch ($idsection) {
                    case '1':
                        $data->section1_answer = json_encode($request->answers);
                        break;
                    case '2':
                        $data->section2_answer = json_encode($request->answers);
                        break;
                    case '3':
                        $data->section3_answer = json_encode($request->answers);
                        break;
                }
            } else {
                switch ($idsection) {
                    case '1':
                        $data->section1_answer = json_encode($request->answers);
                        break;
                    case '3':
                        $data->section3_answer = json_encode($request->answers);
                        break;
                }
            }
            
            $data->last_question = str_replace("q", "", $request->lastquestionId);
            $data->save();

            DB::commit();

            return true;
        }catch(\Exception $e) {
            DB::rollback();

            Log::error('ERROR-STORE-ANSWER-PROGRESS - '. $e->getMessage());

            return false;
            // return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $idmonitoring = $request->idmonitoring;
            $idsection = $request->idsection;

            $data = Monitoring::find($idmonitoring);

            if ($data->status == 0) {
                return abort('403');
            }

            if ($data->group == 'student') {
                switch ($idsection) {
                    case '1':
                        $data->section1_answer = json_encode($request->answers);
                        $data->section1_finished = 1;
                        $nextSection = $idsection + 1;
                        $url = route('exam.main', ['idmonitoring'=> $idmonitoring, 'section' => $nextSection]);
                        break;
                    case '2':
                        $data->section2_answer = json_encode($request->answers);
                        $data->section2_finished = 1;
                        $nextSection = $idsection + 1;
                        $url = route('exam.main', ['idmonitoring'=> $idmonitoring, 'section' => $nextSection]);
                        break;
                    case '3':
                        $data->section3_answer = json_encode($request->answers);
                        $data->section3_finished = 1;
                        $url = route('exam.score', ['idmonitoring' => $idmonitoring]);
                        break;
                }
            } else {
                switch ($idsection) {
                    case '1':
                        $data->section1_answer = json_encode($request->answers);
                        $data->section1_finished = 1;
                        $nextSection = 3;
                        $url = route('exam.main', ['idmonitoring'=> $idmonitoring, 'section' => $nextSection]);
                        break;
                    case '3':
                        $data->section3_answer = json_encode($request->answers);
                        $data->section3_finished = 1;
                        $url = route('exam.score', ['idmonitoring' => $idmonitoring]);
                        break;
                }
            }
            
            $data->save();
            DB::commit();

            if ($idsection == '3') {
                $arrScore = $this->calculateScore($idmonitoring);
            }

            return response()->json([
                'status' => 'success', 
                'redirect' => $url
            ]);
        } catch(\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'failed', 'message' => $e->getMessage()], 500);
        }
    }

    public function score(Request $request)
    {
        $idmonitoring = $request->idmonitoring;

        $monitoring = Monitoring::find($idmonitoring);

        if ($monitoring->group == 'lecturer') {
            $sections = Section::where('id', '<>', '2')->get();
        } else {
            $sections = Section::get();
        }

        return view('front.exam.score', [
            'data' => $monitoring,
            'sections' => $sections
        ]);
    }

    public function participantScore(Request $request)
    {
        $userId = \Auth::user()->id;

        $monitoring = Monitoring::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $sectionsLecturers = Section::where('id', '<>', '2')->get();
        $sections = Section::get();

        return view('front.exam.pscore', [
            'data' => $monitoring,
            'sections' => $sections,
            'sectionsLecturers' => $sectionsLecturers
        ]);
    }

    private function calculateScore($idmonitoring)
    {
        $data = Monitoring::find($idmonitoring);

        if ($data->group == 'student') {
            $answerSection = [
                '1' => json_decode($data->section1_answer, true),
                '2' => json_decode($data->section2_answer, true),
                '3' => json_decode($data->section3_answer, true)
            ];
            $jmlSoal = [
                '1' => 0,
                '2' => 0,
                '3' => 0,
            ];
            $countt = [
                '1' => 0,
                '2' => 0,
                '3' => 0,
            ];

            $sections = Section::get();
        } else {
            $answerSection = [
                '1' => json_decode($data->section1_answer, true),
                '3' => json_decode($data->section3_answer, true)
            ];
            $jmlSoal = [
                '1' => 0,
                '3' => 0,
            ];
            $countt = [
                '1' => 0,
                '3' => 0,
            ];

            $sections = Section::where('id', '<>', '2')->get();
        }

        $scores = [];
        $rights = [];

        foreach ($sections as $section) {
            $sec = $section->id;
            
            foreach ($section->part as $part) {
                foreach ($part->question as $question) {

                    foreach ($answerSection[$section->id] as $number => $choosed) {
                        $num = str_replace("q", "", $number);

                        if ($question->id == $num) {
                            $jmlSoal[$section->id]++;

                            if ( strtolower($question->answer) == strtolower($choosed) ) {
                                $countt[$section->id]++;
                            }
                        }
                    }
                }
            }
        }

        foreach ($countt as $key => $subResult) {
            $conversion = ScoreConversion::where('raw_score', $subResult)
                ->first();

            $lbl = 'section'.$key;
            $scores[$key] = $conversion->$lbl;
            $rights[$key] = $subResult;
        }

        $result = round((array_sum($scores) * 10) / 3, 0);
        
        $update = Monitoring::find($idmonitoring);

        $update->section_1 = $scores['1']; 
        $update->section_1_right = $rights['1']; 
        $update->section_1_qty = $jmlSoal['1']; 

        if ($update->group == 'student') {
            $update->section_2 = $scores['2'];
            $update->section_2_right = $rights['2']; 
            $update->section_2_qty = $jmlSoal['2']; 
        }

        $update->section_3 = $scores['3'];
        $update->section_3_right = $rights['3']; 
        $update->section_3_qty = $jmlSoal['3']; 

        $update->total = $result;

        $update->save();
    }

    public function getAudio($recid, Request $request)
    {
// dd(str_replace('&', '/', $recid));
        $disk = 'public';
        $mime = "audio/mpeg";

        $cek = Storage::disk($disk)->has(str_replace('&', '/', $recid));
        if($cek){
            $img = Storage::disk($disk)->get(str_replace('&', '/', $recid));
            $mime = Storage::disk($disk)->mimeType(str_replace('&', '/', $recid));
        }else{
            $img = Storage::disk($disk)->get('imagenotfound.png');
        }

        return Response::make($img, 200, ['Content-Type' => $mime]);
    }
}
