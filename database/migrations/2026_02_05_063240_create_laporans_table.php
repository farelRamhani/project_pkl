<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
    $table->id();
    $table->date('tanggal');              // tanggal surat
    $table->enum('jenis', ['masuk','keluar']); // jenis surat
    $table->string('no_surat');           // nomor surat
    $table->string('pengirim_tujuan');   // pengirim atau tujuan
    $table->text('perihal');              // isi perihal
    $table->string('status');             // status surat
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporans', function (Blueprint $table) {
            //
        });
    }
};
