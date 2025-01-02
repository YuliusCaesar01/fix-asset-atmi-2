<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\PermintaanFixedAsset;

class PermintaanFixedAssetsSeeder extends Seeder
{
    public function run()
    {
        PermintaanFixedAsset::factory()->count(10)->create();
    }
}

