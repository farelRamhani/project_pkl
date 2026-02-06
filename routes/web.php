<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsKepsek;
use App\Http\Middleware\isUser;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\KepsekController;
use App\Http\Controllers\LaporanController; // << Tambahan untuk laporan

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Auth::routes([
    'register' => false,
]);

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| DOWNLOAD & LIHAT (GLOBAL)
|--------------------------------------------------------------------------
*/
Route::get('/download-surat/masuk/{id}', [HomeController::class, 'download'])
    ->name('suratMasuk.download');

Route::get('/download-surat/pengajuan/{id}', [PengajuanController::class, 'download'])
    ->name('pengajuan.download');

Route::get('/lihat-surat/{id}', [SuratMasukController::class, 'lihat'])
    ->name('surat.lihat')
    ->middleware('auth');

/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/
Route::prefix('user')->middleware(['auth', isUser::class])->group(function () {
    Route::resource('inbox', InboxController::class);
    Route::resource('pengajuan', PengajuanController::class);
    Route::get('arsip', [InboxController::class, 'arsip'])->name('arsip.index');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->middleware(['auth', IsAdmin::class])->group(function () {

    // 🔴 WAJIB DI ATAS RESOURCE (BIAR TIDAK 404)
    Route::get('keluar/lihat/{id}', [SuratKeluarController::class, 'lihat'])
        ->name('keluar.lihat');

    Route::resource('pengajuan', PengajuanController::class);
    Route::resource('masuk', SuratMasukController::class);
    Route::resource('keluar', SuratKeluarController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::resource('users', UsersController::class);

    // ===== LAPORAN SURAT =====
    Route::get('laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| KEPSEK
|--------------------------------------------------------------------------
*/
Route::prefix('kepsek')->as('kepsek.')->middleware(['auth', IsKepsek::class])->group(function () {
    Route::get('masuk', [KepsekController::class, 'index'])->name('masuk.index');
    Route::resource('disposisi', KepsekController::class);
    Route::get('history', [KepsekController::class, 'riwayat'])->name('history.index');
});
