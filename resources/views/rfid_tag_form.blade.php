<x-app-layout>

    <div class="content">

        <!-- HEADER -->
        <div class="page-header">
            <h2 class="page-title">Label RFID</h2>

            <a href="/dashboard" class="btn btn-warning">
                ← Kembali
            </a>
        </div>

        <!-- ALERT -->
        @if(session('success'))
            <div class="card alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="card alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <div class="card form-card">

            <form method="POST" action="/rfid/tag/store" class="form">
                @csrf

                <!-- UID -->
                <div class="form-group">
                    <label>Kode RFID</label>

                    <input type="text" id="kodeInput" name="kode"
                    value="{{ $rfid->kode ?? '' }}"
                    readonly
                    class="input">

                    @if(!$rfid)
                        <small class="text-warning">
                            Belum ada RFID di-scan
                        </small>
                    @endif
                </div>

                <!-- NAMA -->
                <div class="form-group">
                    <label>Nama Linen</label>

                    <input type="text" name="nama"
                        placeholder="Contoh: Selimut ICU"
                        required
                        class="input">
                </div>

                <!-- BUTTON -->
                <div class="form-action">
                    <button type="submit" class="btn btn-primary">
                        💾 Simpan Label
                    </button>
                </div>

            </form>

        </div>

    </div>

    <!-- 🔥 REALTIME SCRIPT -->
    <script>
    let lastKode = '';

    setInterval(() => {
        fetch('/rfid/latest')
            .then(res => res.json())
            .then(data => {

                const input = document.getElementById('kodeInput');

                // 🔥 kalau belum ada input, stop
                if (!input) return;

                // 🔥 hanya update kalau beda
                if (data.kode && data.kode !== lastKode) {
                    lastKode = data.kode;

                    input.value = data.kode;

                    // 🔥 efek highlight
                    input.style.border = "2px solid #22c55e";

                    setTimeout(() => {
                        input.style.border = "";
                    }, 500);
                }

            })
            .catch(err => {
                console.log('Error fetch RFID:', err);
            });

    }, 2000);
    </script>

</x-app-layout>