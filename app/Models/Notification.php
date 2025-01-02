<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the pluralized form of the model name
    protected $table = 'notifications';

    // Define the fillable attributes that can be mass-assigned
    protected $fillable = [
        'id_user_pengirim',
        'id_user_penerima',
        'id_pengajuan',
        'keterangan_notif',
        'jenis_notif',
        'tipe_notif',
    ];
    

    // Relationship to the User model for the sender (user_pengirim)
    public function pengirim()
    {
        return $this->belongsTo(User::class, 'id_user_pengirim');
    }

    // Relationship to the User model for the receiver (user_penerima)
    public function penerima()
    {
        return $this->belongsTo(User::class, 'id_user_penerima');
    }

    // Relationship to the PermintaanFixedAsset model (if it exists)
    public function pengajuan()
    {
        return $this->belongsTo(PermintaanFixedAsset::class, 'id_pengajuan');
    }
}
