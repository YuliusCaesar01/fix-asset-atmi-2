<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruang extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ruang'; //int autoincrement
    protected $fillable = [
        'id_ruang',
        'id_divisi',
        'id_lokasi',
        'id_institusi',
        'nama_institusi',
        'nama_ruang',
        'nama_ruang_yayasan',
        'nama_ruang_mikael',
        'nama_ruang_politeknik',
        'nama_ruang_pt_atmi_solo',
        'kode_ruang',
        'foto_ruang'
    ];

    public function lokasi(): BelongsTo
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'id_divisi');
    }

    public function fixedasset(): HasMany
    {
        return $this->hasMany(FixedAsset::class, 'id_fa');
    }

    public function permintaan_fa(): HasMany
    {
        return $this->hasMany(PermintaanFixedAsset::class, 'id_permintaan_fa');
    }
    public function institusi()
    {
        return $this->belongsTo(Institusi::class, 'id_institusi', 'id_institusi');
    }
}
