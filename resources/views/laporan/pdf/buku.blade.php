<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Buku</title>

<style>
body{
    font-family: Arial, sans-serif;
    font-size:11px;
}

.header{
    text-align:center;
    margin-bottom:20px;
}

.header h2{
    margin:0;
}

.header h3{
    margin:5px 0 0;
    font-weight:normal;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #000;
    padding:5px;
}

table th{
    background:#f2f2f2;
}
</style>

</head>
<body>

<div class="header">
    <h2>LAPORAN DATA BUKU</h2>
    <h3>PERPUSTAKAAN HATUKAU</h3>
</div>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Pengarang</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Jumlah</th>
            <th>Stok</th>
        </tr>
    </thead>

    <tbody>
        @foreach($bukus as $buku)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $buku->judul_buku }}</td>
            <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $buku->pengarang }}</td>
            <td>{{ $buku->penerbit }}</td>
            <td>{{ $buku->tahun_terbit }}</td>
            <td>{{ $buku->jumlah_buku }}</td>
            <td>{{ $buku->stok_tersedia }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>