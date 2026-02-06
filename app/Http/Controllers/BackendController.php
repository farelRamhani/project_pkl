<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::all();
        $suratKeluar = SuratKeluar::all();
        $totalMasuk = $suratMasuk->count();
        $totalKeluar = $suratKeluar->count();
        return view('admin.index', compact('totalMasuk', 'totalKeluar'));
    }
}
