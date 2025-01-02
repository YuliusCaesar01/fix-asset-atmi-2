<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institusi;
use App\Models\Lokasi;

class LokasisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Lokasi::create([
            'nama_lokasi_yayasan' => 'SOLO',
            'keterangan_lokasi' => 'Daerah Surakarta',
            'kode_lokasi'=> '01',
        ]);
       
    }
}
