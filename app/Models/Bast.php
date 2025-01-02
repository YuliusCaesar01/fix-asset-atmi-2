<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bast extends Model
{
    use HasFactory;

    // Specify the table name if it does not follow Laravel's convention
    protected $table = 'bast';

    // Define the primary key if it is not the default 'id'
    protected $primaryKey = 'id_bast';

    // If you don't want Laravel to handle timestamps
    public $timestamps = true; // Or false if not used

    // Guard attributes that should not be mass assignable
    protected $guarded = ['id_bast', 'BAST']; // Add other attributes that should not be mass-assignable

    // Optional: Define relationships if needed
    public function permintaanFixedAsset()
    {
        return $this->belongsTo(PermintaanFixedAsset::class, 'id_permintaan_fa');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}