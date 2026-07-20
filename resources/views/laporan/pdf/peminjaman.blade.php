<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Peminjaman Buku</title>

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

.ttd{
    width:260px;
    float:right;
    text-align:center;
}

.ttd .jabatan{
    margin-bottom:75px;
}

.ttd .nama{
    font-weight:bold;
    text-decoration:underline;
}

.ttd .nip{
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
                Kabupaten Maluku
            </div>
        </td>
    </tr>
</table>

<div class="garis"></div>

<div class="judul text-center" style="font-size:16px;">
    LAPORAN DATA PEMINJAMAN BUKU
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
TABEL LAPORAN
=================================== -->

<table class="data-table">

    <thead>

        <tr>
            <th width="5%">No</th>
            <th width="15%">Kode</th>
            <th width="18%">Nama Anggota</th>
            <th width="28%">Judul Buku</th>
            <th width="12%">Tanggal Pinjam</th>
            <th width="12%">Batas Kembali</th>
            <th width="10%">Status</th>
        </tr>

    </thead>

    <tbody>

    @forelse($peminjamans as $index=>$peminjaman)

        <tr>

            <td class="center">
                {{ $index+1 }}
            </td>

            <td class="center">
                {{ $peminjaman->kode_peminjaman }}
            </td>

            <td>
                {{ $peminjaman->anggota->nama ?? '-' }}
            </td>

            <td>

                @forelse($peminjaman->details as $detail)

                    • {{ $detail->buku->judul_buku ?? '-' }}

                    @if(!$loop->last)
                        <br>
                    @endif

                @empty

                    -

                @endforelse

            </td>

            <td class="center">
                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}
            </td>

            <td class="center">
                {{ \Carbon\Carbon::parse($peminjaman->batas_kembali)->translatedFormat('d F Y') }}
            </td>

            <td class="center">

                @if($peminjaman->status=='Dipinjam')

                    Dipinjam

                @elseif($peminjaman->status=='Dikembalikan')

                    Dikembalikan

                @else

                    Terlambat

                @endif

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="7" class="center">
                Tidak ada data peminjaman.
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
                Arita Muhlisa
            </div>

        </td>

    </tr>

</table>

</body>
</html>