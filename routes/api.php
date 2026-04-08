<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SuratMasukController;
use App\Http\Controllers\Api\PengajuanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ===== AUTH =====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ===== USER LOGIN =====
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===== SEMUA API YANG BUTUH LOGIN =====
Route::middleware('auth:sanctum')->group(function () {

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

    // ===== SURAT MASUK =====
    Route::get('/surat-masuk', [SuratMasukController::class, 'index']);
    Route::post('/surat-masuk', [SuratMasukController::class, 'store']);
    Route::get('/surat-masuk/{id}', [SuratMasukController::class, 'show']);
    Route::post('/surat-masuk/{id}', [SuratMasukController::class, 'update']);
    Route::delete('/surat-masuk/{id}', [SuratMasukController::class, 'destroy']);

    // ===== INBOX & ARSIP =====
    Route::get('/inbox', [SuratMasukController::class, 'inbox']);
    Route::get('/arsip', [SuratMasukController::class, 'arsip']);

    // ===== PENGAJUAN =====
    Route::get('/pengajuan', [PengajuanController::class, 'index']);
    Route::post('/pengajuan', [PengajuanController::class, 'store']);
    Route::post('/pengajuan/{id}', [PengajuanController::class, 'update']);
});

