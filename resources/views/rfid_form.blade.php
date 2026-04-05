<!DOCTYPE html>
<html>
<head>
    <title>Input RFID</title>
</head>
<body>

<h2>Input Nama Linen</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/rfid/store">
    @csrf

    <label>Kode RFID:</label><br>
    <input type="text" name="kode" 
       value="{{ $rfid->kode ?? '' }}" 
       readonly>

    <label>Nama Linen:</label><br>
    <input type="text" name="nama" placeholder="Masukkan nama linen" required><br><br>

    <button type="submit">Simpan</button>
</form>

</body>
</html>