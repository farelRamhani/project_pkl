<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan data surat masuk
     */
    public function index()
    {
        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);

        $suratMasuk = SuratMasuk::orderBy('no_surat', 'desc')->get();
        $listakun  = User::where('role', '!=', 'admin')->get();
        $listUser  = User::where('role', 'user')->get();

        return view('admin.masuk.index', compact('suratMasuk', 'listakun', 'listUser'));
    }

    /**
     * Form tambah surat (No Surat otomatis)
     */
    public function create()
    {
        $lastSurat = SuratMasuk::orderBy('no_surat', 'desc')->first();
        $noSurat = $lastSurat ? $lastSurat->no_surat + 1 : 1;

        return view('admin.masuk.create', compact('noSurat'));
    }

    /**
     * Simpan surat masuk
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat'   => 'required|numeric|unique:surat_masuks,no_surat',
            'tgl_surat'  => 'required|date',
            'tgl_terima' => 'required|date',
            'pengirim'   => 'required|string|max:225',
            'perihal'    => 'required|string',
            'file_surat' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $filePath = $request->file('file_surat')->store('surat_masuk', 'public');

        SuratMasuk::create([
            'no_surat'   => $request->no_surat,
            'tgl_surat'  => $request->tgl_surat,
            'tgl_terima' => $request->tgl_terima,
            'pengirim'   => $request->pengirim,
            'perihal'    => $request->perihal,
            'file_surat' => $filePath,
        ]);

        toast('Data berhasil ditambahkan', 'success');
        return redirect()->route('admin.masuk.index');
    }

    /**
     * Form edit
     */
    public function edit($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        return view('admin.masuk.edit', compact('suratMasuk'));
    }

    /**
     * Update data
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_surat'   => 'required|numeric|unique:surat_masuks,no_surat,' . $id,
            'tgl_surat'  => 'required|date',
            'tgl_terima' => 'required|date',
            'pengirim'   => 'required|string|max:225',
            'perihal'    => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        $suratMasuk = SuratMasuk::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_surat && Storage::disk('public')->exists($suratMasuk->file_surat)) {
                Storage::disk('public')->delete($suratMasuk->file_surat);
            }
            $suratMasuk->file_surat = $request->file('file_surat')
                ->store('surat_masuk', 'public');
        }

        $suratMasuk->update([
            'no_surat'   => $request->no_surat,
            'tgl_surat'  => $request->tgl_surat,
            'tgl_terima' => $request->tgl_terima,
            'pengirim'   => $request->pengirim,
            'perihal'    => $request->perihal,
        ]);

        toast('Data berhasil diubah', 'success');
        return redirect()->route('admin.masuk.index');
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);

        if ($suratMasuk->file_surat && Storage::disk('public')->exists($suratMasuk->file_surat)) {
            Storage::disk('public')->delete($suratMasuk->file_surat);
        }

        $suratMasuk->delete();

        toast('Data berhasil dihapus', 'success');
        return redirect()->route('admin.masuk.index');
    }

    /**
     * Lihat file surat
     */
    public function lihat($id)
    {
        $surat = SuratMasuk::findOrFail($id);

        if (!Storage::disk('public')->exists($surat->file_surat)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file(
            storage_path('app/public/' . $surat->file_surat)
        );
    }
}
