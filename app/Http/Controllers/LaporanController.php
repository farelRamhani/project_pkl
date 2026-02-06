<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF; // ✨ HARUS DITAMBAHKAN

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $from  = $request->from;
        $to    = $request->to;
        $jenis = $request->jenis;

        // ===== QUERY SURAT MASUK =====
        $suratMasuk = DB::table('surat_masuks')
            ->select(
                'tgl_surat as tanggal',
                DB::raw("'masuk' as jenis"),
                'no_surat',
                DB::raw('pengirim as pengirim_tujuan'),
                'perihal',
                'status'
            );

        // ===== QUERY SURAT KELUAR =====
        $suratKeluar = DB::table('surat_keluars')
            ->select(
                'tgl_surat as tanggal',
                DB::raw("'keluar' as jenis"),
                'no_surat',
                DB::raw('tujuan as pengirim_tujuan'),
                'perihal',
                'status'
            );

        // ===== FILTER TANGGAL =====
        if ($from && $to) {
            $suratMasuk->whereBetween('tgl_surat', [$from, $to]);
            $suratKeluar->whereBetween('tgl_surat', [$from, $to]);
        }

        // ===== FILTER JENIS =====
        if ($jenis == 'masuk') {
            $laporan = $suratMasuk->orderBy('tgl_surat', 'desc')->get();
        } elseif ($jenis == 'keluar') {
            $laporan = $suratKeluar->orderBy('tgl_surat', 'desc')->get();
        } else {
            // unionAll gabungkan semua
            $laporan = $suratMasuk->unionAll($suratKeluar)->get();
            $laporan = collect($laporan)->sortByDesc('tanggal')->values();
        }

        // ===== CETAK PDF =====
        if ($request->has('cetak')) {
            $pdf = PDF::loadView('admin.laporan.pdf', compact('laporan'));
            return $pdf->download('laporan-surat.pdf'); // otomatis download
        }

        // ===== VIEW BIASA =====
        return view('admin.laporan.index', compact('laporan'));
    }
}
