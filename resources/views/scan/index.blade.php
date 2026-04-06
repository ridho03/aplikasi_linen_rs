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
                    <th>Masuk</th>
                    <th>Keluar</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $i => $d)
                <tr>
                    <td>{{ $data->firstItem() + $i }}</td>
                    <td>{{ $d->kode }}</td>
                    <td>{{ $d->nama }}</td>
                    <td>
                        <span class="badge 
                            @if($d->status == 'MASUK') bg-success 
                            @elseif($d->status == 'KELUAR') bg-danger 
                            @else bg-warning 
                            @endif">
                            {{ $d->status }}
                        </span>
                    </td>
                    <td>{{ optional($d->waktu_masuk)->format('d-m-Y H:i:s') ?? '-' }}</td>
                    <td>{{ optional($d->waktu_keluar)->format('d-m-Y H:i:s') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $data->links() }}

</div>

</x-app-layout>

<script>
function formatDate(date) {
    if (!date) return '-';

    let d = new Date(date);

    let day = String(d.getDate()).padStart(2, '0');
    let month = String(d.getMonth() + 1).padStart(2, '0');
    let year = d.getFullYear();

    let hours = String(d.getHours()).padStart(2, '0');
    let minutes = String(d.getMinutes()).padStart(2, '0');
    let seconds = String(d.getSeconds()).padStart(2, '0');

    return `${day}-${month}-${year} ${hours}:${minutes}:${seconds}`;
}

function loadRealtime() {
    fetch('/scan/realtime')
        .then(res => res.json())
        .then(data => {
            let tbody = document.querySelector("tbody");
            tbody.innerHTML = "";

            data.forEach((d, i) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${d.kode}</td>
                        <td>${d.nama ?? '-'}</td>
                        <td>
                            <span class="badge ${
                                d.status === 'MASUK' ? 'bg-success' :
                                d.status === 'KELUAR' ? 'bg-danger' :
                                'bg-warning'
                            }">
                                ${d.status}
                            </span>
                        </td>
                        <td>${formatDate(d.waktu_masuk)}</td>
                        <td>${formatDate(d.waktu_keluar)}</td>
                    </tr>
                `;
            });
        });
}

setInterval(loadRealtime, 3000);
loadRealtime();
</script>