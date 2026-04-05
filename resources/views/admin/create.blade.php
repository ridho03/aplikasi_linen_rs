<x-app-layout>

<div style="padding:30px; max-width:500px; margin:auto;">

    <h2 style="font-size:22px; font-weight:bold; margin-bottom:20px;">
        Tambah Admin Rumah Sakit
    </h2>

    @if(session('success'))
        <div style="background:#16a34a; color:white; padding:10px; border-radius:8px; margin-bottom:10px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/admin/store">
        @csrf

        <!-- Nama -->
        <input type="text" name="name" placeholder="Nama Admin"
            style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ccc;"
            required>

        <!-- Email -->
        <input type="email" name="email" placeholder="Email"
            style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ccc;"
            required>

        <!-- Password -->
        <input type="password" name="password" placeholder="Password"
            style="width:100%; padding:10px; margin-bottom:10px; border-radius:8px; border:1px solid #ccc;"
            required>

        <!-- Tenant -->
        <select name="tenant_id"
    style="width:100%; padding:10px; margin-bottom:15px; border-radius:8px; border:1px solid #ccc;"
    required>

    <option value="">-- Pilih Rumah Sakit --</option>

    @foreach($tenants as $t)
        <option value="{{ $t->id }}">
            {{ $t->name }}
        </option>
    @endforeach

</select>

        <!-- Button -->
        <button type="submit"
            style="width:100%; background:#2563eb; color:white; padding:12px; border:none; border-radius:8px;">
            Simpan Admin
        </button>

    </form>

</div>

</x-app-layout>