<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institusi;

class InstitusisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Institusi::create([
            'nama_institusi' => 'Yayasan Karya Bhakti Ska',
            'kode_institusi'=> '01',
        ]);
        Institusi::create([
            'nama_institusi' => 'SMK KATOLIK MIKAEL',
            'kode_institusi'=> '02',
        ]);
        Institusi::create([
            'nama_institusi' => 'POLITEKNIK ATMI SOLO',
            'kode_institusi'=> '03',
        ]);
        Institusi::create([
            'nama_institusi' => 'PT ATMI SOLO',
            'kode_institusi'=> '04',
        ]);
        Institusi::create([
            'nama_institusi' => 'PT ATMI IGI CENTER',
            'kode_institusi'=> '05',
        ]);
        Institusi::create([
            'nama_institusi' => 'PT ATMI BIZDEC',
            'kode_institusi'=> '06',
        ]);
        Institusi::create([
            'nama_institusi' => 'PT PIKA AMBON SEMARANG',
            'kode_institusi'=> '07',
        ]);
        Institusi::create([
            'nama_institusi' => 'ATMI SOLO',
            'kode_institusi'=> '08',
        ]);

    }
}
