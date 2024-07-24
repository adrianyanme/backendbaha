<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perangkat extends Model
{
    protected $fillable = ['serial_number', 'user_id', 'nama_perangkat', 'status_perangkat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}