<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Rfid;
use App\Http\Controllers\RfidController;

Route::get('/rfid', [RfidController::class, 'scan']);
