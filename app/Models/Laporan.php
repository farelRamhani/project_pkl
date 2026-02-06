<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    // Model ini digunakan untuk query gabungan SuratMasuk & SuratKeluar
    // Tidak perlu $table jika pakai query builder di controller
    protected $fillable = [
        'tanggal',
        'jenis',
        'no_surat',
        'pengirim_tujuan',
        'perihal',
        'status'
    ];

    public $timestamps = false;
}
