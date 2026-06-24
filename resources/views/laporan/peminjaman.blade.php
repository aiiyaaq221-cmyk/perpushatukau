@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/laporan/peminjaman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- HEADER -->
    <div class="card border-0 shadow-sm report-header mb-4">
        <div class="card-body">
           <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1">
                        <i class="fas fa-book-reader text-primary me-2"></i>
                        Laporan Peminjaman
                    </h3>

                    <p class="text-muted mb-0">
                        Data seluruh transaksi peminjaman buku
                    </p>
                </div>

                <div class="d-flex gap-2">
                    <a href="#"
                        class="btn btn-success">

                        <i class="fas fa-file-excel me-2"></i>
                        Export Excel
                    </a>

                    <a href="#"
                        class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i>
                        Export PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTIK -->

    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <small>Total Peminjaman</small>
                    <h2 class="fw-bold">
                        {{ $totalPeminjaman }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <small>Sedang Dipinjam</small>
                    <h2 class="fw-bold">
                        {{ $dipinjam }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <small>Dikembalikan</small>
                    <h2 class="fw-bold">
                        {{ $dikembalikan }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <small>Terlambat</small>
                    <h2 class="fw-bold">
                        {{ $terlambat }}
                    </h2>
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
                        <input type="date" name="tanggal" class="form-control auto-submit" value="{{ request('tanggal_pinjam') }}" 
                            onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-select auto-submit">
                            <option value="">Semua</option>
                            <option value="Dipinjam"
                                {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>
                                Dipinjam
                            </option>
                            <option value="Dikembalikan"
                                {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>
                                Dikembalikan
                            </option>
                            <option value="Terlambat"
                                {{ request('status') == 'Terlambat' ? 'selected' : '' }}>
                                Terlambat
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search"> Filter</i>
                        </button>

                        @if(request()->hasAny(['nama','tanggal','status']))
                            <a href="{{ route('laporan.peminjaman') }}"
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

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table modern-table align-middle text-center">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($peminjamans as $item)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>

                                <span class="kode-peminjaman">
                                    {{ $item->kode_peminjaman }}
                                </span>

                            </td>

                            <td>

                                <strong>
                                    {{ $item->anggota->nama ?? '-' }}
                                </strong>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($item->batas_kembali)->format('d M Y') }}

                            </td>

                            <td>

                                {{
                                    \Carbon\Carbon::parse($item->tanggal_pinjam)
                                    ->diffInDays($item->batas_kembali)
                                }}

                                Hari

                            </td>

                            <td>

                                @if($item->status == 'Dipinjam')

                                    <span class="badge bg-primary">
                                        Dipinjam
                                    </span>

                                @elseif($item->status == 'Dikembalikan')

                                    <span class="badge bg-success">
                                        Dikembalikan
                                    </span>

                                @else
                                    <span class="badge bg-danger"> Terlambat </span>

                                @endif
                            </td>
                            <td> {{ $item->keterangan ?? '-' }} </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-5">
                                Tidak ada data peminjaman
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
