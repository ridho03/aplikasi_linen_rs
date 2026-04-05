<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RFIDLog extends Model
{
    protected $table = 'rfid_logs';

    protected $fillable = [
        'uid',
        'status',
        'tenant_id'
    ];
}