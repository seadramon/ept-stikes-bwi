<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\Part;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
    	$participantsCount = User::where('role', 'peserta')->count();
    	$instansiCount = User::select(DB::raw("count(distinct instansi) as jml"))
    		->where('role', 'peserta')->first()->jml;

    	$jadwalCountActive = Jadwal::whereDate('start', '<=', now())
                ->whereDate('end', '>=', now())
                ->count();
        $jadwalCountPast = Jadwal::whereDate('end', '<=', now())->count();

    	$parts = Part::where('paket', 'a')->get();
    	$partsb = Part::where('paket', 'b')->get();

        $countPartA = 0;
        foreach ($parts as $part) {
            $countPartA += $part->question->count();
        }

        $countPartB = 0;
        foreach ($partsb as $part) {
            $countPartB += $part->question->count();
        }
    	return view('admin.dashboard', compact('participantsCount', 'instansiCount', 'jadwalCountActive', 'countPartA', 'countPartB', 'jadwalCountPast'));
    }
}
