<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Yayasan',
            'kode_divisi' => '01',      
        ]);
        Divisi::create([
            'id_institusi' => '8',
            'nama_divisi' => 'Karyawan',
            'kode_divisi' => '02',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Logistik',
            'kode_divisi' => '03',      
        ]);
        Divisi::create([
            'id_institusi' => '3',
            'nama_divisi' => 'Politeknik',
            'kode_divisi' => '04',      
        ]);
     
        Divisi::create([
            'id_institusi' => '8',
            'nama_divisi' => 'Direktur',
            'kode_divisi' => '05',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Finance',
            'kode_divisi' => '06',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Purchasing',
            'kode_divisi' => '07',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Vendor',
            'kode_divisi' => '08',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Support',
            'kode_divisi' => '09',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Accountant',
            'kode_divisi' => '10',      
        ]);
        Divisi::create([
            'id_institusi' => '1',
            'nama_divisi' => 'Procurement',
            'kode_divisi' => '11',      
        ]);
        Divisi::create([
            'id_institusi' => '2',
            'nama_divisi' => 'Mikael',
            'kode_divisi' => '12',      
        ]);
    }
}
