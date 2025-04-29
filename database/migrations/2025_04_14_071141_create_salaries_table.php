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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained()->cascadeOnDelete();
            $table->string('nik');
            $table->string('email');
            $table->string('nama');
            $table->string('departemen');
            $table->string('posisi');
            $table->string('gaji_pokok');
            $table->string('tunj_jabatan')->nullable();
            $table->string('tunj_bahasa')->nullable();
            $table->string('tunj_kerajinan')->nullable();
            $table->string('tunj_lainnya')->nullable();
            $table->string('total_gaji');
            $table->string('lembur')->nullable();
            $table->string('uang_makan')->nullable();
            $table->string('potongan_hari')->nullable();
            $table->string('potongan_absensi')->nullable();
            $table->string('denda')->nullable();
            $table->string('bpjs_tk')->nullable();
            $table->string('bpjs_ks')->nullable();
            $table->string('pph21')->nullable();
            $table->string('total_potongan')->nullable();
            $table->string('rapel')->nullable();
            $table->string('gaji_bersih');
            $table->string('terbilang');
            $table->string('tanggal');
            $table->string('link')->nullable();
            $table->string('nomor_surat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
