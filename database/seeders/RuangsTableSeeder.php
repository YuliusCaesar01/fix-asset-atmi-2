<?php

namespace Database\Seeders;

use App\Models\Ruang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RuangsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        Ruang::create([
            'nama_ruang_yayasan'=> 'HK',
            'kode_ruang'=> sprintf("%03d", 1),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Kantor YKBS Utara',
            'kode_ruang'=> sprintf("%03d", 2),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Kantor Manager Aset',
            'kode_ruang'=> sprintf("%03d", 3),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Meeting Dalam',
            'kode_ruang'=> sprintf("%03d", 4),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Meeting Luar',
            'kode_ruang'=> sprintf("%03d", 5),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Ketua YKBS',
            'kode_ruang'=> sprintf("%03d", 6),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Gedung Serbaguna',
            'kode_ruang'=> sprintf("%03d", 7),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Meeting Mikael',
            'kode_ruang'=> sprintf("%03d", 8),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang Portir',
            'kode_ruang'=> sprintf("%03d", 9),
        ]);
        
        Ruang::create([
            'nama_ruang_yayasan'=> 'Ruang HRM Bawah',
            'kode_ruang'=> sprintf("%03d", 10),
        ]);
        
      
        
    }
}
