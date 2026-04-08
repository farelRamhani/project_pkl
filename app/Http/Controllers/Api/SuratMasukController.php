<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SuratMasukController extends Controller
{
    // ===== INDEX =====
    public function index()
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::latest()->get();
            } else {
                $data = SuratMasuk::where('user_id', $user->id)->latest()->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Data surat masuk berhasil diambil',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===== STORE =====
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'no_surat'   => 'required|string|max:50|unique:surat_masuks,no_surat',
                'tgl_surat'  => 'required|date',
                'tgl_terima' => 'required|date',
                'pengirim'   => 'required|string|max:100',
                'perihal'    => 'required|string',
                'status'     => 'nullable|in:baru,diproses,selesai,arsip'
            ]);

            $data = SuratMasuk::create([
                'no_surat'   => $validated['no_surat'],
                'tgl_surat'  => $validated['tgl_surat'],
                'tgl_terima' => $validated['tgl_terima'],
                'pengirim'   => $validated['pengirim'],
                'perihal'    => $validated['perihal'],
                'status'     => $validated['status'] ?? 'baru',
                'user_id'    => auth()->id(), // 🔥 PENTING
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Surat masuk berhasil ditambahkan',
                'data'    => $data
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menambahkan data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ===== SHOW =====
    public function show($id)
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::find($id);
            } else {
                $data = SuratMasuk::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();
            }

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===== UPDATE =====
    public function update(Request $request, $id)
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::find($id);
            } else {
                $data = SuratMasuk::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();
            }

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $validated = $request->validate([
                'no_surat'   => 'sometimes|string|max:50|unique:surat_masuks,no_surat,' . $id,
                'tgl_surat'  => 'sometimes|date',
                'tgl_terima' => 'sometimes|date',
                'pengirim'   => 'sometimes|string|max:100',
                'perihal'    => 'sometimes|string',
                'status'     => 'nullable|in:baru,diproses,selesai,arsip'
            ]);

            $data->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil diupdate',
                'data' => $data->fresh()
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===== DELETE =====
    public function destroy($id)
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::find($id);
            } else {
                $data = SuratMasuk::where('id', $id)
                    ->where('user_id', $user->id)
                    ->first();
            }

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===== INBOX =====
    public function inbox()
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::where('status', '!=', 'arsip')->latest()->get();
            } else {
                $data = SuratMasuk::where('user_id', $user->id)
                    ->where('status', '!=', 'arsip')
                    ->latest()
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Data inbox berhasil diambil',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // ===== ARSIP =====
    public function arsip()
    {
        try {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $data = SuratMasuk::where('status', 'arsip')->latest()->get();
            } else {
                $data = SuratMasuk::where('user_id', $user->id)
                    ->where('status', 'arsip')
                    ->latest()
                    ->get();
            }

            return response()->json([
                'success' => true,
                'message' => 'Data arsip berhasil diambil',
                'data' => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}