<x-app-layout>
    <div class="p-6">

        <h2 style="font-size:20px; font-weight:bold;">Tambah Rumah Sakit</h2>

        <form method="POST" action="/tenant/store">
            @csrf

            <label>Nama RS</label>
            <input type="text" name="name" required 
                   style="width:100%; padding:10px; margin-top:5px;">

            <button type="submit" 
                    style="margin-top:15px; background:#2563eb; color:white; padding:10px 15px;">
                Simpan
            </button>
        </form>

    </div>
</x-app-layout>