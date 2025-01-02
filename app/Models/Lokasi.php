<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lokasi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_lokasi'; //int autoincrement
    protected $fillable = [
        'id_lokasi',
        'nama_lokasi_yayasan',
        'nama_lokasi_mikael',
        'nama_lokasi_politeknik',
        'kode_lokasi',
        'keterangan_lokasi',
        'foto_lokasi'
    ];

    public function ruang(): HasMany
    {
        return $this->hasMany(Ruang::class, 'id_ruang');
    }

    public function fixedasset(): HasMany
    {
        return $this->hasMany(FixedAsset::class, 'id_fa');
    }

    public function permintaan_fa(): HasMany
    {
        return $this->hasMany(PermintaanFixedAsset::class, 'id_permintaan_fa');
    }
}
