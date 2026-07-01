@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/laporan/pengembalian.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="container-fluid pt-1 pb-4">
    <div class="header-card mb-4">
        <div class="page-header">
            <div class="page-info">
                <h2 class="page-title"> 📚 Laporan Pengembalian </h2>
                <p class="page-subtitle"> Data Pengembalian Perpustakaan Hatukau </p>
            </div>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('laporan.pengembalian.excel') }}" class="btn btn-success btn-modern-export"> 📊 Export Excel </a>
                <a href="{{ route('laporan.pengembalian.pdf') }}" class="btn btn-danger btn-modern-export"> 📄 Export PDF </a>
            </div>
        </div>
    </div>
    
    <!-- STATISTIK -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <small>Total Pengembalian</small>
                    <h2 class="fw-bold">
                        {{ $totalPengembalian }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <small>Tepat Waktu</small>
                    <h2 class="fw-bold">
                        {{ $tepatWaktu }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <small>Terlambat</small>
                    <h2 class="fw-bold"> {{ $terlambat }} </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-body">
            <form id="filterForm" method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label>Nama Peminjam</label>
                        <input type="text" name="nama" id="namaInput" class="form-control" placeholder="Cari nama anggota..." value="{{ request('nama') }}" 
                            onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Pengembalian</label>
                        <input type="date" name="tanggal" class="form-control auto-submit" value="{{ request('tanggal') }}" 
                            onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-select auto-submit">
                            <option value="">Semua</option>
                            <option value="Tepat Waktu"
                                {{ request('status') == 'Tepat Waktu' ? 'selected' : '' }}>
                                Tepat Waktu
                            </option>
                            <option value="Terlambat"
                                {{ request('status') == 'Terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search"> </i> Filter
                        </button>

                        @if(request()->hasAny(['nama','tanggal','status']))
                            <a href="{{ route('laporan.pengembalian') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->

    <div class="card table-card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h5 class="fw-bold mb-0 table-title">
                        Data Transaksi Pengembalian Buku
                    </h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table modern-table align-middle text-center">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Peminjaman</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($pengembalians as $item)
                        <tr>
                            <td> {{ $loop->iteration }} </td>
                            <td>
                                <span class="kode-peminjaman">
                                    {{ $item->peminjaman->kode_peminjaman ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <strong>
                                    {{ $item->peminjaman->anggota->nama ?? '-' }}
                                </strong>
                            </td>
                            <td> {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }} </td>
                            <td>
                                @if($item->status_pengembalian == 'Tepat Waktu')
                                    <span class="badge bg-success">
                                        Tepat Waktu
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Terlambat
                                    </span>

                                @endif
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                Tidak ada data pengembalian
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection