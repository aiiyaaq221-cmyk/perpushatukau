<!DOCTYPE html>
<html>
<head>
    <title>Laporan Anggota</title>
    <style>
        table { width:100%; border-collapse: collapse; }
        table, th, td { border:1px solid black; }
        th, td { padding:8px; text-align:center; }
    </style>
</head>
<body>

<h3 style="text-align:center;">Laporan Anggota</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($anggotas as $a)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $a->kode_anggota }}</td>
            <td>{{ $a->nama }}</td>
            <td>{{ $a->alamat }}</td>
            <td>{{ $a->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>