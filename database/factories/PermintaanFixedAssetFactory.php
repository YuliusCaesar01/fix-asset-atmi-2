<?php
namespace Database\Factories;

use App\Models\PermintaanFixedAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermintaanFixedAssetFactory extends Factory
{
    protected $model = PermintaanFixedAsset::class;

    private static $approvalStatus = ['setuju', 'tidak setuju'];

    public function definition()
    {
        static $idPermintaanFA = 1;

        return [
            'id_permintaan_fa' => $idPermintaanFA++,
            'no_permintaan' => $this->faker->unique()->text(10),
            'id_divisi' => 1, // Ganti dengan ID divisi yang sesuai
            'id_divisicorp' => 1,
            'id_institusi' => 1, // Ganti dengan ID institusi yang sesuai
            'id_tipe' => 1, // Ganti dengan ID tipe yang sesuai
            'id_kelompok' => 1, // Ganti dengan ID kelompok yang sesuai
            'id_jenis' => 1, // Ganti dengan ID jenis yang sesuai
            'id_lokasi' => 1, // Ganti dengan ID lokasi yang sesuai
            'id_ruang' => 1, // Ganti dengan ID ruang yang sesuai
            'tgl_permintaan' => now(),
            'no_pembelian' => $this->faker->unique()->text(10),
            'deskripsi_permintaan' => $this->faker->text,
            'status_permohonan' => 'Pengadaan Baru',
            'alasan_permintaan' => $this->faker->text(100),
            'harga_permintaan' => $this->faker->randomFloat(2, 100, 10000),
            'valid_kepalaunit' => $this->faker->randomElement(['setuju', 'revisi', 'tolak', 'menunggu']),
'valid_mancor' => $this->faker->randomElement(['setuju', 'revisi', 'tolak', 'menunggu']),
'valid_wadir' => $this->faker->randomElement(['setuju', 'revisi', 'tolak', 'menunggu']),
'valid_dir' => $this->faker->randomElement(['setuju', 'revisi', 'tolak', 'menunggu']),
'valid_logistik' => $this->faker->randomElement(['setuju', 'revisi', 'tolak', 'menunggu']),

            'tglvalid_kepalaunit' => now(),
            'tglvalid_mancor' => now(),
            'tglvalid_wadir' => now(),
            'tglvalid_dir' => now(),
            'tglvalid_logistik' => now(),
            'note_kepalaunit' => $this->faker->text,
            'note_mancor' => $this->faker->text,
            'note_wadir' => $this->faker->text,
            'note_dir' => $this->faker->text,
            'note_logistik' => $this->faker->text,
        ];
    }
}


