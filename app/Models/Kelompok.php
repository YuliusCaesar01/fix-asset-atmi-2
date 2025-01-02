<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelompok extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_kelompok'; //int autoincrement
    protected $fillable = [
        'id_kelompok',
        'id_tipe',
        'nama_kelompok_yayasan',
        'nama_kelompok_mikael',
        'nama_kelompok_politeknik',
        'kode_kelompok',
        'foto_kelompok'
    ];
   // Automatically generate kode_kelompok when creating
   protected static function booted()
   {
       static::creating(function ($kelompok) {
           // Format ID: pad to 2 digits
           $kelompok->kode_kelompok = str_pad($kelompok->id_kelompok ?? Kelompok::max('id_kelompok') + 1, 2, '0', STR_PAD_LEFT);
       });
   }
    public function tipe(): BelongsTo
    {
        return $this->belongsTo(Tipe::class, 'id_tipe');
    }

    public function jenis(): HasMany
    {
        return $this->hasMany(Jenis::class, 'id_jenis');
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
