<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanFixedAsset extends Model
{
    use HasFactory;

    protected $table = 'permintaan_fixed_assets';

    protected $primaryKey = 'id_permintaan_fa';

    public $incrementing = true;

    protected $fillable = [
        'no_permintaan',
        'id_divisi',
        'id_user',
        'id_divisicorp',
        'id_institusi',
        'id_tipe',
        'id_kelompok',
        'id_jenis',
        'id_lokasi',
        'id_ruang',
        'tgl_permintaan',
        'no_pembelian',
        'deskripsi_permintaan',
        'perkiraan_harga',
        'perolehan_harga',
        'status_permohonan',
        'alasan_permintaan',
        'unit_pemohon',
        'unit_tujuan',
        'unit_asal',
        'harga_permintaan',
        'valid_fixaset',
        'valid_fixaset_timestamp',
        'valid_karyausaha',
        'valid_karyausaha_timestamp',
        'valid_dirmanageraset',
        'valid_dirmanageraset_timestamp',
        'valid_manageraset',
        'valid_manageraset_timestamp',
        'catatan',
        'file_pdf',
        'foto_barang',
        'pdf_bukti_1',
    'nama_barang',
    'merk_barang',
    'jumlah_unit',
    'file_pengesahan_bast',
    'file_pengajuan_fa',
    ];

    protected $casts = [
        'tgl_permintaan' => 'datetime',
        'valid_fixaset_timestamp' => 'datetime',
        'valid_karyausaha_timestamp' => 'datetime',
        'valid_ketuayayasan_timestamp' => 'datetime',
        'valid_dirkeuangan_timestamp' => 'datetime',
        'valid_dirmanageraset_timestamp' => 'datetime',
        'valid_manageraset_timestamp' => 'datetime',
    ];

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function divisicorp(): BelongsTo
    {
        return $this->belongsTo(DivisiCorporate::class, 'id_divisicorp');
    }

    public function institusi(): BelongsTo
    {
        return $this->belongsTo(Institusi::class, 'id_institusi');
    }

    public function tipe(): BelongsTo
    {
        return $this->belongsTo(Tipe::class, 'id_tipe');
    }

    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok');
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class, 'id_jenis');
    }

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
