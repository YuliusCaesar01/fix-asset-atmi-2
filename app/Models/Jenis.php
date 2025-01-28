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
        'nama_kelompok_yayasan',
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
        // Get the kelompok name based on id_kelompok
        $kelompok = Kelompok::find($jenis->id_kelompok);
        $jenis->nama_kelompok_yayasan = $kelompok->nama_kelompok_yayasan;

        // Get the latest kode_jenis for this kelompok
        $lastJenis = self::where('nama_kelompok_yayasan', $kelompok->nama_kelompok_yayasan)
                        ->latest('kode_jenis')
                        ->first();

        // Generate new kode_jenis
        $nextNumber = $lastJenis ? (int)$lastJenis->kode_jenis + 1 : 1;
        $jenis->kode_jenis = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    });
}
    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'id_kelompok', 'id_kelompok');
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
