<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat_logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'action',
        'username',
        'nama_perangkat',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke model Perangkat
    public function device()
    {
        return $this->belongsTo(Perangkat::class);
    }
}
