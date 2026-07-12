@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/laporan/buku.css') }}" rel="stylesheet">
@endsection

@section('content')

<!-- HEADER CARD -->
<div class="header-card mb-4">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title"> 📚 Laporan Buku </h2>
            <p class="page-subtitle"> Data koleksi buku Perpustakaan Hatukau </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('laporan.buku.excel') }}" class="btn btn-success btn-modern-export"> 📊 Export Excel </a>
            <a href="{{ route('laporan.buku.pdf') }}" class="btn btn-danger btn-modern-export"> 📄 Export PDF </a>
        </div>
    </div>
</div>

    <!-- Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card blue">
                <h3>{{ $totalBuku }}</h3>
                    <p>Total Buku</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card green">
                <h3>{{ $stokTersedia }}</h3>
                <p>Stok Tersedia</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card orange">
                <h3>{{ $totalDipinjam }}</h3>
                    <p>Sedang Dipinjam</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card red">
                <h3>{{ $totalKategori }}</h3>
                <p>Kategori Buku</p>
            </div>
        </div>
    </div>

    <!-- filter -->
    <div class="filter-card mb-4">
        <form method="GET" action="{{ route('laporan.buku') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label>Cari Buku</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Cari judul buku...">
                </div>

                <div class="col-md-3">
                    <label>Kategori</label>

                    <select
                        name="kategori"
                        class="form-select">

                        <option value="">Semua Kategori</option>

                        @foreach($kategoris as $kategori)
                            <option
                                value="{{ $kategori->id_kategori }}"
                                {{ request('kategori')==$kategori->id_kategori?'selected':'' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3">
                    <label>Tanggal Masuk</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i>
                    </button>
                    @if(request()->hasAny(['search','kategori','tanggal']))
                        <a href="{{ route('laporan.buku') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

<!-- TABLE -->
<div class="modern-card">
    <div class="table-header">
        <h5 class="table-title">Data Buku</h5>
        <p class="table-subtitle">
            Total : {{ $bukus->total() }} Buku
        </p>
    </div>

    <div class="table-responsive">
        <table class="table modern-table text-center">
            <thead>
            <tr>
                <th>No</th>
                <th>Cover</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Tanggal Masuk</th>
                <th>Sumber</th>
                <th>Jumlah</th>
                <th>Stok</th>
                <th>Keterangan</th>
            </tr>
        </thead>

        <tbody>
                @forelse($bukus as $buku)
                <tr>
                    <td class="text-center"> {{ $loop->iteration + ($bukus->firstItem()-1) }} </td>
                    <td>
                        @if($buku->cover)
                            <img
                                src="{{ asset('storage/'.$buku->cover) }}"
                                class="book-cover">
                        @else
                            <div class="text-muted small">
                                Tidak Ada Cover
                            </div>
                        @endif
                    </td>
                    <td class="judul-buku">
                        <strong>
                            {{ $buku->judul_buku }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $buku->kategori->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td> {{ $buku->pengarang }}  </td>
                    <td> {{ $buku->penerbit }} </td>
                    <td> {{ $buku->tahun_terbit }} </td>
                    <td> {{ \Carbon\Carbon::parse($buku->tanggal_masuk)->format('d M Y') }} </td>
                    <td> {{ $buku->sumber ?? '-' }} </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $buku->jumlah_buku }}
                        </span>
                    </td>

                    <td>
                        @if($buku->stok_tersedia > 0)
                            <span class="badge bg-success">
                                {{ $buku->stok_tersedia }}
                                Tersedia
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Habis
                            </span>
                        @endif
                    </td>
                    <td style="max-width:250px"> {{ $buku->keterangan ?? '-' }} </td>
                </tr>

                @empty

                <tr>
                    <td colspan="12" class="text-center py-5">
                        <div class="empty-data">
                            <div style="font-size:60px">
                                📚
                            </div>
                            <h5> Belum Ada Data Buku </h5>
                            <p>  Silakan tambahkan data buku terlebih dahulu </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>        
    <div class="pagination-wrapper">
        <div class="pagination-info"> Menampilkan  {{ $bukus->firstItem() ?? 0 }} - {{ $bukus->lastItem() ?? 0 }} dari {{ $bukus->total() }} data </div>
        {{ $bukus->links('pagination::bootstrap-5') }}
    </div>
    
</div>

@endsection
