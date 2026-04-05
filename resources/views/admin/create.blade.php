<x-app-layout>

    <div class="content">

        <h2 class="page-title">Tambah Admin Rumah Sakit</h2>

        <div class="form-wrapper">

            <div class="card">
                @if(session('success'))
                    <div class="card" style="margin-bottom:15px;">
                        <span style="color:#4ade80;">
                            {{ session('success') }}
                        </span>
                    </div>
                @endif

                <form method="POST" action="/admin">
                    @csrf

                    <!-- NAMA -->
                    <div class="form-group">
                        <label>Nama Admin</label>
                        <input type="text" name="name" class="input" required>
                    </div>

                    <!-- EMAIL -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="input" required>
                    </div>

                    <!-- PASSWORD -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="input" required>
                    </div>

                    <!-- TENANT -->
                    <div class="form-group">
                        <label>Rumah Sakit</label>
                        <select name="tenant_id" class="input" required>
                            <option value="">-- Pilih Rumah Sakit --</option>
                            @foreach($tenants as $t)
                                <option value="{{ $t->id }}">
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- BUTTON -->
                    <div style="margin-top:20px; display:flex; gap:10px;">
                        <button class="btn btn-primary">Simpan</button>
                        <a href="/dashboard" class="btn btn-warning">Kembali</a>
                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>