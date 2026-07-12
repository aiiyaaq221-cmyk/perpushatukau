@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/laporan/pengunjung.css') }}">
@endsection

@section('content')

<!-- HEADER -->
<div class="header-card mb-4">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title"> 📋 Laporan Tamu</h2>
            <p class="page-subtitle"> Data kunjungan tamu Perpustakaan Hatukau </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('laporan.pengunjung.excel') }}" class="btn btn-success btn-modern-export"> 📊 Export Excel </a>
            <a href="{{ route('laporan.pengunjung.pdf') }}" class="btn btn-danger btn-modern-export"> 📄 Export PDF </a>
        </div>
    </div>
</div>

<!-- STATISTIK -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card primary">
            <h3>{{ $totalPengunjung }}</h3>
            <p>Total Kunjungan</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card success">
            <h3>{{ $hariIni }}</h3>
            <p>Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card warning">
            <h3>{{ $anggota }}</h3>
            <p>Anggota</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card danger">
            <h3>{{ $umum }}</h3>
            <p>Non Anggota</p>
        </div>
    </div>
</div>

<!-- filter -->
<div class="card border-0 filter-card mb-4">
    <div class="card-body">
        <form method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Nama Pengunjung</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pengunjung..." value="{{ request('search') }}">
                </div>

                <div class="col-md-3">
                    <label>Tanggal Kunjungan</label>
                    <input type="date"name="tanggal" class="form-control"
                        value="{{ request('tanggal') }}">
                </div>

                <div class="col-md-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="anggota"
                            {{ request('status')=='anggota'?'selected':'' }}>
                            Anggota
                        </option>
                        <option value="umum"
                            {{ request('status')=='umum'?'selected':'' }}>
                            Non Anggota
                        </option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->hasAny(['search','tanggal','status']))
                        <a href="{{ route('laporan.pengunjung') }}"
                            class="btn btn-secondary"> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>


<!-- tabel CARD -->
<div class="modern-card" id="tableData">
    <div class="card-header-custom">
        <h5 class="table-title">
            Data Pengunjung Perpustakaan
        </h5>
    </div>
    <div class="table-responsive">
        <table class="table modern-table align-middle text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pengunjung</th>
                    <th>Umur</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th>Alamat</th>
                    <th>Tujuan</th>
                    <th>Keterangan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengunjungs as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td> {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }} </td>
                    <td>
                        @if($item->anggota)
                            <strong>{{ $item->anggota->nama }}</strong>
                        @else
                            <strong>{{ $item->nama }}</strong>
                        @endif
                    </td>
                    <td>{{ $item->anggota?->umur ?? $item->umur ?? '-' }}</td>
                    <td>{{ $item->anggota?->jenis_kelamin ?? $item->jenis_kelamin ?? '-' }}</td>
                    <td>
                        @if($item->id_anggota)
                            <span class="badge bg-success">
                                Anggota
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Non Anggota
                            </span>
                        @endif
                    </td>
                    <td>{{ $item->anggota?->alamat ?? $item->alamat ?? '-' }}</td>
                    <td> {{ $item->tujuan ?? '-' }} </td>
                    <td> {{ $item->keterangan ?? '-' }} </td>
                </tr>

                @empty

                <tr>
                    <td colspan="10" class="text-center py-5">
                        <div class="empty-data">
                            <div style="font-size:60px;"> 📋 </div>
                            <h5>Belum Ada Data Tamu </h5>
                            <p> Data kunjungan pengunjung belum tersedia </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-4 py-3 d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">
            Menampilkan {{ $pengunjungs->firstItem() ?? 0 }}  -  {{ $pengunjungs->lastItem() ?? 0 }} dari {{ $pengunjungs->total() }} data
        </small>
        {{ $pengunjungs->fragment('tableData')->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection