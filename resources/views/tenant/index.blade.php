<x-app-layout>

    <div class="content">

        <!-- HEADER -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h2 class="page-title">Kelola Rumah Sakit</h2>

            <div style="display:flex; gap:10px;">
                <a href="/tenant/create" class="btn btn-success">+ Tambah RS</a>
                <a href="/dashboard" class="btn btn-warning">← Dashboard</a>
            </div>
        </div>

        <!-- ALERT -->
        @if(session('success'))
            <div class="card" style="margin-bottom:15px;">
                <span style="color:#4ade80;">
                    {{ session('success') }}
                </span>
            </div>
        @endif

        <!-- TABLE -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Nama RS</th>
                        <th>API KEY</th>
                        <th style="width:180px; text-align:center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tenants as $i => $t)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $t->name }}</td>

                            <!-- API KEY (dipotong) -->
                            <td>
                                <span class="api-key">
                                    {{ substr($t->api_key, 0, 12) }}...
                                </span>

                                <!-- hidden full key -->
                                <span id="key-{{ $t->id }}" style="display:none;">
                                    {{ $t->api_key }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <div style="display:flex; justify-content:center; gap:8px;">

                                    <!-- COPY -->
                                    <button onclick="copyKey('{{ $t->id }}')" 
                                            class="btn btn-primary btn-sm">
                                        Copy
                                    </button>

                                    <!-- DELETE -->
                                    <form method="POST" action="/tenant/{{ $t->id }}">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center;">
                                Belum ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

    <!-- SCRIPT COPY -->
    <script>
        function copyKey(id) {
            const text = document.getElementById('key-' + id).innerText;

            navigator.clipboard.writeText(text).then(() => {
                alert('API Key berhasil di-copy!');
            });
        }
    </script>

</x-app-layout>