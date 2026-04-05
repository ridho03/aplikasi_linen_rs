<!DOCTYPE html>
<html>
<head>
    <title>Label RFID</title>
    <meta http-equiv="refresh" content="10">
    <style>
        body {
            font-family: Arial;
            background: #f5f7fa;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1976D2;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        input {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background: #218838;
        }
        .btn-back {
    background: #6c757d;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
}

.btn-back:hover {
    background: #5a6268;
}
.form-card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
    </style>
</head>
<body>

<div class="card">
    <h2>Label RFID</h2>
    <div style="margin-bottom:20px;">
    <a href="/dashboard" class="btn-back">← Kembali ke Dashboard</a>
</div>

    @if(session('success'))
        <p style="color:green; text-align:center;">
            {{ session('success') }}
        </p>
    @endif

    @if(session('error'))
    <div style="color:red; text-align:center; margin-bottom:10px;">
        {{ session('error') }}
    </div>
@endif

    <form method="POST" action="/rfid/tag/store">
        @csrf

        <!-- 🔥 UID otomatis -->
        <label>Kode RFID</label>
       <input type="text" name="kode" 
    value="{{ $rfid->kode ?? '' }}"
    placeholder="Scan dulu RFID"
    readonly
    style="width:100%; padding:10px;">

        <!-- 🔥 Input nama -->
        <label>Nama Linen</label>
        <input type="text" name="nama" placeholder="Contoh: Selimut ICU" required>

        <button type="submit">Simpan</button>
    </form>
</div>

</body>
</html>