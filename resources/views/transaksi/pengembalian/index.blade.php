@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transaksi/pengembalian.css') }}">
@endsection

@section('content')

<div class="header-card">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title">📚 Data Pengembalian</h2>
            <p class="page-subtitle">
                Kelola riwayat pengembalian buku perpustakaan
            </p>
        </div>
    </div>
</div>

{{-- FILTER --}}
<div class="filter-card">

    <form method="GET" id="filterForm">

        <div class="row g-3 align-items-end">

            <div class="col-lg-4">

                <label class="form-label">
                    Cari
                </label>

                <input
                    type="text"
                    name="search"
                    id="searchInput"
                    value="{{ request('search') }}"
                    class="form-control modern-input"
                    placeholder="Kode peminjaman / Nama anggota">

            </div>

            <div class="col-lg-3">

                <label class="form-label">
                    Status
                </label>

                <select
                    name="status"
                    id="statusFilter"
                    class="form-select modern-input">

                    <option value="">
                        Semua Status
                    </option>

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

            <div class="col-lg-3">

                <label class="form-label">
                    Tanggal Kembali
                </label>

                <input
                    type="date"
                    name="tanggal"
                    id="tanggalFilter"
                    value="{{ request('tanggal') }}"
                    class="form-control modern-input">
            </div>

            <div class="col-lg-2">
                <div class="d-flex gap-2">
                    <button class="btn btn-filter flex-fill">
                        <i class="fas fa-search me-1"></i>                        
                    </button>

                    @if(request()->hasAny(['search','status','tanggal']))
                    <a
                        href="{{ route('transaksi.pengembalian.index') }}"
                        class="btn btn-secondary">
                        Reset
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>

</div>

{{-- CARD TABEL --}}
<div class="modern-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="table-title fw-bold mb-1">
                Data Pengembalian
            </h5>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table modern-table align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="150">Kode</th>
                    <th width="180">Anggota</th>
                    <th width="120">Pinjam</th>
                    <th width="140">Batas Kembali</th>
                    <th width="140">Tanggal Kembali</th>
                    <th width="120">Status</th>
                    <th width="90">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($pengembalians as $item)

                <tr>
                    <td class="text-center"> {{ $loop->iteration + ($pengembalians->firstItem()-1) }}  </td>
                    <td>
                        <div class="kode">
                            {{ $item->peminjaman->kode_peminjaman }}
                        </div>
                    </td>

                    <td>
                        <div class="nama-anggota">
                            {{ $item->peminjaman->anggota->nama }}
                        </div>
                    </td>
                    <td class="tanggal">  {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pinjam)->translatedFormat('d M Y') }} </td>
                    <td class="tanggal"> {{ \Carbon\Carbon::parse($item->peminjaman->batas_kembali)->translatedFormat('d M Y') }} </td>

                    <td class="tanggal">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') }}
                    </td>

                    <td class="text-center">

                        @if($item->status_pengembalian=='Tepat Waktu')

                            <span class="badge bg-success px-3 py-2">

                                Tepat Waktu

                            </span>

                        @else

                            <span class="badge bg-danger px-3 py-2">

                                Terlambat

                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <button
                            class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detail{{ $item->id_pengembalian }}">

                            <i class="fas fa-eye"></i>

                        </button>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8">

                        <div class="empty-data text-center py-5">

                            <div style="font-size:60px">

                                📚

                            </div>

                            <h5 class="mt-3">

                                Data Pengembalian Kosong

                            </h5>

                            <p class="text-muted mb-0">

                                Belum ada riwayat pengembalian buku.

                            </p>

                        </div>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">

        <small class="text-muted">

            Menampilkan

            {{ $pengembalians->firstItem() ?? 0 }}

            -

            {{ $pengembalians->lastItem() ?? 0 }}

            dari

            {{ $pengembalians->total() }}

            data

        </small>

        {{ $pengembalians->links('pagination::bootstrap-5') }}

    </div>

</div>

@include('transaksi.pengembalian.modal-detail')

<script>

document.addEventListener('DOMContentLoaded',function(){

    const form=document.getElementById('filterForm');
    const search=document.getElementById('searchInput');
    const status=document.getElementById('statusFilter');
    const tanggal=document.getElementById('tanggalFilter');

    let timer;

    search.addEventListener('keyup',function(){

        clearTimeout(timer);

        timer=setTimeout(function(){

            form.submit();

        },500);

    });

    status.addEventListener('change',function(){

        form.submit();

    });

    tanggal.addEventListener('change',function(){

        form.submit();

    });

});

</script>

@endsection