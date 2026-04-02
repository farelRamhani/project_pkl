<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SuratMasukController extends Controller
{
    /**
     * Ambil semua data surat masuk
     */
    public function index()
    {
        try {
            $data = SuratMasuk::all();

            return response()->json([
                'success' => true,
                'message' => 'Data surat masuk berhasil diambil',
                'data'    => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tambah data surat masuk baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'no_surat'   => 'required|string|max:50|unique:surat_masuks,no_surat',
                'tgl_surat'  => 'required|date',
                'tgl_terima' => 'required|date',
                'pengirim'   => 'required|string|max:100',
                'perihal'    => 'required|string',
                'status'     => 'nullable|in:baru,diproses,selesai'
            ]);

            $data = SuratMasuk::create($validated);

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

    /**
     * Tampilkan detail satu surat masuk
     */
    public function show($id)
    {
        try {
            $data = SuratMasuk::find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data surat masuk tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan',
                'data'    => $data
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update data surat masuk
     */
    public function update(Request $request, $id)
    {
        try {
            $data = SuratMasuk::find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data surat masuk tidak ditemukan'
                ], 404);
            }

            $validated = $request->validate([
                'no_surat'   => 'sometimes|string|max:50|unique:surat_masuks,no_surat,' . $id,
                'tgl_surat'  => 'sometimes|date',
                'tgl_terima' => 'sometimes|date',
                'pengirim'   => 'sometimes|string|max:100',
                'perihal'    => 'sometimes|string',
                'status'     => 'nullable|in:baru,diproses,selesai'
            ]);

            $data->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data surat masuk berhasil diupdate',
                'data'    => $data->fresh()
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus data surat masuk
     */
    public function destroy($id)
    {
        try {
            $data = SuratMasuk::find($id);

            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data surat masuk tidak ditemukan'
                ], 404);
            }

            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data surat masuk berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}