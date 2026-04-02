<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'tg_pengaduan',
        'isi_laporan',
        'foto',
        'status',
        'petugas_id',
    ];

   public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class, 'pengaduan_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id');
    }
}