<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Data Buku</title>

<style>

*{
    font-family:DejaVu Sans,sans-serif;
    box-sizing:border-box;
}

body{
    font-size:12px;
    color:#000;
}

table{
    width:100%;
    border-collapse:collapse;
}

/*==================================
HEADER
==================================*/

.header-table{
    margin-bottom:10px;
}

.logo{
    width:90px;
}

.text-center{
    text-align:center;
}

.center{
    text-align:center;
}

.judul{
    font-size:20px;
    font-weight:bold;
    text-transform:uppercase;
}

.subjudul{
    font-size:15px;
    margin-top:4px;
}

.garis{
    border-top:3px solid #000;
    border-bottom:1px solid #000;
    margin:8px 0 18px;
}

/*==================================
INFO CETAK
==================================*/

.info{
    width:45%;
    margin-bottom:18px;
}

.info td{
    padding:3px 0;
}

/*==================================
TABEL
==================================*/

.data-table{
    margin-top:10px;
}

.data-table th{
    background:#0d6efd;
    color:#fff;
    border:1px solid #000;
    padding:8px;
    text-align:center;
    font-size:11px;
}

.data-table td{
    border:1px solid #000;
    padding:7px;
    vertical-align:top;
    font-size:11px;
}

thead{
    display:table-header-group;
}

tfoot{
    display:table-row-group;
}

tr{
    page-break-inside:avoid;
}

.data-table td,
.data-table th{
    word-wrap:break-word;
}

/*==================================
FOOTER
==================================*/

.footer{
    width:100%;
    margin-top:55px;
}

.jabatan{
    margin-bottom:75px;
}

.nama{
    font-weight:bold;
    text-decoration:underline;
}

.nip{
    font-size:11px;
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
                Kabupaten Maluku Tengah
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
            <th width="5%">No</th>
            <th width="10%">Kode</th>
            <th width="24%">Judul Buku</th>
            <th width="14%">Kategori</th>
            <th width="13%">Pengarang</th>
            <th width="12%">Penerbit</th>
            <th width="8%">Tahun</th>
            <th width="7%">Jumlah</th>
            <th width="7%">Stok</th>
        </tr>

    </thead>

    <tbody>

    @forelse($bukus as $index => $buku)

        <tr>

            <td class="center">
                {{ $index + 1 }}
            </td>

            <td class="center">
                {{ $buku->kode_buku }}
            </td>

            <td>
                {{ $buku->judul_buku }}
            </td>

            <td>
                {{ $buku->kategori->nama_kategori ?? '-' }}
            </td>

            <td>
                {{ $buku->pengarang }}
            </td>

            <td>
                {{ $buku->penerbit }}
            </td>

            <td class="center">
                {{ $buku->tahun_terbit }}
            </td>

            <td class="center">
                {{ $buku->jumlah_buku }}
            </td>

            <td class="center">
                {{ $buku->stok_tersedia }}
            </td>

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