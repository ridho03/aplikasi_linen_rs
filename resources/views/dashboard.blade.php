<x-app-layout>

    <div class="content">

        <h2 class="page-title">
    Halo, {{ auth()->user()->name }} 👋
</h2>

        @if(auth()->user()->role == 'super_admin')

            <!-- 🔥 SUPER ADMIN -->
            <div class="grid">

                <div class="card">
                    <p class="label">🏥 Total Rumah Sakit</p>
                    <h2>{{ $total_rs ?? 0 }}</h2>
                </div>

                <div class="card success">
                    <p class="label">👨‍💼 Total Admin</p>
                    <h2>{{ $total_admin ?? 0 }}</h2>
                </div>

                <div class="card highlight">
                    <p class="label">📦 Total Linen</p>
                    <h2>{{ $total ?? 0 }}</h2>
                </div>

                <div class="card danger">
                    <p class="label">📡 Total Scan</p>
                    <h2>{{ $data->count() }}</h2>
                </div>

            </div>

            <!-- ACTION SUPER ADMIN -->
            <div class="toolbar">
                <div class="toolbar-left">
                    <div class="toolbar-left">
                    <a href="/rfid/tag" class="btn btn-primary">Buat Label</a>
                </div>
                    <a href="/scan" class="btn btn-success">Data RS</a>
                    <a href="/tenant" class="btn btn-warning">Kelola RS</a>
                    <a href="/admin/create" class="btn btn-primary">+ Admin</a>
                </div>
            </div>

        @else

            <!-- 🔥 ADMIN RS -->
            <div class="grid">

                <div class="card">
                    <p class="label">Total Linen</p>
                    <h2>{{ $total ?? 0 }}</h2>
                </div>

                <div class="card success">
                    <p class="label">Linen Masuk</p>
                    <h2>{{ $masuk ?? 0 }}</h2>
                </div>

                <div class="card danger">
                    <p class="label">Linen Keluar</p>
                    <h2>{{ $keluar ?? 0 }}</h2>
                </div>

            </div>

            <!-- TOOLBAR ADMIN RS -->
            <div class="toolbar">

                <form method="GET" action="/dashboard" class="toolbar-right">
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="input">

                    <select name="status" class="input">
                        <option value="">Semua Status</option>
                        <option value="MASUK" {{ request('status') == 'MASUK' ? 'selected' : '' }}>MASUK</option>
                        <option value="KELUAR" {{ request('status') == 'KELUAR' ? 'selected' : '' }}>KELUAR</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Filter</button>

                    <a href="/export?tanggal={{ request('tanggal') }}&status={{ request('status') }}" 
                       class="btn btn-success">
                        Export
                    </a>
                </form>

            </div>

            <!-- TABLE (HANYA ADMIN RS) -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>UID</th>
                            <th>Nama</th>
                            <th>Waktu Masuk</th>
                            <th>Waktu Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($data as $i => $d)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $d->kode }}</td>
                                <td>{{ $d->nama ?? '-' }}</td>
                                <td>{{ optional($d->waktu_masuk)->format('d-m-Y H:i:s') ?? '-' }}</td>
                                <td>{{ optional($d->waktu_keluar)->format('d-m-Y H:i:s') ?? '-' }}</td>

                                <td>
                                    <span class="badge {{ $d->status == 'MASUK' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $d->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        @endif

    </div>

</x-app-layout>