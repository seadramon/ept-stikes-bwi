<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RuangController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\Admin\ExampleController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\ReportController;


Route::prefix("admin")->as('admin.')->group(function(){

	Route::get('audio-api/audio/{recid}', [ExamController::class, 'getAudio'])->name('file-audio');

	Route::middleware(['auth', 'role:administrator|pengawas'])->group(function() {

		Route::get("/", 			[DashboardController::class, "index"])->name('dashboard');


		Route::group(['prefix' => '/user', 'as' => 'user.'], function(){
			Route::get('create', 		[UserController::class, 'create'])->name('create');
			Route::get('template', 		[UserController::class, 'downloadTemplate'])->name('template');
			Route::get('import-test', 	[UserController::class, 'importTest'])->name('import-test');
			Route::get('import-excel', 		[UserController::class, 'importExcel'])->name('import-excel');
			Route::get('{role}', 		[UserController::class, 'index'])->name('index');
			
			Route::get('delete/{id}', 	[UserController::class, 'delete'])->name('delete');
			Route::get('reset/{id}', 	[UserController::class, 'resetPwd'])->name('reset');
			Route::post('store', 		[UserController::class, 'store'])->name('store');
			Route::post('upload-excel', [UserController::class, 'uploadExcel'])->name('upload-excel');
			Route::post('import-excel', [UserController::class, 'storePeserta'])->name('import-excel-store');
			// Route::post('{role}', 		[UserController::class, 'index'])->name('search');
		});

		Route::group(['prefix' => '/ruang', 'as' => 'ruang.'], function(){
			Route::get('/', 		[RuangController::class, 'index'])->name('index');
			Route::get('create', 	[RuangController::class, 'create'])->name('create');
			Route::get('delete/{id}', 	[RuangController::class, 'delete'])->name('delete');
			Route::post('store', 		[RuangController::class, 'store'])->name('store');
		});

		Route::group(['prefix' => '/exam', 'as' => 'exam.'], function(){
			Route::group(['prefix' => '/section', 'as' => 'section.'], function(){
				Route::get('/', 		[SectionController::class, 'index'])->name('index');
			});

			Route::group(['prefix' => '/part', 'as' => 'part.'], function(){
				Route::get('/', 		[PartController::class, 'index'])->name('index');
				Route::get('create', 	[PartController::class, 'create'])->name('create');
				Route::get('delete/{id}', 	[PartController::class, 'delete'])->name('delete');
				Route::post('store', 		[PartController::class, 'store'])->name('store');
			});

			Route::group(['prefix' => '/example', 'as' => 'example.'], function(){
				Route::get('/', 		[ExampleController::class, 'index'])->name('index');
				Route::get('create', 	[ExampleController::class, 'create'])->name('create');
				Route::get('delete/{id}', 	[ExampleController::class, 'delete'])->name('delete');
				Route::post('search-part', 		[ExampleController::class, 'index'])->name('search-part');
				Route::post('store', 		[ExampleController::class, 'store'])->name('store');
			});

			Route::group(['prefix' => '/question', 'as' => 'question.'], function(){
				Route::get('/', 		[QuestionController::class, 'index'])->name('index');
				Route::get('create', 	[QuestionController::class, 'create'])->name('create');
				Route::get('import', 		[QuestionController::class, 'importExcel'])->name('import');
				Route::get('part', 	[QuestionController::class, 'getPart'])->name('part');
				Route::get('delete/{id}', 	[QuestionController::class, 'delete'])->name('delete');

				Route::post('search-part', 		[QuestionController::class, 'index'])->name('search-part');
				Route::post('store', 		[QuestionController::class, 'store'])->name('store');
				Route::post('upload-excel', [QuestionController::class, 'uploadExcel'])->name('upload-excel');
				Route::post('import-excel', [QuestionController::class, 'storeQuestion'])->name('import-excel-store');
			});
		});

		Route::group(['prefix' => '/report', 'as' => 'report.'], function(){
			Route::get('/participant',	[ReportController::class, 'participantLink'])->name('participant');
			Route::get('/participant-pdf',	[ReportController::class, 'participantPdf'])->name('participant-pdf');
			Route::get('/participant-xls',	[ReportController::class, 'participantXls'])->name('participant-xls');

			Route::get('/room',	[ReportController::class, 'roomLink'])->name('room');
			Route::get('/room-pdf',	[ReportController::class, 'roomPdf'])->name('room-pdf');
			Route::get('/room-xls',	[ReportController::class, 'roomXls'])->name('room-xls');

			Route::get('/schedule',	[ReportController::class, 'scheduleLink'])->name('schedule');
			Route::get('/schedule-pdf',	[ReportController::class, 'schedulePdf'])->name('schedule-pdf');
			Route::get('/schedule-xls',	[ReportController::class, 'scheduleXls'])->name('schedule-xls');

			Route::get('/sch-room',	[ReportController::class, 'getRooms'])->name('sch-room');
		});

		Route::group(['prefix' => '/jadwal', 'as' => 'jadwal.'], function(){
			Route::get('/', 		[JadwalController::class, 'index'])->name('index');
			Route::get('create', 	[JadwalController::class, 'create'])->name('create');
			Route::get('template', 	[JadwalController::class, 'downloadTemplate'])->name('template');
			Route::get('data-peserta', 	[JadwalController::class, 'getPeserta'])->name('get-peserta');
			Route::get('delete/{id}', 	[JadwalController::class, 'delete'])->name('delete');
			Route::get('deletePeserta/{id}', 	[JadwalController::class, 'deletePeserta'])->name('delete-peserta');

			Route::post('upload-excel', [JadwalController::class, 'uploadExcel'])->name('upload-excel');
			Route::post('store', 		[JadwalController::class, 'store'])->name('store');
		});

		Route::group(['prefix' => '/monitoring', 'as' => 'monitoring.'], function(){
			Route::get('create', 		[MonitoringController::class, 'create'])->name('create');
			Route::get('change', 	[MonitoringController::class, 'changeStatus'])->name('change');
			
			Route::get('{jadwal_id}', 		[MonitoringController::class, 'index'])->name('index');
			Route::get('delete/{userid}/{jadwalid}', 	[MonitoringController::class, 'delete'])->name('delete');
			Route::post('search/{jadwal_id}', 			[MonitoringController::class, 'index'])->name('search');
			Route::post('store', 		[MonitoringController::class, 'store'])->name('store');
		});
	});
});
