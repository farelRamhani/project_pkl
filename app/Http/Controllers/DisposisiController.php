<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SuratMasuk;
use App\Models\Disposisi;
use Auth;

class DisposisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // VALIDASI input
        $request->validate([
            'no_surat' => 'required|exists:surat_masuks,no_surat',
            'user_id' => 'required|exists:users,id',
            'catatan_disposisi' => 'required|string',
        ]);

        // Ambil data surat_masuk berdasarkan no_surat
        $suratMasuk = SuratMasuk::where('no_surat', $request->no_surat)->first();

        if (!$suratMasuk) {
            Alert::error('Surat tidak ditemukan!');
            return redirect()->back();
        }

        // Simpan disposisi
        $disposisi = new Disposisi();
        $disposisi->pengirim_id = Auth::user()->id;
        $disposisi->surat_masuk_id = $suratMasuk->id;
        $disposisi->user_id = $request->user_id;
        $disposisi->catatan_disposisi = $request->catatan_disposisi;
        $disposisi->save();

        // Update status surat
        $suratMasuk->status = 'didisposisi';
        $suratMasuk->save();

        Alert::success('Berhasil Mengirim.');
        return redirect()->route('admin.masuk.index');
    }
}
