<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $title = 'Hapus Data!';
        $text = "Apakah anda yakin?";
        confirmDelete($title, $text);
        $suratKeluar = SuratKeluar::latest()->get();
        $pengajuans = PengajuanSurat::where('status', 'disetujui')->get();
        return view ('admin.keluar.index', compact('suratKeluar', 'pengajuans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.keluar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_surat' => 'required|unique:surat_keluars',
            'tgl_surat' => 'required|string',
            'tujuan' => 'required',
            'perihal' => 'required|string',
            'file_surat' => 'required|file|mimes:pdf,doc,docx',
        ]);
        $path = $request->file('file_surat')->store('surat_keluar', 'public');
        $suratKeluar = new SuratKeluar();
        $suratKeluar->no_surat = $request->no_surat;
        $suratKeluar->tgl_surat = $request->tgl_surat;
        $suratKeluar->tujuan = $request->tujuan;
        $suratKeluar->perihal = $request->perihal;
        $suratKeluar->file_surat = $path;
        $suratKeluar->status = $request->status;
        $suratKeluar->save();

        toast('Data berhasil ditambahkan', 'success');
        return redirect()->route('admin.keluar.index');
    }

    /**
     * Display the specified resource.
     */
   public function show($id)
    {
        $surat = SuratKeluar::findOrFail($id);

        $path = public_path('storage/' . $surat->file_surat);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->file($path);
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $suratKeluar = SuratKeluar::findOrFail($id);
        return view('admin.keluar.edit', compact('suratKeluar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_surat' => 'required|string',
            'tgl_surat' => 'required|date',
            'tujuan' => 'required',
            'perihal' => 'required|string',
            'file_surat' => 'nullable',
        ]);
        $suratKeluar = SuratKeluar::findOrFail($id);
        if ($request->hasFile('file_surat')) {
            $path = $request->file('file_surat')->store('surat_keluar', 'public');
            $suratKeluar->file_surat = $path;
        }
        $suratKeluar->no_surat = $request->no_surat;
        $suratKeluar->tgl_surat = $request->tgl_surat;
        $suratKeluar->tujuan = $request->tujuan;
        $suratKeluar->perihal = $request->perihal;
        $suratKeluar->save();

        
        toast('Data berhasil diubah', 'success');
        return redirect()->route('admin.keluar.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $suratKeluar =SuratKeluar::findOrFail($id);
        if ($suratKeluar->file_surat && Storage::disk('public')->exists($suratKeluar->file_surat)) {
            Storage::disk('public')->delete($suratKeluar->file_surat);
        }
        $suratKeluar->delete();
        
        toast('Data berhasil dihapus', 'success');
        return redirect()->route('admin.keluar.index');

    }
    

}
