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
        Schema::create('tanggapans', function (Blueprint $table) {
            $table->id('tanggapanID');
            $table->dateTime('tg_tanggapan');
            $table->text('isi_tanggapan');
            $table->foreignId('petugasID')->constrained('petugas');
            $table->foreignId('pengaduanID')->constrained('pengaduan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanggapans');
    }
};
