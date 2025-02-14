<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitDetail extends Model
{
    protected $fillable = ['id_fa', 'kode_fa', 'unit_number', 'merk', 'seri'];

    public function fixedAsset()
    {
        return $this->belongsTo(FixedAsset::class, 'id_fa', 'id_fa');
    }
}
