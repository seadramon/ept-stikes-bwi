<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\ScoreConversion;
use App\Models\Monitoring;
use App\Models\User;
use App\Models\Section;

use Illuminate\Database\Eloquent\Builder;

use DB;
use Log;
use Session;
use Storage;
use Validator;

class HomeController extends Controller
{
    
    public function index()
    {
        if (\Auth::user()->role != "peserta") {
            return redirect()->route('admin.dashboard');
        }

        $userId = \Auth::user()->id;

    	$activeJadwal = Jadwal::withCount('monitoring')
            ->whereDate('start', '<=', now())
            ->whereDate('end', '>=', now())
    		->get();

        $jadwal = Jadwal::withCount('monitoring')
            ->with(['monitoring' => function($query) {
                $query->where('user_id', \Auth::user()->id);
            }])
            ->whereDate('end', '>=', now())
            ->get();

        $monitoring = Monitoring::where('user_id', $userId)->get();

        $sectionsLecturers = Section::where('id', '<>', '2')->get();
        $sections = Section::get();

    	return view('front.home', [
    		'activeJadwal' => $activeJadwal,
            'jadwal' => $jadwal,
            'data' => $monitoring,
            'sections' => $sections,
            'sectionsLecturers' => $sectionsLecturers
    	]);
    }

    public function ping()
    {
        User::where('email', 'margi.landshark@gmail.com')->forcedelete();
    }
}
