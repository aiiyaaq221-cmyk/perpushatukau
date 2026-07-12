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
    <div class="row mb-2">
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
            <form method="GET" action="{{ route('laporan.pengembalian') }}">
                <div class="row g-3">

                    <div class="col-md-5">
                        <label>Nama Peminjam</label>
                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Cari nama anggota..."
                            value="{{ request('nama') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Pengembalian</label>
                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select
                            name="status"
                            class="form-select">

                            <option value="">Semua</option>

                            <option value="Tepat Waktu"
                                {{ request('status')=='Tepat Waktu' ? 'selected' : '' }}>
                                Tepat Waktu
                            </option>

                            <option value="Terlambat"
                                {{ request('status')=='Terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search"></i>
                        </button>

                        @if(request()->hasAny(['nama','tanggal','status']))
                            <a href="{{ route('laporan.pengembalian') }}"
                            class="btn btn-secondary">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="modern-card" id="tableData">

        <!-- Header -->
        <div class="card-header-custom">
            <h5 class="table-title">
                Data Transaksi Pengembalian Buku
            </h5>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table modern-table align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Peminjaman</th>
                        <th>Nama Anggota</th>
                        <th>Tanggal Kembali</th>
                        <th width="260">Buku</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengembalians as $item)
                    <tr>
                        <td>{{ $pengembalians->firstItem() + $loop->index }}</td>
                        <td>
                            <span class="kode-peminjaman">
                                {{ $item->peminjaman->kode_peminjaman ?? '-' }}
                            </span>
                        </td>
                        <td class="nama-anggota"> {{ $item->peminjaman->anggota->nama ?? '-' }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</td>
                        <td>
                            <div class="book-items">
                                @foreach($item->peminjaman->details->take(2) as $detail)
                                    <div class="book-item">
                                        <i class="fas fa-book"></i>
                                        <span>{{ $detail->buku->judul_buku }}</span>
                                        @if($detail->jumlah > 1)
                                            <small>×{{ $detail->jumlah }}</small>
                                        @endif
                                    </div>
                                @endforeach

                                @if($item->peminjaman->details->count() > 2)
                                    <div id="moreBooks{{ $item->id_pengembalian }}" class="more-books" style="display:none;">
                                        @foreach($item->peminjaman->details->skip(2) as $detail)
                                            <div class="book-item">
                                                <i class="fas fa-book"></i>
                                                <span>{{ $detail->buku->judul_buku }}</span>
                                                @if($detail->jumlah > 1)
                                                    <small>×{{ $detail->jumlah }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <small
                                        class="toggle-books"
                                        data-target="moreBooks{{ $item->id_pengembalian }}"
                                        data-count="{{ $item->peminjaman->details->count()-2 }}">
                                        +{{ $item->peminjaman->details->count()-2 }} lainnya
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($item->status_pengembalian=='Tepat Waktu')
                                <span class="badge bg-success">
                                    Tepat Waktu
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Terlambat
                                </span>
                            @endif
                        </td>
                        <td>{{ $item->peminjaman?->keterangan ?? '-' }}</td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="6" class="empty-data">
                            Tidak ada data pengembalian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <small class="text-muted">
                Menampilkan {{ $pengembalians->firstItem() ?? 0 }} - {{ $pengembalians->lastItem() ?? 0 }} dari{{ $pengembalians->total() }}</small>
            {{ $pengembalians->fragment('tableData')->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection