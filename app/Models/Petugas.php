<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Petugas extends Authenticatable
{
    use HasFactory;

    protected $table = 'petugas';

    protected $fillable = [
        'nik',
        'nama',
        'username',
        'password',
        'telp',
        'level',
    ];

    protected $hidden = [
        'password',
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'petugas_id');
    }
}
