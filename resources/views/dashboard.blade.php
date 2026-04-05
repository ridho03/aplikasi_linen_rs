<x-app-layout>
    <x-slot name="header">
        <h2 style="font-weight:bold; font-size:20px;">
            Dashboard Linen Laundry
        </h2>
    </x-slot>

    <div class="p-6" style="background:#f8fafc; min-height:100vh;">

        @if(auth()->user()->role == 'super_admin')

        <div style="margin-bottom:10px; color:#64748b;">
    Mode: <b>Super Admin</b>
</div>

            <!-- 🔴 SUPER ADMIN -->
            <h3 style="margin-bottom:15px;">🔴 Dashboard Global</h3>

            <div style="display:flex; gap:20px; margin-bottom:20px;">

                <div style="flex:1; background:#1e293b; color:white; padding:20px; border-radius:12px;">
                    <h4>Total Semua Linen</h4>
                    <h2>{{ $total ?? 0 }}</h2>
                </div>

                <div style="flex:1; background:#2563eb; color:white; padding:20px; border-radius:12px;">
                    <h4>Total Scan</h4>
                    <h2>{{ $data->count() }}</h2>
                </div>

            </div>

        @else

            <!-- 🟢 ADMIN RS -->
            <h3 style="margin-bottom:15px;">🟢 Dashboard Rumah Sakit</h3>

            <div style="display:flex; gap:20px; margin-bottom:20px;">

                <div style="flex:1; background:#1e293b; padding:20px; border-radius:12px; color:white;">
                    <h4>Total Linen</h4>
                    <h2 style="font-size:30px;">{{ $total ?? 0 }}</h2>
                </div>

                <div style="flex:1; background:#16a34a; padding:20px; border-radius:12px; color:white;">
                    <h4>Masuk</h4>
                    <h2 style="font-size:30px;">{{ $masuk ?? 0 }}</h2>
                </div>

                <div style="flex:1; background:#dc2626; padding:20px; border-radius:12px; color:white;">
                    <h4>Keluar</h4>
                    <h2 style="font-size:30px;">{{ $keluar ?? 0 }}</h2>
                </div>

            </div>

        @endif

        <!-- 🔥 BUTTON -->
        <a href="/rfid/tag" style="background:#4f46e5; color:white; padding:10px 15px; border-radius:8px;">
        Buat Label
        </a>

        <a href="/tenant" 
   style="background:#f59e0b; color:white; padding:10px 15px; border-radius:8px;">
    Kelola RS
</a>

<a href="/tenant/create" style="background:#16a34a; color:white; padding:10px; border-radius:8px;">
Tambah RS
</a>

<a href="/admin/create" style="background:#2563eb; color:white; padding:10px; border-radius:8px;">
    + Tambah Admin
</a>

        <a href="/export?tanggal={{ request('tanggal') }}&status={{ request('status') }}" 
   style="background:#16a34a; color:white; padding:10px 15px; border-radius:8px; margin-left:10px;">
    Export Excel
</a>

<form method="GET" action="/dashboard" style="margin-top:20px; margin-bottom:20px; display:flex; gap:10px;">

    <!-- tanggal -->
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
        style="padding:8px; border-radius:6px; border:1px solid #ccc;">

    <!-- status -->
    <select name="status" style="padding:8px; border-radius:6px; border:1px solid #ccc;">
        <option value="">Semua Status</option>
        <option value="MASUK" {{ request('status') == 'MASUK' ? 'selected' : '' }}>MASUK</option>
        <option value="KELUAR" {{ request('status') == 'KELUAR' ? 'selected' : '' }}>KELUAR</option>
    </select>

    <!-- tombol -->
    <button type="submit" style="background:#2563eb; color:white; padding:8px 15px; border-radius:6px;">
        Filter
    </button>

</form>

        <!-- 🔥 TABLE -->
        <div style="margin-top:20px; background:white; border-radius:12px; overflow:hidden;">
            <table style="width:100%; border-collapse:collapse;">
            
                <thead style="background:#1e293b; color:white;">
                    <tr>
                        <th style="padding:10px;">No</th>
                        <th>UID</th>
                        <th>Nama</th>
                        <th>Waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $i => $d)
                    <tr style="border-bottom:1px solid #eee; text-align:center;">
                        <td style="padding:10px;">{{ $i + 1 }}</td>
                        <td>{{ $d->kode }}</td>
                        <td>{{ $d->nama ?? '-' }}</td>
                        <td>{{ $d->updated_at }}</td>
                        <td>
                           @if($d->status == 'MASUK')
                                <span style="background:#dcfce7; color:#166534; padding:4px 10px; border-radius:999px;">
                                    MASUK
                                </span>
                            @else
                                <span style="background:#fee2e2; color:#991b1b; padding:4px 10px; border-radius:999px;">
                                    KELUAR
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
    <script>
    setInterval(() => {
        window.location.reload();
    }, 5000); // refresh tiap 5 detik
</script>
</x-app-layout>