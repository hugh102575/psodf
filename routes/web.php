<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\LINEController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsActive;
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
Route::get('/bind/{school_id}/{LineID}', [AppController::class, 'bind'])->name('bind');
Route::post('/bind/update', [AppController::class, 'bind_update'])->name('bind.update');
Route::get('/supervise/{school_id}/{LineID}', [AppController::class, 'supervise'])->name('supervise');
Route::get('api_test', [AppController::class, 'api_test']);
Route::post('/app/login', [AppController::class, 'login_v2']);
Route::post('/costom_reset_pwd', [AppController::class, 'costom_reset_pwd'])->name('costom_reset_pwd');
Route::get('/costom_reset_pwd/{id}', [AppController::class, 'costom_reset_pwd_form'])->name('costom_reset_pwd_form');
Route::post('/costom_reset_pwd/{id}', [AppController::class, 'costom_reset_pwd_form_post'])->name('costom_reset_pwd_form_post');
Route::get('/notify_bind', [AppController::class, 'notify_bind']);


Route::middleware([IsActive::class])->group(function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');
//Route::get('/document1', [HomeController::class, 'document1'])->name('document1');
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
Route::get('/line', [HomeController::class, 'line'])->name('line');
//Route::get('/line_notify', [HomeController::class, 'line_notify'])->name('line_notify');
Route::post('/line', [SettingController::class, 'line_update'])->name('line.update');
//Route::post('/line_notify', [SettingController::class, 'line_notify_update'])->name('line_notify.update');
Route::get('/signin', [HomeController::class, 'signin'])->name('signin.signin');
Route::get('/signin/overview', [HomeController::class, 'signin_overview'])->name('signin.overview');
Route::post('/signin/update_chart', [HomeController::class, 'update_chart']);
Route::get('/signin/{q_type}/{classs_id}/{date}/result', [HomeController::class, 'signin_result'])->name('signin.result');
Route::get('/message', [HomeController::class, 'message'])->name('message');
Route::post('/message/store', [SettingController::class, 'message_store'])->name('message.store');
Route::post('/message/update', [SettingController::class, 'message_update'])->name('message.update');
Route::post('/message/delete', [SettingController::class, 'message_delete'])->name('message.delete');
Route::post('/message/send', [SettingController::class, 'message_send'])->name('message.send');
Route::get('/system', [HomeController::class, 'system'])->name('system');
Route::post('/system', [SettingController::class, 'system_update'])->name('system.update');
Route::get('/self_profile', [HomeController::class, 'self_profile'])->name('self_profile');
Route::post('/self_profile/update', [SettingController::class, 'self_profile_update'])->name('self_profile.update');
Route::get('/role', [HomeController::class, 'role'])->name('role');
Route::get('/role/create', [HomeController::class, 'role_create'])->name('role.create');
Route::get('/role/{RoleID}/edit', [HomeController::class, 'role_edit'])->name('role.edit');
Route::post('/role/create_post', [SettingController::class, 'role_create_post'])->name('role.create_post');
Route::post('/role/{RoleID}/edit_post', [SettingController::class, 'role_edit_post'])->name('role.edit_post');
Route::post('/role/{RoleID}/delete_post', [SettingController::class, 'role_delete_post'])->name('role.delete_post');
Route::get('/account', [HomeController::class, 'account'])->name('account');
Route::get('/account/create', [HomeController::class, 'account_create'])->name('account.create');
Route::get('/account/{id}/edit', [HomeController::class, 'account_edit'])->name('account.edit');
Route::post('/account/create_post', [SettingController::class, 'account_create_post'])->name('account.create_post');
Route::post('/account/{id}/edit_post', [SettingController::class, 'account_edit_post'])->name('account.edit_post');
Route::post('/account/{id}/delete_post', [SettingController::class, 'account_delete_post'])->name('account.delete_post');
Route::post('/account/{id}/change_active', [SettingController::class, 'change_active'])->name('account.change_active');
}); 




Route::post('/callback/{id}', [LINEController::class, 'post'])->name('lintbot_api');


Route::get('/management', [AdminController::class, 'index'])->name('admin.index');
Route::post('/management/login', [AdminController::class, 'login'])->name('admin.login');
Route::middleware([IsAdmin::class])->group(function () {
    Route::get('/management/home', [AdminController::class, 'home'])->name('admin.home');
    Route::post('/management/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::post('/management/update_plan', [AdminController::class, 'update_plan'])->name('admin.update_plan');
    Route::post('/management/store_subscribe', [AdminController::class, 'store_subscribe'])->name('admin.store_subscribe');
    Route::post('/management/update_subscribe', [AdminController::class, 'update_subscribe'])->name('admin.update_subscribe');
    Route::post('/management/{id}/change_active', [AdminController::class, 'change_active'])->name('admin.change_active');
    Route::post('/management/query_due', [AdminController::class, 'query_due'])->name('admin.query_due');

}); 


