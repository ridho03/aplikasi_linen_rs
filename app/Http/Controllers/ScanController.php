<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfid;
use App\Models\Tenant;

class ScanController extends Controller
{
    public function index(Request $request)
    {
        Rfid::whereNull('nama')
    ->where('created_at', '<', now()->subSeconds(60))
    ->delete();
        $user = auth()->user();

        // 🔥 base query
        $query = $user->role == 'super_admin'
            ? Rfid::query()
            : Rfid::where('tenant_id', $user->tenant_id);

        // 🔥 filter RS (khusus super admin)
        if ($request->tenant_id) {
            $query->where('tenant_id', $request->tenant_id);
        }

        // 🔥 filter tanggal
        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // 🔥 filter status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->latest()->paginate(10);

        $tenants = Tenant::all(); // 🔥 dropdown RS

        return view('scan.index', compact('data', 'tenants'));
    }
}