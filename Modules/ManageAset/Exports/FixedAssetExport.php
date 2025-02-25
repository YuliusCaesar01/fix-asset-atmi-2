<?php
namespace Modules\ManageAset\Exports;

use App\Models\FixedAsset;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FixedAssetExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = FixedAsset::join('institusis', 'fixed_assets.id_institusi', '=', 'institusis.id_institusi')
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
            );

        // Apply filters if they exist
        if (!empty($this->filters)) {
            if (isset($this->filters['id_lokasi']) && $this->filters['id_lokasi']) {
                $query->where('fixed_assets.id_lokasi', $this->filters['id_lokasi']);
            }
            
            if (isset($this->filters['id_institusi']) && $this->filters['id_institusi']) {
                $query->where('fixed_assets.id_institusi', $this->filters['id_institusi']);
            }
            
            if (isset($this->filters['id_ruang']) && $this->filters['id_ruang']) {
                $query->where('fixed_assets.id_ruang', $this->filters['id_ruang']);
            }
            
            if (isset($this->filters['id_kelompok']) && $this->filters['id_kelompok']) {
                $query->where('fixed_assets.id_kelompok', $this->filters['id_kelompok']);
            }
            
            if (isset($this->filters['id_jenis']) && $this->filters['id_jenis']) {
                $query->where('fixed_assets.id_jenis', $this->filters['id_jenis']);
            }
            
            if (isset($this->filters['id_tipe']) && $this->filters['id_tipe']) {
                $query->where('fixed_assets.id_tipe', $this->filters['id_tipe']);
            }
        }

        return $query->get();
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