<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\User;
use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KepsekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);

        // INISIALISASI biar tidak undefined
        $suratMasuk = collect();

        if (Auth::user()->role === 'kepsek') {
            $suratMasuk = SuratMasuk::whereHas('disposisi.user', function ($query) {
                $query->where('role', 'kepsek');
            })
            ->with(['disposisi.user'])
            ->get();
        }

        $listUser = User::where('role', 'user')->get();

        return view('admin.masuk.index', compact('suratMasuk', 'listUser'));
    }

    public function riwayat()
    {
        $suratMasuk = SuratMasuk::latest()->get();
        $suratKeluar = SuratKeluar::latest()->get();

        return view('admin.review', compact('suratMasuk', 'suratKeluar'));
    }

    /**
     * Store disposisi dari kepsek
     */
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'no_surat' => 'required',
            'user_id' => 'required|exists:users,id',
            'catatan_disposisi' => 'required|string'
        ]);

        // AMAN: kalau tidak ketemu langsung 404
        $suratMasuk = SuratMasuk::where('no_surat', $request->no_surat)->firstOrFail();

        $disposisi = new Disposisi();
        $disposisi->pengirim_id = Auth::id();
        $disposisi->surat_masuk_id = $suratMasuk->id;
        $disposisi->user_id = $request->user_id;
        $disposisi->catatan_disposisi = $request->catatan_disposisi;
        $disposisi->save();

        toast('Data berhasil ditambahkan', 'success');

        return redirect()->route('kepsek.masuk.index');
    }
}
