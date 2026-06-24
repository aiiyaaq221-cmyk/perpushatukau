@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/laporan/pengunjung.css') }}">
@endsection

@section('content')

<!-- HEADER -->
<div class="page-header">

    <div>
        <h2 class="page-title">
            📋 Laporan Tamu
        </h2>

        <p class="page-subtitle">
            Data kunjungan tamu Perpustakaan Hatukau
        </p>
    </div>

    <div>
        <a href="{{ route('laporan.pengunjung.excel') }}"
        class="btn btn-export btn-excel me-2">
            📊 Export Excel
        </a>

        <a href="{{ route('laporan.pengunjung.pdf') }}"
        class="btn btn-export btn-pdf">
            📄 Export PDF
        </a>
    </div>
</div>

<!-- STATISTIK -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-blue">
            <h3>{{ $totalPengunjung }}</h3>
            <p>Total Kunjungan</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-green">
            <h3>{{ $hariIni }}</h3>
            <p>Hari Ini</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-orange">
            <h3>{{ $anggota }}</h3>
            <p>Anggota</p>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card stat-purple">
            <h3>{{ $umum }}</h3>
            <p>Non Anggota</p>
        </div>
    </div>
</div>

<!-- CARD -->
<div class="modern-card">

    <!-- FILTER -->
    <form method="GET" action="{{ route('laporan.pengunjung') }}">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control modern-input" placeholder="🔍 Cari nama pengunjung..." 
                    onkeyup="this.form.submit()">
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control modern-input" 
                    onkeyup="this.form.submit()">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select modern-input">
                    <option value=""> Semua Pengunjung </option>
                    <option value="anggota" {{ request('jenis') == 'anggota' ? 'selected' : '' }}> Anggota </option>
                    <option value="umum" {{ request('jenis') == 'umum' ? 'selected' : '' }}> Non Anggota </option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end gap-2">
                <button class="btn btn-primary flex-fill">
                    <i class="fas fa-search"> Filter</i>
                </button>

                @if(request()->hasAny(['search','tanggal','status']))
                    <a href="{{ route('laporan.pengunjung') }}"
                    class="btn btn-secondary">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>

    <!-- TABEL -->
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

    <!-- PAGINATION -->
    <!-- <div class="mt-4 d-flex justify-content-center">

        {{ $pengunjungs->links() }}

    </div> -->

</div>

@endsection