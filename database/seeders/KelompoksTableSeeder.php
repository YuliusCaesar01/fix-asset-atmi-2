<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelompok;

class KelompoksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //1
        Kelompok::create([
            'nama_kelompok_yayasan' => 'Inventaris',
            'kode_kelompok' => '01'
        ]);

        //2
        Kelompok::create([
            'nama_kelompok_yayasan' => 'Tools',
            'kode_kelompok' => '02'
        ]);

       
    }
}
