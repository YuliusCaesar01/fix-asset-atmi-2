<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipe;

class TipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tipes = [
            ['nama_tipe_yayasan' => 'Inventaris'],
            ['nama_tipe_yayasan' => 'Elektronik'],
            ['nama_tipe_yayasan' => 'Peralatan'],
            ['nama_tipe_yayasan' => 'Peralatan Meeting'],
            ['nama_tipe_yayasan' => 'Peralatan Office']
        ];

        foreach ($tipes as $tipe) {
            Tipe::create($tipe);
        }
    }
}
