<x-app-layout>

    <div class="content">

        <h2 class="page-title">Tambah Rumah Sakit</h2>

        <div class="form-wrapper">

            <div class="card">

                <form method="POST" action="/tenant">
                    @csrf

                    <div class="form-group">
                        <label>Nama RS</label><br><br>
                        <input type="text" name="name" class="input" required>
                    </div>

                    <div style="margin-top:15px;">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="/tenant" class="btn btn-warning">Kembali</a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>