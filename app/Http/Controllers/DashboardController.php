<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfid;

class DashboardController extends Controller
{
    public function index()
{
    $user = auth()->user();

    // 🔥 base query
    if ($user->role == 'super_admin') {
        $baseQuery = Rfid::query();
    } else {
        $baseQuery = Rfid::where('tenant_id', $user->tenant_id);
    }

    // 🔥 CLONE untuk filter (biar tidak bentrok)
    $query = clone $baseQuery;

    // 🔥 filter tanggal
    if (request('tanggal')) {
        $query->whereDate('created_at', request('tanggal'));
    }

    // 🔥 filter status
    if (request('status')) {
        $query->where('status', request('status'));
    }

    // 🔥 data tabel
    $data = $query->latest()->limit(20)->get();

    // 🔥 statistik (PAKAI baseQuery, bukan query filter)
    $total = $baseQuery->count();
    $masuk = (clone $baseQuery)->where('status', 'MASUK')->count();
    $keluar = (clone $baseQuery)->where('status', 'KELUAR')->count();

    return view('dashboard', compact('data', 'total', 'masuk', 'keluar'));
}

    public function export()
{
    $user = auth()->user();

    // 🔥 base query
    if ($user->role == 'super_admin') {
        $query = Rfid::query();
    } else {
        $query = Rfid::where('tenant_id', $user->tenant_id);
    }

    // 🔥 filter tanggal
    if (request('tanggal')) {
        $query->whereDate('created_at', request('tanggal'));
    }

    // 🔥 filter status
    if (request('status')) {
        $query->where('status', request('status'));
    }

    $data = $query->get();

    $filename = "rfid_export_" . date('Y-m-d') . ".csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function() use ($data) {
        $file = fopen('php://output', 'w');

        fputcsv($file, ['No', 'UID', 'Nama', 'Status', 'Waktu']);

        foreach ($data as $i => $row) {
            fputcsv($file, [
                $i + 1,
                $row->kode,
                $row->nama,
                $row->status,
                $row->updated_at
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}