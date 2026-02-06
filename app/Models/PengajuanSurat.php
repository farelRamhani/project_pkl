<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class PengajuanSurat extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'user_id', 'tujuan_surat', 'perihal', 'isi_surat', 'status_pengajuan'];
    public $timestamp = true;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
