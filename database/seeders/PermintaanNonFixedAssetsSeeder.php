<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermintaanNonFixedAsset;
use App\Models\User; // Import the User model if not already imported
use App\Models\Institusi;

class PermintaanNonFixedAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $institusis = Institusi::all(); // Get all institusis from the institusis table

        $data = [
            [
                'id_user' => 1,
                'id_institusi' => $institusis->random()->id_institusi, // Assign a random institusi ID
                'deskripsi_pengajuan' => 'Tiner',
                'validasi_atasan' => 'setuju',
                'validasi_availability' => 'ditolak',
                'status' => 'ditolak',
                'jenis_pelayanan' => 'barang',
                'kebutuhan' => 'butuh_subcon',
                'keteranganteknis' => 'tidak_ada_keteranganteknis',
                'validasi_finance' => 'menunggu',
                'catatan' => 'barangnya kurang jelas',
            ],
            [
                'id_user' => 4,
                'id_institusi' => $institusis->random()->id_institusi,
                'deskripsi_pengajuan' => 'Spidol',
                'validasi_atasan' => 'revisi',
                'validasi_availability' => 'menunggu',
                'status' => 'menunggu',
                'jenis_pelayanan' => 'jasa',
                'kebutuhan' => 'tidak_ada',
                'keteranganteknis' => 'tidak_ada_keteranganteknis',
                'validasi_finance' => 'menunggu',
                'catatan' => 'tidak_ada_catatan',
            ],
            [
                'id_user' => 7,
                'id_institusi' => $institusis->random()->id_institusi,
                'deskripsi_pengajuan' => 'Tinta',
                'validasi_atasan' => 'setuju',
                'validasi_availability' => 'setuju',
                'status' => 'selesai',
                'jenis_pelayanan' => 'barang',
                'kebutuhan' => 'butuh_subcon',
                'keteranganteknis' => 'biaya 1jt',
                'validasi_finance' => 'setuju',
                'catatan' => 'mempunyai dana yang cukup',
            ],
            // Add more data as needed
        ];

        foreach ($data as $record) {
            PermintaanNonFixedAsset::create($record);
        }
    }
}