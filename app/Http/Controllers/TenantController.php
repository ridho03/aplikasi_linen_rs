<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    // 📋 list RS
    public function index()
    {
        $tenants = Tenant::latest()->get();
        return view('tenant.index', compact('tenants'));
    }

    // ➕ form tambah RS
    public function create()
    {
        return view('tenant.create');
    }

    // 💾 simpan RS
    public function store(Request $request)
    {
        // 🔥 VALIDASI
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Tenant::create([
            'name' => $request->name,
            'api_key' => Str::random(40)
        ]);

        return redirect('/tenant')
            ->with('success', 'RS berhasil ditambahkan');
    }

    public function destroy(Tenant $id)
{
    $id->delete();

    return back()->with('success', 'RS berhasil dihapus');
}
}