<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfid extends Model
{
    protected $table = 'rfids'; // 🔥 WAJIB
    protected $fillable = [
    'kode',
    'status',
    'tenant_id',
    'nama',
    'waktu_masuk',
    'waktu_keluar'
];

protected $casts = [
    'waktu_masuk' => 'datetime',
    'waktu_keluar' => 'datetime',
];
}