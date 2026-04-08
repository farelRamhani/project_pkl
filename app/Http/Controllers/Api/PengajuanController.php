<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PengajuanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // GET DATA
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $data = PengajuanSurat::where('status', 'menunggu')
                ->latest()
                ->get();
        } else {
            $data = PengajuanSurat::where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'tujuan' => 'required',
            'perihal' => 'required',
            'file_surat' => 'required|file'
        ]);

        $path = $request->file('file_surat')->store('pengajuan', 'public');

        $data = PengajuanSurat::create([
            'user_id' => Auth::id(),
            'tujuan_surat' => $request->tujuan,
            'perihal' => $request->perihal,
            'file_surat' => $path,
            'status' => 'menunggu'
        ]);

        return response()->json([
            'message' => 'Berhasil kirim pengajuan',
            'data' => $data
        ]);
    }

    // UPDATE STATUS (admin)
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);

        $pengajuan->status = $request->status;
        $pengajuan->save();

        return response()->json([
            'message' => 'Status berhasil diubah'
        ]);
    }
}