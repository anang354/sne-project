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
        Schema::create('thr_salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_thr_id')->constrained('periode_thrs')->onDelete('cascade');
            $table->string('nip')->required();
            $table->string('name')->required();
            $table->string('email')->required();
            $table->string('departemen')->required();
            $table->string('position')->required(); 
            $table->string('religion')->required();
            $table->string('join_date')->required();
            $table->string('masa_kerja')->required();
            $table->integer('pph21')->default(0);   
            $table->integer('thp')->required();
            $table->string('terbilang')->required();
            $table->string('file')->nullable();
            $table->boolean('is_pdf')->nullable()->default(false);
            $table->boolean('is_sent')->nullable()->default(false);
            $table->string('nomor_surat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thr_salaries');
    }
};
