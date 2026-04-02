<?php

namespace Database\Seeders;
use App\Models\Petugas;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Petugas::create([
            'nik' => '1234567890123456',
            'nama' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'telp' => '08123456789',
            'level' => 'admin',
        ]);
    }
}
