<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SuratMasukController;
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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/surat-masuk', [SuratMasukController::class, 'index']);
    Route::post('/surat-masuk', [SuratMasukController::class, 'store']);
    Route::get('/surat-masuk/{id}', [SuratMasukController::class, 'show']);
    Route::post('/surat-masuk/{id}', [SuratMasukController::class, 'update']);
    Route::delete('/surat-masuk/{id}', [SuratMasukController::class, 'destroy']);
});


Route::apiResource('surat-masuk', SuratMasukController::class);