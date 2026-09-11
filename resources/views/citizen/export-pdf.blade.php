<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Penduduk</title>
    <style>
        @page { size: landscape; margin: 14mm; }
        * { box-sizing: border-box; }
        body { color: #222; font-family: Arial, sans-serif; font-size: 11px; }
        h1 { color: #173b1e; font-size: 20px; margin: 0 0 4px; }
        p { color: #777; margin: 0 0 18px; }
        table { border-collapse: collapse; width: 100%; }
        th { background: #173b1e; color: #fff; text-align: left; }
        th, td { border: 1px solid #d8ddd8; padding: 7px; }
        tr:nth-child(even) { background: #f5f8f5; }
        .print-button { background: #173b1e; border: 0; color: #fff; cursor: pointer; padding: 9px 14px; margin-bottom: 16px; }
        @media print { .print-button { display: none; } }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    <h1>Data Penduduk</h1>
    <p>Daftar data penduduk dan keluarga</p>
    <table>
        <thead><tr><th>NIK</th><th>Nama</th><th>Nama Istri</th><th>No. Rumah</th><th>Pernikahan</th><th>Anak</th><th>Status</th><th>Pendapatan</th></tr></thead>
        <tbody>
            @forelse($citizens as $citizen)
                <tr><td>{{ $citizen->nik }}</td><td>{{ $citizen->name }}</td><td>{{ $citizen->wife_name ?: '-' }}</td><td>{{ $citizen->house_number }}</td><td>{{ $citizen->marital_status }}</td><td>{{ $citizen->children_count }}</td><td>{{ $citizen->status }}</td><td>{{ $citizen->income_range }}</td></tr>
            @empty
                <tr><td colspan="8">Belum ada data penduduk.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
