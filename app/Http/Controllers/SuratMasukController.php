<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Disposisi;
use App\Models\User;
use App\Models\SuratMasuk;
use Illuminate\Support\Facades\Auth;

class SuratMasukController extends Controller
{
    /**
     * Middleware auth
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);

        $suratMasuk = SuratMasuk::latest()->get();
        $listakun = User::where('role', '!=', 'admin')->get();
        $listUser = User::where('role', 'user')->get();

        return view('admin.masuk.index', compact('suratMasuk', 'listakun', 'listUser'));
    }

    public function create()
    {
        return view('admin.masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|string|unique:surat_masuks',
            'tgl_surat' => 'required|date',
            'tgl_terima' => 'required|date',
            'pengirim' => 'required|string|max:225',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $file = $request->file('file_surat');
        $filePath = $file->store('surat_masuk', 'public');

        $suratMasuk = new SuratMasuk();
        $suratMasuk->no_surat = $request->no_surat;
        $suratMasuk->tgl_surat = $request->tgl_surat;
        $suratMasuk->tgl_terima = $request->tgl_terima;
        $suratMasuk->pengirim = $request->pengirim;
        $suratMasuk->perihal = $request->perihal;
        $suratMasuk->file_surat = $filePath;
        $suratMasuk->save();

        toast('Data berhasil ditambahkan', 'success');
        return redirect()->route('admin.masuk.index');
    }

    public function edit($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
        return view('admin.masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'no_surat' => 'required|string|unique:surat_masuks,no_surat,' . $id,
            'tgl_surat' => 'required|date',
            'tgl_terima' => 'required|date',
            'pengirim' => 'required|string|max:225',
            'perihal' => 'required|string',
            'file_surat' => 'nullable|file',
        ]);

        $suratMasuk = SuratMasuk::findOrFail($id);

        if ($request->hasFile('file_surat')) {
            $path = $request->file('file_surat')->store('surat_masuk', 'public');
            $suratMasuk->file_surat = $path;
        }

        $suratMasuk->no_surat = $request->no_surat;
        $suratMasuk->tgl_surat = $request->tgl_surat;
        $suratMasuk->tgl_terima = $request->tgl_terima;
        $suratMasuk->pengirim = $request->pengirim;
        $suratMasuk->perihal = $request->perihal;
        $suratMasuk->save();

        toast('Data berhasil diubah', 'success');
        return redirect()->route('admin.masuk.index');
    }

    public function destroy($id)
    {
        $suratMasuk = SuratMasuk::findOrFail($id);
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
