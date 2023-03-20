<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ClassRoomController;
use App\Http\Controllers\Api\V1\StudentController;
use App\Http\Controllers\Api\V1\TeacherController;
use Illuminate\Support\Facades\Route;


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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('password/email',  [AuthController::class, 'forgotPassword']);
Route::post('password/code/check', [AuthController::class, 'codeCheck']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix' => '/teacher'], function () {
		Route::get('/index', [TeacherController::class, 'index']);
		Route::get('/show/{id}', [TeacherController::class, 'show']);
		Route::post('/store', [TeacherController::class, 'store']);
		Route::put('/update/{id}', [TeacherController::class, 'update']);
		Route::delete('/destroy/{id}', [TeacherController::class, 'destroy']);
	});

    Route::group(['prefix' => '/student'], function () {
		Route::get('/index', [StudentController::class, 'index']);
		Route::get('/show/{id}', [StudentController::class, 'show']);
		Route::post('/store', [StudentController::class, 'store']);
		Route::put('/update/{id}', [StudentController::class, 'update']);
		Route::delete('/destroy/{id}', [StudentController::class, 'destroy']);
	});

    Route::group(['prefix' => '/class_room'], function () {
		Route::get('/index', [ClassRoomController::class, 'index']);
		Route::get('/show/{id}',  [ClassRoomController::class, 'show']);
		Route::post('/find_by_class_name',  [ClassRoomController::class, 'find_by_class_name']);
		Route::post('/store', [ClassRoomController::class, 'store']);
		Route::put('/update/{id}', [ClassRoomController::class, 'update']);
		Route::delete('/destroy/{id}', [ClassRoomController::class, 'destroy']);
	});

});
