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
        Tenant::create([
            'name' => $request->name,
            'api_key' => Str::random(40) // 🔥 auto generate
        ]);

        return redirect('/tenant')->with('success', 'RS berhasil ditambahkan');
    }

    // ❌ hapus RS
    public function destroy($id)
    {
        Tenant::findOrFail($id)->delete();
        return back()->with('success', 'RS berhasil dihapus');
    }
}