<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LINEController;


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

/*Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');*/

Auth::routes(['verify' => true]);
Route::get('/', function () {
    return redirect('/login');
});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/basic', [HomeController::class, 'basic'])->name('basic');
Route::post('/basic', [SettingController::class, 'basic_update'])->name('basic.update');
Route::get('/classs', [HomeController::class, 'classs'])->name('classs.classs');
Route::post('/classs/store', [SettingController::class, 'classs_store'])->name('classs.store');
Route::post('/classs/update', [SettingController::class, 'classs_update'])->name('classs.update');
Route::post('/classs/delete', [SettingController::class, 'classs_delete'])->name('classs.delete');
Route::get('/classs/{id}/student', [HomeController::class, 'student'])->name('classs.student');
Route::post('/classs/{id}/student', [SettingController::class, 'student_update'])->name('student.update');
Route::post('/student/{id}/update', [SettingController::class, 'perstudent_update'])->name('perstudent.update');
Route::post('/student/{id}/delete', [SettingController::class, 'perstudent_delete'])->name('perstudent.delete');
Route::post('/classs/student/search', [SettingController::class, 'student_search'])->name('student.search');
Route::get('/batch', [HomeController::class, 'batch'])->name('batch');
Route::post('/batch/store', [SettingController::class, 'batch_store'])->name('batch.store');
Route::post('/batch/update', [SettingController::class, 'batch_update'])->name('batch.update');
Route::post('/batch/delete', [SettingController::class, 'batch_delete'])->name('batch.delete');
Route::get('api_test', [AppController::class, 'api_test']);
Route::post('/app/login', [AppController::class, 'login']);
Route::get('/line', [HomeController::class, 'line'])->name('line');
Route::post('/line', [SettingController::class, 'line_update'])->name('line.update');
Route::get('/signin', [HomeController::class, 'signin'])->name('signin');
Route::get('/signin/{classs_id}/{date}/result', [HomeController::class, 'signin_result'])->name('signin.result');
Route::get('/message', [HomeController::class, 'message'])->name('message');
Route::post('/message/store', [SettingController::class, 'message_store'])->name('message.store');
Route::post('/message/update', [SettingController::class, 'message_update'])->name('message.update');
Route::post('/message/delete', [SettingController::class, 'message_delete'])->name('message.delete');
Route::post('/message/send', [SettingController::class, 'message_send'])->name('message.send');
Route::get('/system', [HomeController::class, 'system'])->name('system');
Route::post('/system', [SettingController::class, 'system_update'])->name('system.update');

Route::post('/callback/{id}', [LINEController::class, 'post'])->name('lintbot_api');


