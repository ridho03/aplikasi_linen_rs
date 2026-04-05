<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFIDTag extends Model
{
    protected $table = 'rfid_tags';

    protected $fillable = [
    'kode',
    'nama',
    'tenant_id'
];
}