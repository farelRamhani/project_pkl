<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // DEFAULT supaya blade tidak error
        $suratMasuk   = collect();
        $suratKeluar  = collect();
        $totalMasuk   = 0;
        $totalKeluar  = 0;
        $totalArsip   = 0;
        $totalUsers   = 0;
        $inbox        = 0;

        if (Auth::user()->role == 'admin' || Auth::user()->role == 'kepsek') {

            $suratMasuk   = SuratMasuk::latest()->get();
            $suratKeluar  = SuratKeluar::latest()->get();

            $totalMasuk   = $suratMasuk->count();
            $totalKeluar  = $suratKeluar->count();
            $totalArsip   = SuratMasuk::where('status', 'ditindaklanjuti')->count();
            $totalUsers   = User::count();

        } elseif (Auth::user()->role == 'user') {

            $inbox = Disposisi::where('user_id', Auth::id())->count();
        }

        return view('admin.index', compact(
            'suratMasuk',
            'suratKeluar',
            'totalMasuk',
            'totalKeluar',
            'totalArsip',
            'totalUsers',
            'inbox'
        ));
    }

    public function download($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        $isAuthorized = Disposisi::where('user_id', Auth::id())
            ->where('surat_masuk_id', $id)
            ->exists();

        if (!$isAuthorized) {
            abort(403, 'Lu bukan yang ditugasin, diem aja bro 💀');
        }

        return response()->download(
            storage_path('app/public/' . $surat->file_surat)
        );
    }
}
