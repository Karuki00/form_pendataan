<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><title>Data Penduduk</title></head>
<body>
<table border="1">
    <thead>
        <tr><th>NIK</th><th>Nama Lengkap</th><th>Nama Istri / Pasangan</th><th>No. Rumah</th><th>Status Pernikahan</th><th>Jumlah Anak</th><th>Status Penduduk</th><th>Rentang Pendapatan</th></tr>
    </thead>
    <tbody>
        @foreach($citizens as $citizen)
            <tr>
                <td>{{ $citizen->nik }}</td><td>{{ $citizen->name }}</td><td>{{ $citizen->wife_name ?: '-' }}</td><td>{{ $citizen->house_number }}</td>
                <td>{{ $citizen->marital_status }}</td><td>{{ $citizen->children_count }}</td><td>{{ $citizen->status }}</td><td>{{ $citizen->income_range }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
