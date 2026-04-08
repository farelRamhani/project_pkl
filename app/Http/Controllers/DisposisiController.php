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
        // ✅ VALIDASI
        $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuks,id',
            'user_id' => 'required|exists:users,id',
            'catatan_disposisi' => 'required|string',
        ]);

        // ✅ AMBIL DATA SURAT
        $suratMasuk = SuratMasuk::findOrFail($request->surat_masuk_id);

        // ✅ SIMPAN DISPOSISI
        Disposisi::create([
            'pengirim_id' => Auth::id(),
            'surat_masuk_id' => $suratMasuk->id,
            'user_id' => $request->user_id,
            'catatan_disposisi' => $request->catatan_disposisi,
        ]);

        // 🔥 BEDAKAN ROLE
        if (Auth::user()->role === 'kepsek') {
            $suratMasuk->update([
                'status' => 'ditindaklanjuti'
            ]);
        } else {
            $suratMasuk->update([
                'status' => 'didisposisi'
            ]);
        }

        // ✅ ALERT
        Alert::success('Berhasil Mengirim.');

        return back();
    }
}