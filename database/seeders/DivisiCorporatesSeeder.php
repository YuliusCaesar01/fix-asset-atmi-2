<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DivisiCorporate;

class DivisiCorporatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DivisiCorporate::factory()->create([
            'nama_divisicorp' => 'Corporate Division A',
            'kode_divisicorp' => 'CD-A',
        ]);

        DivisiCorporate::factory()->create([
            'nama_divisicorp' => 'Corporate Division B',
            'kode_divisicorp' => 'CD-B',
        ]);

        // Use the factory to create more seed data
        DivisiCorporate::factory(10)->create();
    }
}

