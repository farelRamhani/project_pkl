<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isAdmin;
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
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;

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

    Route::get('keluar/lihat/{id}', [SuratKeluarController::class, 'lihat'])
        ->name('keluar.lihat');

    Route::resource('pengajuan', PengajuanController::class);
    Route::resource('masuk', SuratMasukController::class);
    Route::resource('keluar', SuratKeluarController::class);
    Route::resource('disposisi', DisposisiController::class);
    Route::resource('users', UsersController::class);

    Route::get('laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');
});

/*
|--------------------------------------------------------------------------
| KEPSEK (FIX DI SINI 🔥)
|--------------------------------------------------------------------------
*/
Route::prefix('kepsek')->as('kepsek.')->middleware(['auth', IsKepsek::class])->group(function () {
    Route::get('masuk', [KepsekController::class, 'index'])->name('masuk.index');

    // 🔥 FIX: pakai DisposisiController (bukan KepsekController)
    Route::resource('disposisi', DisposisiController::class);

    Route::get('history', [KepsekController::class, 'riwayat'])->name('history.index');
});

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

});

/*
|--------------------------------------------------------------------------
| MESSAGES
|--------------------------------------------------------------------------
*/
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/read/{id}', [MessageController::class, 'read'])->name('messages.read');
Route::delete('/messages/{id}', [MessageController::class, 'destroy'])->name('messages.delete');