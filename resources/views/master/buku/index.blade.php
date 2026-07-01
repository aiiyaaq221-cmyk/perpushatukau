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

<!-- TOOLBAR -->
<div class="modern-card mb-4">
    <form id="filterForm" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label class="modern-label">Cari Buku</label>
                <input type="text" id="searchInput" name="search" value="{{ request('search') }}" class="form-control modern-input"
                    placeholder="Judul, kode buku, pengarang..." 
                    onkeyup="this.form.submit()">
            </div>

            <div class="col-lg-3">
                <label class="modern-label"> Kategori </label>
                <select id="kategoriFilter" name="kategori" class="form-select modern-input">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option
                            value="{{ $kategori->id_kategori }}"
                            {{ request('kategori')==$kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="col-lg-2">
                <label class="modern-label"> Status </label>
                <select id="statusFilter" name="status" class="form-select modern-input">
                    <option value="">Semua</option>
                    <option value="tersedia"
                        {{ request('status')=='tersedia' ? 'selected' : '' }}>
                        Tersedia
                    </option>

                    <option value="hampir"
                        {{ request('status')=='hampir' ? 'selected' : '' }}>
                        Hampir Habis
                    </option>

                    <option value="habis"
                        {{ request('status')=='habis' ? 'selected' : '' }}>
                        Habis
                    </option>
                </select>
            </div>

            <!-- Tombol -->
            <div class="col-lg-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>

                    @if(request()->hasAny(['search','kategori','tanggal']))
                        <a href="{{ route('master.buku.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>                
            </div>
        </div>
    </form>
</div>

<!-- Tabel Buku -->
<div class="modern-card">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div>
            <h5 class="fw-bold mb-1">
                Data Buku
            </h5>
            <small class="text-muted">
                Total :
                <strong>{{ $bukus->count() }}</strong>
                Buku
            </small>
        </div>
    </div>

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
                    <td class="text-center">{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                    <td class="text-center">{{ $buku->stok_tersedia }}</td>
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

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function(){
        const form = document.getElementById("filterForm");
        const search = document.getElementById("searchInput");
        const kategori = document.getElementById("kategoriFilter");
        const status = document.getElementById("statusFilter");
        let typingTimer;

        // Auto search setelah berhenti mengetik 500 ms
        search.addEventListener("keyup", function(){
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function(){
                form.submit();
            }, 500);
        });

        // Filter kategori
        kategori.addEventListener("change", function(){
            form.submit();
        });

        // Filter status
        status.addEventListener("change", function(){
            form.submit();
        });
    });
</script>

@endsection

@include('master.buku.modal-tambah')    
@include('master.buku.edit')
@include('master.buku.modal-detail')

@endsection