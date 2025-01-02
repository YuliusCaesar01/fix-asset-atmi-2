<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Institusi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_institusi'; //int autoincrement
    protected $fillable = [
        'id_institusi',
        'nama_institusi',
        'kode_institusi',
        'foto_institusi',
    ];

    public function divisi(): HasMany
    {
        return $this->hasMany(Divisi::class, 'id_divisi');
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
