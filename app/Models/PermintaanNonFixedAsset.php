<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanNonFixedAsset extends Model
{
    use HasFactory;

    protected $table = 'permintaan_non_fixed_assets';

    protected $primaryKey = 'id_permintaan_nfa';

    // Enable timestamps
    public $timestamps = true;

    protected $fillable = [
        'id_user', 
        'id_mancor',
        'id_kepalaunit',
        'deskripsi_pengajuan',
        'validasi_kaprodi',
        'validasi_coporate', 
        'status',
        'jenis_pelayanan',
        'kebutuhan',
        'keteranganteknis',
        'validasi_finance',
        'catatan',
        
    ];

    // Definisikan relasi dengan model User untuk id_user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Definisikan relasi dengan model User untuk id_mancor
}