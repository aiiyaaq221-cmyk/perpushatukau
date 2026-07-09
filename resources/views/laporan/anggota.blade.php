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
            <div class="card stat-card primary">
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
            <div class="card stat-card warning">
                <div class="card-body">
                    <h6>Tidak Aktif</h6>
                    <h2>{{ $anggotaNonAktif }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <h6>Daftar Bulan Ini</h6>
                    <h2>{{ $anggotaBaru }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('laporan.peminjaman') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <label>Nama Anggota</label>
                    <input type="text" name="nama" class="form-control" placeholder="Cari nama anggota..." value="{{ request('nama') }}" onkeyup="this.form.submit()">
                </div>
                <div class="col-md-3">
                    <label>Tanggal Pinjam</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}" onchange="this.form.submit()">
                </div>
                <div class="col-md-2">
                    <label>Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua</option>
                        <option value="Dipinjam" {{ request('status')=='Dipinjam'?'selected':'' }}>Dipinjam</option>
                        <option value="Dikembalikan" {{ request('status')=='Dikembalikan'?'selected':'' }}>Dikembalikan</option>
                        <option value="Terlambat" {{ request('status')=='Terlambat'?'selected':'' }}>Terlambat</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-fill"><i class="fas fa-search me-1"></i>Cari</button>
                    @if(request()->hasAny(['nama','tanggal','status']))
                    <a href="{{ route('laporan.peminjaman') }}" class="btn btn-secondary">Reset</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="modern-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Data Anggota</h5>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table modern-table align-middle">
                <thead>
                    <thead>
                        <tr>
                            <th >No</th>
                            <th >Nama</th>
                            <th  >Jenis Kelamin</th>
                            <th  >Umur</th>
                            <th  >No Telp</th>
                            <th  >Email</th>
                            <th  >Tgl Daftar</th>
                            <th  >Status</th>
                        </tr>
                    </thead>
                </thead>
                <tbody>
                    @forelse($anggotas as $anggota)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration + ($anggotas->firstItem()-1) }} </td>
                        <td>
                            <div class="fw-semibold nama-anggota">
                                {{ $anggota->nama }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($anggota->jenis_kelamin == 'L')
                                Laki-laki
                            @elseif($anggota->jenis_kelamin == 'P')
                                Perempuan
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center"> {{ $anggota->umur }} </td>
                        <td> {{ $anggota->no_telp ?? '-' }} </td>
                        <td> {{ $anggota->email ?? '-' }} </td>
                        <td class="text-center"> {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->translatedFormat('d M Y') }} </td>
                        <td class="text-center">
                            @if($anggota->status=='Aktif')
                                <span class="badge bg-success px-3 py-2"> Aktif </span>
                            @else
                                <span class="badge bg-danger px-3 py-2"> Non Aktif  </span>
                            @endif
                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="8">
                            <div class="empty-data text-center py-5">
                                <div style="font-size:60px"> 👥 </div>
                                <h5 class="mt-3"> Data Anggota Kosong </h5>
                                <p class="text-muted mb-0"> Belum ada data anggota. </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted"> Menampilkan {{ $anggotas->firstItem() ?? 0 }} - {{ $anggotas->lastItem() ?? 0 }} dari {{ $anggotas->total() }} data </small>
            {{ $anggotas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection