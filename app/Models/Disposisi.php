<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposisi extends Model
{
    protected $fillable = ['pengirim_id', 'surat_masuk_id', 'user_id', 'catatan_disposisi'];
    public $timestamp = true;

    public function suratMasuk(){
        return $this->belongsTo(SuratMasuk::class, 'surat_masuk_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'pengirim_id'); // pengirim
    }
}
