@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transaksi/pengembalian.css') }}">
@endsection


@section('content')

<div class="header-card">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title">  📚 Data Pengembalian </h2>
            <p class="page-subtitle"> Riwayat pengembalian buku perpustakaan </p>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="stat-card blue">
            <h3>{{ $totalPengembalian }}</h3>
            <p>Total Pengembalian</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card green">
            <h3>{{ $tepatWaktu }}</h3>
            <p>Tepat Waktu</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card red">
            <h3>{{ $terlambat }}</h3>
            <p>Terlambat</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card yellow">
            <h3>{{ $persenTerlambat }}%</h3>
            <p>Persentase Terlambat</p>
        </div>
    </div>
</div>

<div class="modern-card">
    <div class="table-responsive">
        <table class="table modern-table text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Peminjaman</th>
                    <th>Nama Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengembalians as $item)

                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ $item->peminjaman->kode_peminjaman }} </td>
                    <td> {{ $item->peminjaman->anggota->nama }} </td>
                    <td> {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pinjam)->format('d-m-Y') }} </td>
                    <td> {{ \Carbon\Carbon::parse($item->peminjaman->batas_kembali)->format('d-m-Y') }} </td>
                    <td> {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }} </td>
                    <td>
                        @if($item->status_pengembalian == 'Tepat Waktu')
                            <span class="badge bg-success"> Tepat Waktu  </span>
                        @else
                            <span class="badge bg-danger"> Terlambat </span>
                        @endif
                    </td>

                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id_pengembalian }}">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty

                <tr>
                    <td colspan="8"> Belum ada data pengembalian </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('transaksi.pengembalian.modal-detail')

@endsection