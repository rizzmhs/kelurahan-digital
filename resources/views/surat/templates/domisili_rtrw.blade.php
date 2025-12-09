<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $jenisSurat->nama ?? 'Surat' }}</title>
    <style>body{font-family: DejaVu Sans, sans-serif;} .header{text-align:center;margin-bottom:20px}</style>
</head>
<body>
    <div class="header">
        <h2>{{ $jenisSurat->nama ?? 'Surat' }}</h2>
        <p>Nomor: {{ $surat->nomor_surat ?? '-' }} | Tanggal: {{ $tanggal }}</p>
    </div>

    <div>
        <p>Alamat: {{ $data['alamat'] ?? '-' }} (RT/RW: {{ $data['rt_rw'] ?? '-' }})</p>
    </div>
</body>
</html>
