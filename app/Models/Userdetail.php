<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Userdetail extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_userdetail'; // int autoincrement
    protected $fillable = [
        'id_user',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'no_induk_karyawan',
        'no_hp',
        'foto'
    ];

    // Define the relationship with the User model
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user'); // Ensure correct foreign key
    }
}
