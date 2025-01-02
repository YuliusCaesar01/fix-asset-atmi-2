<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Divisi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_divisi'; //int autoincrement
    protected $fillable = [
        'id_divisi',
        'id_institusi',
        'nama_divisi',
        'kode_divisi'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function institusi(): BelongsTo
    {
        return $this->belongsTo(Institusi::class, 'id_institusi');
    }

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
