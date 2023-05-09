<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaceRecognitionController;

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

Route::get('/', function () {
    return view('layout.template');
});

Route::get('/index', function () {
    return view('layout.template');
});

Route::get('/absen', function () {
    return view('absensi');
});

Route::get('/datafacerecognition', [FaceRecognitionController::class, 'viewdata'])->name('viewdata');

Route::post('/facerecognition', [FaceRecognitionController::class, 'facerecognition'])->name('facerecognition');