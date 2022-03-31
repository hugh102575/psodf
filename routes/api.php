<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/batch', function(Request $request) {
    return $request->user()->school->batch;
});
Route::middleware('auth:api')->get('/class', function(Request $request) {
    return $request->user()->school->classs;
});
Route::middleware('auth:api')->get('/student', function(Request $request) {
    return $request->user()->school->student;
});
Route::middleware('auth:api')->get('/batch/{id}/class', [AppController::class, 'batch_find_class']);
Route::middleware('auth:api')->get('/class/{id}/student', [AppController::class, 'class_find_student']);
Route::middleware('auth:api')->post('/line/notify', [AppController::class, 'line_notify']);
Route::middleware('auth:api')->post('/line/notify_queue', [AppController::class, 'notify_queue']);
Route::middleware('auth:api')->post('/profile', [AppController::class, 'profile']);
Route::middleware('auth:api')->post('/manual_sign_check', [AppController::class, 'manual_sign_check']);
Route::middleware('auth:api')->get('/school_all_students', [AppController::class, 'school_all_students']);
Route::middleware('auth:api')->get('/check_active', [AppController::class, 'check_active']);
Route::middleware('auth:api')->get('/download_backup', [AppController::class, 'download_backup']);
Route::middleware('auth:api')->get('/check_latest_profile', [AppController::class, 'check_latest_profile']);

