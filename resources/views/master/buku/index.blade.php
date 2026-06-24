@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/master/buku.css') }}">
@endsection

@section('content')
<!-- HEADER CARD -->
<div class="header-card">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title"> 📚 Data Buku </h2>
            <p class="page-subtitle"> Kelola koleksi buku Perpustakaan Hatukau </p>
        </div>
        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTambahBuku"> + Tambah Buku </button>
    </div>
</div>


<!-- Statistik -->
<div class="row mb-4">

    <div class="col-md-4">
        <div class="stat-card blue">
            <h3>{{ $totalBuku }}</h3>
            <p>Total Buku</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card green">
            <h3>{{ $totalKategori }}</h3>
            <p>Kategori Buku</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card orange">
            <h3>{{ $totalStok }}</h3>
            <p>Stok Tersedia</p>
        </div>
    </div>

</div>


<!-- Tabel Buku -->
<div class="modern-card">
    <form method="GET" action="{{ route('master.buku.index') }}">
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <input type="text" name="search" id="searchInput" class="form-control modern-input" placeholder="Cari judul buku..."
                    value="{{ request('search') }}"
                    onkeyup="this.form.submit()">
            </div>

            <div class="col-md-4">
                <select name="kategori" class="form-select modern-input"
                    onchange="this.form.submit()">

                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option
                            value="{{ $kategori->id_kategori }}"
                            {{ request('kategori') == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                @if(request()->has('search') || request()->has('kategori'))
                    <a href="{{ route('master.buku.index') }}"
                    class="btn btn-secondary w-100">
                        Reset
                    </a>
                @endif
            </div>
        </div>
    </form>


    <div class="table-responsive">
        <table class="table modern-table align-middle">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Informasi Buku</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bukus as $buku)

                <tr>
                    <td class="text-center"> {{ $loop->iteration }} </td>
                    <td class="text-center">
                        @if($buku->cover)
                            <img
                                src="{{ asset('storage/'.$buku->cover) }}"
                                class="book-cover">
                        @else
                            <span class="text-muted">
                                Tidak ada cover
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="fw-bold"> {{ $buku->judul_buku }} </div>

                        @if($buku->kode_buku)

                            <small class="text-primary">
                                {{ $buku->kode_buku }}
                            </small>
                        @else
                            <small class="text-danger">
                                Kode tidak tersedia
                            </small>
                        @endif

                        <br>
                        <small>
                            {{ $buku->pengarang }}
                        </small>
                    </td>

                    <td class="text-center">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </td>

                    <td class="text-center">
                        {{ $buku->stok_tersedia }}
                    </td>

                    <td class="text-center">

                        @if($buku->stok_tersedia > 5)

                            <span class="badge bg-success">
                                Tersedia
                            </span>

                        @elseif($buku->stok_tersedia > 0)

                            <span class="badge bg-warning">
                                Hampir Habis
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Habis
                            </span>

                        @endif

                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailBukuModal" onclick="setDetailBuku({{ $buku }})"> Detail </button>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBuku{{ $buku->id_buku }}"> Edit </button>
                            <button class="btn btn-danger btn-sm"> Hapus </button>
                        </div>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="7" class="text-center py-4">
                        <div class="empty-data">
                            <div style="font-size:50px"> 📚 </div>
                            <h5> Data Buku Kosong </h5>
                            <p> Belum ada buku yang ditambahkan  </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('master.buku.modal-tambah')    
@include('master.buku.modal-edit')
@include('master.buku.modal-detail')

@endsection