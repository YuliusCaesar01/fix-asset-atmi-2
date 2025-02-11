<?php

namespace Modules\ManageAset\Exports;

use App\Models\FixedAsset;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FixedAssetExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return FixedAsset::join('institusis', 'fixed_assets.id_institusi', '=', 'institusis.id_institusi')
        ->join('lokasis', 'fixed_assets.id_lokasi', '=', 'lokasis.id_lokasi')
        ->join('ruangs', 'fixed_assets.id_ruang', '=', 'ruangs.id_ruang')
        ->join('kelompoks', 'fixed_assets.id_kelompok', '=', 'kelompoks.id_kelompok')
        ->join('jenis', 'fixed_assets.id_jenis', '=', 'jenis.id_jenis')
        ->join('tipes', 'fixed_assets.id_tipe', '=', 'tipes.id_tipe')
        ->select(
                'fixed_assets.kode_fa',
                'lokasis.nama_lokasi_yayasan',
                'institusis.nama_institusi',
                'ruangs.nama_ruang',
                'kelompoks.nama_kelompok_yayasan',
                'jenis.nama_jenis_yayasan',
                'tipes.nama_tipe_yayasan',
                'fixed_assets.nama_barang',
                'fixed_assets.des_barang',
                'fixed_assets.tahun_diterima',
                'fixed_assets.status_transaksi',
                'fixed_assets.jumlah_unit',
                'fixed_assets.status_barang',
            )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Fixed Asset',
            'Nama Lokasi ',
            'Nama Institusi',
            'Nama Ruang',
            'Nama Kelompok',
            'Nama Jenis',
            'Nama Tipe',
            'Nama Aset',
            'Deskripsi Aset',
            'Tahun Diterima',
            'Status Transaksi',
            'Jumlah Aset',
            'Kondisi',
        ];
    }
}
