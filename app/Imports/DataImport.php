<?php

namespace App\Imports;

use App\Models\Divisi;
use App\Models\FixedAsset;
use App\Models\Institusi;
use App\Models\Jenis;
use App\Models\Kelompok;
use App\Models\Lokasi;
use App\Models\Ruang;
use App\Models\Tipe;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DataImport implements ToModel, WithStartRow
{
    use Importable, SerializesModels;
    public function startRow(): int
    {
        return 2; // Baris pertama diabaikan (header)
    }
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        //dd($row);
        //foreach ($rows as $row) {
        $id_institusi = Institusi::find($row[1])->id_institusi;
        $id_divisi = Divisi::where('id_institusi', $id_institusi)->where('kode_divisi', $row[2])->first()->id_divisi;
        $id_tipe = Tipe::find($row[3])->id_tipe;
        //dd($row[1], $id_institusi, $row[2], $id_divisi, $row[3], $id_tipe);
        $id_kelompok = Kelompok::where('id_tipe', $id_tipe)->where('kode_kelompok', $row[4])->first()->id_kelompok; // ini gk bisa karena datanya lebih dari 1 CEK LAGI
        $id_jenis = Jenis::where('id_kelompok', $id_kelompok)->where('kode_jenis', $row[5])->first()->id_jenis;
        $id_lokasi = Lokasi::find($row[6])->id_lokasi;
        $id_ruang = Ruang::where('id_divisi', $id_divisi)->where('id_lokasi', $id_lokasi)->where('kode_ruang', $row[7])->first()->id_ruang;

        $kode_max = FixedAsset::where('id_institusi', $id_institusi)->where('id_divisi', $id_divisi)->where('id_tipe', $id_tipe)->where('id_kelompok', $id_kelompok)->where('id_jenis', $id_jenis)->where('id_lokasi', $id_lokasi)->where('id_ruang', $id_ruang)->count();
        $no_urut = str_pad($kode_max + 1, 3, '0', STR_PAD_LEFT);

        $kode_fa = $row[1] . '.' . $row[2] . '.' . $row[3] . '.' . $row[4] . '.' . $row[5] . '.' . $row[6] . '.' . $row[7] . '-' . $no_urut;

        // Unduh gambar dari Imgur
        $imgurUrl = $row[10];
        $image = $this->downloadImage($imgurUrl);

        $idFa = Str::random(32);
        return new FixedAsset([
            "id_fa" => $idFa,
            "id_institusi" => $id_institusi,
            "id_divisi" => $id_divisi,
            "id_tipe" => $id_tipe,
            "id_kelompok" => $id_kelompok,
            "id_jenis" => $id_jenis,
            "id_lokasi" => $id_lokasi,
            "id_ruang" => $id_ruang,
            "no_permintaan" => $row[8],
            "tahun_diterima" => $row[9],
            "foto_barang" => $image,
            "nama_barang" => $row[11],
            "des_barang" => $row[12],
            "status_transaksi" => $row[13],
            "status_barang" => $row[14],
            "kode_fa" => $kode_fa,
        ]);
        //}
    }

    private function downloadImage($url)
    {
        $client = new Client();
        $response = $client->get($url);

        // Simpan gambar ke penyimpanan lokal (storage)
        $filename = basename($url);
        Storage::put("foto_barang/$filename", $response->getBody());

        // Kembalikan path atau URL lokal gambar yang disimpan
        return $filename;
    }
}
