<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function store(Request $request)
    {
        // 🔥 hanya super admin boleh akses
        if (auth()->user()->role != 'super_admin') {
            abort(403);
        }

        // 🔥 validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'tenant_id' => 'required'
        ]);

        // 🔥 simpan admin baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $request->tenant_id,
            'role' => 'admin'
        ]);

        return back()->with('success', 'Admin berhasil dibuat');
    }
}