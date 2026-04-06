<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfid;
use App\Models\Tenant;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

Rfid::whereNull('nama')
    ->where('created_at', '<', now()->subSeconds(60))
    ->delete();

        $user = auth()->user();

        // 🔥 BASE QUERY (ROLE BASED)
        $baseQuery = $user->role == 'super_admin'
            ? Rfid::query()
            : Rfid::where('tenant_id', $user->tenant_id);

        // 🔥 CLONE UNTUK FILTER
        $query = clone $baseQuery;

        // 🔥 FILTER TANGGAL
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // 🔥 FILTER STATUS
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // 🔥 DATA TABLE
        $data = $query->latest()->limit(20)->get();

        // 🔥 STATISTIK (GLOBAL / TANPA FILTER)
        $total = $baseQuery->count();
        $masuk = (clone $baseQuery)->where('status', 'MASUK')->count();
        $keluar = (clone $baseQuery)->where('status', 'KELUAR')->count();

        // 🔥 KHUSUS SUPER ADMIN
        $total_rs = Tenant::count();
        $total_admin = User::where('role', 'admin')->count();

        return view('dashboard', compact(
            'data',
            'total',
            'masuk',
            'keluar',
            'total_rs',
            'total_admin'
        ));
    }

    public function export(Request $request)
{
    $user = auth()->user();

    // 🔥 BASE QUERY
    $query = $user->role == 'super_admin'
        ? Rfid::query()
        : Rfid::where('tenant_id', $user->tenant_id);

    // 🔥 FILTER
    if ($request->tanggal) {
        $query->whereDate('created_at', $request->tanggal);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    $data = $query->latest()->get();

    $filename = "rfid_export_" . date('Y-m-d') . ".csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    $callback = function () use ($data) {
        $file = fopen('php://output', 'w');

        // 🔥 HEADER BARU
        fputcsv($file, [
            'No',
            'UID',
            'Nama',
            'Status',
            'Waktu Masuk',
            'Waktu Keluar'
        ]);

        foreach ($data as $i => $row) {

            $waktuMasuk = $row->waktu_masuk
                ? $row->waktu_masuk->format('d-m-Y H:i:s')
                : '-';

            $waktuKeluar = $row->waktu_keluar
                ? $row->waktu_keluar->format('d-m-Y H:i:s')
                : '-';

            fputcsv($file, [
                $i + 1,
                $row->kode,
                $row->nama,
                $row->status,
                $waktuMasuk,
                $waktuKeluar
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}