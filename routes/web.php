<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/route-cache', function() {
     \Artisan::call('route:cache');
     return 'Routes cache cleared';
 });

Route::get('login', 	[CustomAuthController::class, 'index'])->name('login');
Route::get('resetpwd', 	[CustomAuthController::class, 'resetPasswordView'])->name('resetpwdview');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');
Route::post('resetpwd', 	[CustomAuthController::class, 'resetPassword'])->name('resetpwd');
Route::get('ping', [HomeController::class, 'ping']);

Route::middleware(['auth'])->get('/', 	[HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:peserta'])->group(function() {

	Route::group(['prefix' => '/exam', 'as' => 'exam.'], function(){

		Route::get('/', 				[ExamController::class, 'index'])->name('index');
		Route::get('main', 				[ExamController::class, 'examPage'])->name('main');
		Route::get('score', 			[ExamController::class, 'score'])->name('score');
		Route::get('participant-score',	[ExamController::class, 'participantScore'])->name('pscore');
		Route::post('store-progress', 	[ExamController::class, 'storeProgress'])->name('store-progress');
		Route::post('store', 			[ExamController::class, 'store'])->name('store');
	});
});
