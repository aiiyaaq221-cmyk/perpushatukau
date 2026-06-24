<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengunjung</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        h2{
            text-align: center;
            margin-bottom: 20px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:6px;
        }

        table th{
            background:#f2f2f2;
            text-align:center;
        }
    </style>
</head>
<body>

<h2>LAPORAN DATA PENGUNJUNG</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Umur</th>
            <th>Jenis Kelamin</th>
            <th>Status</th>
            <th>Tujuan</th>
            <th>Tanggal Kunjungan</th>
        </tr>
    </thead>

    <tbody>
        @foreach($pengunjungs as $pengunjung)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $pengunjung->nama }}</td>
            <td>{{ $pengunjung->alamat }}</td>
            <td>{{ $pengunjung->umur }}</td>
            <td>{{ $pengunjung->jenis_kelamin }}</td>
            <td>{{ $pengunjung->status_pengunjung }}</td>
            <td>{{ $pengunjung->tujuan }}</td>
            <td>{{ $pengunjung->tanggal_kunjungan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>