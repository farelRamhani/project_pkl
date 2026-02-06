<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratMasuk extends Model
{
    
    protected $table = 'surat_masuks';
    protected $fillable = ['no_surat', 'tgl_surat', 'tgl_terima', 'pengirim', 'perihal', 'file_surat', 'status'];
    public $timestamp = true;

    
    public function tindakLanjut(){
        return $this->hasMany(TindakLanjut::class);
    }

    
    public function disposisi(){
        return $this->hasMany(Disposisi::class, 'surat_masuk_id');
    }
}
