<x-app-layout>

<div class="content">

    <div class="page-header">
    <h2 class="page-title">Data Scan Linen</h2>

    <a href="/dashboard" class="btn btn-warning">
        🏠 Dashboard
    </a>
</div>

    <!-- FILTER -->
    <form method="GET" class="toolbar">

        @if(auth()->user()->role == 'super_admin')
        <select name="tenant_id" class="input">
            <option value="">Semua RS</option>
            @foreach($tenants as $t)
                <option value="{{ $t->id }}">
                    {{ $t->name }}
                </option>
            @endforeach
        </select>
        @endif

        <input type="date" name="tanggal" class="input">

        <select name="status" class="input">
            <option value="">Semua Status</option>
            <option value="MASUK">MASUK</option>
            <option value="KELUAR">KELUAR</option>
        </select>

        <button class="btn btn-primary">Filter</button>

    </form>

    <!-- TABLE -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>UID</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Waktu</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>{{ $d->kode }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>{{ $d->status }}</td>
                    <td>{{ $d->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $data->links() }}

</div>

</x-app-layout>