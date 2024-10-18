<?php

use App\Http\Controllers\API\AlumniController;
use App\Http\Controllers\API\LamaranController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\LogoutController;
use App\Http\Controllers\API\PerusahaanController;
use App\Http\Controllers\API\LowonganController;
use App\Http\Controllers\API\PendidikanController;
use App\Http\Controllers\API\PertanyaanController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\TracerStudyController;
use Illuminate\Http\Request;
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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
// Route::post("/logout", [LogoutController::class, 'logout']);
Route::middleware('auth:sanctum')->post('/logout', [LogoutController::class , 'logout']);

//alumni
Route::get('/alumni', [AlumniController::class, 'Alumni']);
Route::post('/create-alumni', [AlumniController::class, 'CreateAlumni']);
Route::middleware('auth:api')->put('/alumni/update', [AlumniController::class, 'UpdateAlumni']);
Route::delete('/delete-alumni/{id_alumni}', [AlumniController::class, 'DeleteAlumni']);
Route::get('/melihat-alumni/{id_alumni}', [AlumniController::class, 'MelihatAlumni']);

// Pertanyaan
Route::get('/pertanyaan', [PertanyaanController::class, 'Pertanyaan']);
Route::post('/create-pertanyaan', [PertanyaanController::class, 'CreatePertanyaan']);
Route::put('/update-pertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'UpdatePertanyaan']);
Route::delete('/delete-pertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'DeletePertanyaan']);
Route::get('/melihat-pertanyaan/{id_pertanyaan}', [PertanyaanController::class, 'MelihatPertanyaan']);

// Lowongan 
Route::get('/lowongan', [LowonganController::class, 'Lowongan']);
Route::post('/create-lowongan', [LowonganController::class, 'CreateLowongan']);
Route::put('/update-lowongan/{id_lowongan}', [LowonganController::class, 'UpdateLowongan']);
Route::delete('/delete-lowongan/{id_lowongan}', [LowonganController::class, 'DeleteLowongan']);
Route::get('/melihat-lowongan/{id_lowongan}', [LowonganController::class, 'MelihatLowongan']);

// Lamaran
Route::get('/lamaran', [LamaranController::class, 'Lamaran']);
Route::post('/create-lamaran', [LamaranController::class, 'CreateLamaran']);
Route::put('/update-lamaran/{id_lamaran}', [LamaranController::class, 'UpdateLamaran']);
Route::delete('/delete-lamaran/{id_lamaran}', [LamaranController::class, 'DeleteLamaran']);
Route::get('/melihat-lamaran/{id_lamaran}', [LamaranController::class, 'MelihatLamaran']);

// Pendidikan
Route::get('/pendidikan', [PendidikanController::class, 'Pendidikan']);
Route::post('/create-pendidikan', [PendidikanController::class, 'CreatePendidikan']);
Route::put('/update-pendidikan/{id_pdd}', [PendidikanController::class, 'UpdatePendidikan']);
Route::delete('/delete-pendidikan/{id_pdd}', [PendidikanController::class, 'DeletePendidikan']);
Route::get('/melihat-pendidikan/{id_pdd}', [PendidikanController::class, 'MelihatPendidikan']);

// Perusahaan
Route::get('/perusahaan', [PerusahaanController::class, 'Perusahaan']);
Route::post('/create-perusahaan', [PerusahaanController::class, 'CreatePerusahaan']);
Route::put('/update-perusahaan/{id_perusahaan}', [PerusahaanController::class, 'UpdatePerusahaan']);
Route::delete('/delete-perusahaan/{id_perusahaan}', [PerusahaanController::class, 'DeletePerusahaan']);
Route::get('/melihat-perusahaan/{id_perusahaan}', [PerusahaanController::class, 'MelihatPerusahaan']);

// Tracer Study
Route::get('/TracerStudy', [TracerStudyController::class, 'TracerStudy']);
Route::post('/create-TracerStudy', [TracerStudyController::class, 'CreateTracerStudy']);
Route::put('/update-TracerStudy/{id_TracerStudy}', [TracerStudyController::class, 'UpdateTracerStudy']);
Route::delete('/delete-TracerStudy/{id_TracerStudy}', [TracerStudyController::class, 'DeleteTracerStudy']);
Route::get('/melihat-TracerStudy/{id_TracerStudy}', [TracerStudyController::class, 'MelihatTracerStudy']);