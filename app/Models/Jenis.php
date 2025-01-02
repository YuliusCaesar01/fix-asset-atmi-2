<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jenis extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_jenis'; //int autoincrement
    protected $fillable = [
        'id_jenis',
        'id_kelompok',
        'nama_jenis_yayasan',
        'nama_jenis_mikael',
        'nama_jenis_politeknik',
        'kode_jenis',
        'foto_jenis'
    ];
// Automatically set kode_jenis before creating
public static function boot()
{
    parent::boot();

    static::creating(function ($jenis) {
        $lastJenis = self::latest('id_jenis')->first();
        $nextId = $lastJenis ? $lastJenis->id_jenis + 1 : 1;

        // Format as 3-digit code
        $jenis->kode_jenis = str_pad($nextId, 3, '0', STR_PAD_LEFT);
    });
}
    public function kelompok(): BelongsTo
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok');
    }

    public function fixedasset()
    {
        return $this->hasMany(FixedAsset::class, 'id_fa');
    }

    public function permintaan_fa(): HasOne
    {
        return $this->hasOne(PermintaanFixedAsset::class, 'id_permintaan_fa');
    }
}
