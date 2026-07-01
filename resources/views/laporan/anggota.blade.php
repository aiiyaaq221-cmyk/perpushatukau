@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/laporan/anggota.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid pt-1 pb-4">
    <div class="header-card mb-4">
        <div class="page-header">
            <div class="page-info">
                <h2 class="page-title"> 📚 Laporan Anggota </h2>
                <p class="page-subtitle"> Data Anggota Perpustakaan Hatukau </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('laporan.anggota.excel') }}" class="btn btn-success btn-modern-export"> 📊 Export Excel </a>
                <a href="{{ route('laporan.anggota.pdf') }}" class="btn btn-danger btn-modern-export"> 📄 Export PDF </a>
            </div>
        </div>
    </div>
    
    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h6>Total Anggota</h6>
                    <h2>{{ $totalAnggota }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <h6>Anggota Aktif</h6>
                    <h2>{{ $anggotaAktif }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <h6>Tidak Aktif</h6>
                    <h2>{{ $anggotaNonAktif }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <h6>Daftar Bulan Ini</h6>
                    <h2>{{ $anggotaBaru }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
<div class="card border-0 shadow-sm mb-4 filter-card">
    <div class="card-body">
        <form id="filterForm" method="GET">
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fw-semibold"> Cari </label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control modern-input" placeholder="🔍 Cari nama atau alamat anggota..." 
                        onkeyup="this.form.submit()">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold"> Status Anggota </label>
                    <select name="status" id="statusFilter" class="form-select modern-input" onkeyup="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="Aktif"
                            {{ request('status') == 'Aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>

                        <option value="Tidak Aktif"
                            {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>
                            Tidak Aktif
                        </option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search"> </i> Filter
                    </button>

                    @if(request()->hasAny(['nama','tanggal','status']))
                        <a href="{{ route('laporan.anggota') }}"
                        class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

    <!-- Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover modern-table align-middle text-center">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Umur</th>
                            <th>No Telp</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($anggotas as $anggota)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td> <strong>{{ $anggota->nama }}</strong></td>
                            <td> {{ $anggota->jenis_kelamin }}</td>
                            <td> {{ $anggota->umur }}  </td>
                            <td> {{ $anggota->no_telp ?? '-' }}  </td>
                            <td> {{ $anggota->email ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d M Y') }}</td>
                            <td>
                                @if($anggota->status == 'Aktif')
                                    <span class="badge bg-success">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td colspan="9" class="text-center py-5">
                                Tidak ada data
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