<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Section;

class SectionController extends Controller
{
    //
    public function index(Request $request)
    {
    	$data = Section::paginate(10);

    	return view('admin.exam.section.index', [
    		'data' => $data
    	]);
    }
}
