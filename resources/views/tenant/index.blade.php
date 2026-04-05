<x-app-layout>
    <div class="p-6">

        <h2 style="font-size:20px; font-weight:bold;">Kelola Rumah Sakit</h2>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <a href="/tenant/create" 
           style="background:#16a34a; color:white; padding:10px 15px; border-radius:8px;">
            + Tambah RS
        </a>

        <table style="width:100%; margin-top:20px; background:white;">
            <thead style="background:#1e293b; color:white;">
                <tr>
                    <th style="padding:10px;">No</th>
                    <th>Nama RS</th>
                    <th>API KEY</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($tenants as $i => $t)
                <tr style="text-align:center; border-bottom:1px solid #eee;">
                    <td>{{ $i+1 }}</td>
                    <td>{{ $t->name }}</td>
                    <td style="font-size:12px;">{{ $t->api_key }}</td>
                    <td>
                        <form method="POST" action="/tenant/{{ $t->id }}">
                            @csrf
                            @method('DELETE')
                            <button style="background:red; color:white; padding:5px 10px;">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>