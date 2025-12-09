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
        <p>Data Calon Pengantin:</p>
        <table>
            @foreach($data ?? [] as $k=>$v)
                <tr><td style="padding:4px 8px;font-weight:bold;">{{ ucwords(str_replace('_',' ',$k)) }}</td><td style="padding:4px 8px;">: {{ is_array($v) ? json_encode($v) : $v }}</td></tr>
            @endforeach
        </table>

        <p style="margin-top:20px">Surat pengantar untuk keperluan nikah.</p>
    </div>
</body>
</html>
