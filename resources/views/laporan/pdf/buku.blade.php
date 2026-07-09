<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Buku</title>
<style>

*{
    font-family: DejaVu Sans, sans-serif;
    box-sizing: border-box;
}

body{
    font-size: 9px;
    color: #000;
}

table{
    width: 100%;
    border-collapse: collapse;
}

/*==================================
HEADER
==================================*/

.header-table{
    margin-bottom: 10px;
}

.logo{
    width: 80px;
}

.text-center,
.center{
    text-align: center;
}

.judul{
    font-size: 18px;
    font-weight: bold;
    text-transform: uppercase;
}

.subjudul{
    font-size: 13px;
    margin-top: 4px;
}

.garis{
    border-top: 3px solid #000;
    border-bottom: 1px solid #000;
    margin: 8px 0 15px;
}

/*==================================
INFO CETAK
==================================*/

.info{
    width: 50%;
    margin-bottom: 15px;
}

.info td{
    padding: 2px 0;
    font-size: 10px;
}

/*==================================
TABEL
==================================*/

.data-table{
    margin-top: 10px;
    table-layout: fixed;
}

.data-table th{
    background: #0d6efd;
    color: #fff;
    border: 1px solid #000;
    padding: 5px 3px;
    text-align: center;
    font-size: 8px;
    font-weight: bold;
}

.data-table td{
    border: 1px solid #000;
    padding: 4px 2px;
    vertical-align: middle;
    font-size: 8px;
    text-align: center;
}

.data-table td:nth-child(3){
    text-align: left;
}

thead{
    display: table-header-group;
}

tfoot{
    display: table-row-group;
}

tr{
    page-break-inside: avoid;
}

.data-table td,
.data-table th{
    word-wrap: break-word;
    overflow-wrap: break-word;
}

/*==================================
FOOTER
==================================*/

.footer{
    width: 100%;
    margin-top: 40px;
}

.jabatan{
    margin-bottom: 65px;
}

.nama{
    font-weight: bold;
    text-decoration: underline;
}

.nip{
    font-size: 10px;
}

</style>
</head>

<body>

<!-- ==================================
HEADER
=================================== -->

<table class="header-table">

    <tr>

        <td width="15%" class="text-center">
            <img src="{{ public_path('img/perpus.png') }}" class="logo">
        </td>

        <td width="85%" class="text-center">

            <div class="judul">
                PERPUSTAKAAN HATUKAU
            </div>

            <div class="subjudul">
                Sistem Informasi Perpustakaan
            </div>

            <div class="subjudul">
                Kabupaten Maluku
            </div>

        </td>

    </tr>

</table>

<div class="garis"></div>

<div class="judul text-center" style="font-size:16px;">
    LAPORAN DATA BUKU
</div>

<br>

<!-- ==================================
INFO CETAK
=================================== -->

<table class="info">

    <tr>
        <td width="35%">Tanggal Cetak</td>
        <td width="5%">:</td>
        <td>{{ $tanggalCetak }}</td>
    </tr>

    <tr>
        <td>Jam Cetak</td>
        <td>:</td>
        <td>{{ $jamCetak }}</td>
    </tr>

    <tr>
        <td>Jumlah Data</td>
        <td>:</td>
        <td>{{ $jumlahData }} Data</td>
    </tr>

</table>

<!-- ==================================
TABEL
=================================== -->

<table class="data-table">
    <thead>
        <tr>
            <th width="3%">No</th>
            <th width="7%">Kode</th>
            <th width="16%">Judul Buku</th>
            <th width="10%">Kategori</th>
            <th width="10%">Pengarang</th>
            <th width="10%">Penerbit</th>
            <th width="5%">Tahun</th>
            <th width="8%">Tgl Masuk</th>
            <th width="5%">Jilid</th>
            <th width="5%">Edisi</th>
            <th width="7%">Sumber</th>
            <th width="5%">Jumlah</th>
            <th width="4%">Stok</th>
            <th width="5%">Ket.</th>
        </tr>
    </thead>

    <tbody>
    @forelse($bukus as $index => $buku)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $buku->kode_buku ?? '-' }}</td>
            <td>{{ $buku->judul_buku ?? '-' }}</td>
            <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $buku->pengarang ?? '-' }}</td>
            <td>{{ $buku->penerbit ?? '-' }}</td>
            <td>{{ $buku->tahun_terbit ?? '-' }}</td>
            <td>{{ $buku->tanggal_masuk ? \Carbon\Carbon::parse($buku->tanggal_masuk)->format('d-m-Y') : '-' }}</td>
            <td>{{ $buku->jilid ?? '-' }}</td>
            <td>{{ $buku->edisi ?? '-' }}</td>
            <td>{{ $buku->sumber ?? '-' }}</td>
            <td>{{ $buku->jumlah_buku ?? '-' }}</td>
            <td>{{ $buku->stok_tersedia ?? '-' }}</td>
            <td>{{ $buku->keterangan ?? '-' }}</td>
        </tr>
    @empty

        <tr>
            <td colspan="9" class="center">
                Tidak ada data buku.
            </td>
        </tr>

    @endforelse

    </tbody>
</table>

<!-- ==================================
FOOTER
=================================== -->

<table class="footer">

    <tr>

        <td width="60%"></td>

        <td width="40%" align="center">

            Hatukau, {{ $tanggalCetak }}

            <br><br>

            <div class="jabatan">
                Kepala Perpustakaan
            </div>

            <br><br><br><br>

            <div class="nama">
                ........................................
            </div>

            <div class="nip">
                NIP. ..................................
            </div>

        </td>

    </tr>

</table>

</body>
</html>