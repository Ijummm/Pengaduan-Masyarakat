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
            $table->id('id_tanggapan');
            $table->dateTime('tg_tanggapan');
            $table->text('isi_tanggapan');
            $table->foreignId('petugas_id')->constrained('petugas');
            $table->foreignId('pengaduan_id')->constrained('pengaduan');
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
