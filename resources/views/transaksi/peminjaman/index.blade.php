@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/transaksi/peminjaman.css') }}">
<link rel="stylesheet" href="{{ asset('css/transaksi/peminjaman-modal.css') }}">
@endsection


@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false,
    toast: true,
    position: 'top-end'
});
</script>
@endif


@if(session('error'))
<script>
Swal.fire({
    icon:'error',
    title:'Oops...',
    text:'{{ session("error") }}'
});
</script>
@endif


@section('content')

<!-- ==========================
HEADER
=========================== -->
<div class="header-card">
    <div class="page-header">
        <div class="page-info">

            <h2 class="page-title">
                📖 Data Peminjaman
            </h2>

            <p class="page-subtitle">
                Kelola transaksi peminjaman buku Perpustakaan Hatukau
            </p>

        </div>

        <button
            class="btn btn-primary btn-modern"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahPeminjaman">

            + Tambah Peminjaman

        </button>

    </div>

</div>



<!-- ==========================
FILTER
=========================== -->
<div class="modern-card mb-4">
    <form
        id="searchForm"
        method="GET">

        <div class="row g-3 align-items-end">

            <!-- Search -->
            <div class="col-lg-5">

                <label class="modern-label">

                    Cari Transaksi

                </label>

                <input
                    type="text"
                    id="searchInput"
                    name="search"
                    class="form-control modern-input"
                    value="{{ request('search') }}"
                    placeholder="Kode peminjaman atau nama anggota">

            </div>


            <!-- Status -->
            <div class="col-lg-3">

                <label class="modern-label">

                    Status

                </label>

                <select
                    name="status"
                    class="form-select modern-input"
                    onchange="this.form.submit()">

                    <option value="">
                        Semua Status
                    </option>

                    <option
                        value="Dipinjam"
                        {{ request('status')=='Dipinjam' ? 'selected' : '' }}>
                        Dipinjam
                    </option>

                    <option
                        value="Dikembalikan"
                        {{ request('status')=='Dikembalikan' ? 'selected' : '' }}>
                        Dikembalikan
                    </option>

                    <option
                        value="Terlambat"
                        {{ request('status')=='Terlambat' ? 'selected' : '' }}>
                        Terlambat
                    </option>

                </select>

            </div>



            <!-- Tanggal -->
            <div class="col-lg-2">
                <label class="modern-label"> Tanggal </label>
                <input type="date" name="tanggal_pinjam" value="{{ request('tanggal_pinjam') }}" class="form-control modern-input"
                    onchange="this.form.submit()">
            </div>

            <div class="col-lg-2">
                <div class="d-flex gap-2 h-100">
                    <button type="submit" class="btn btn-primary btn-filter-action flex-fill">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>

                    @if(request()->hasAny(['search','status','tanggal_pinjam']))
                    <a href="{{ route('transaksi.peminjaman.index') }}" class="btn btn-secondary btn-filter-action">
                        Reset
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ==========================
TABLE CARD
=========================== -->

<div class="modern-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="table-title fw-bold mb-1">
                Data Peminjaman
            </h5>
        </div>
    </div>
    <div class="table-responsive table-scroll">
        <table class="table modern-table align-middle">
            <thead>
                <tr>
                    <th style="min-width:50px">No</th>
                    <th style="min-width:100px">Kode</th>
                    <th style="min-width:130px">Anggota</th>
                    <th style="min-width:100px">Pinjam</th>
                    <th style="min-width:100px">Batas Kembali</th>
                    <th style="min-width:80px">Tanggal Kembali</th>
                    <th style="min-width:100px">Buku</th>
                    <th style="min-width:110px">Status</th>
                    <th style="min-width:140px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $item)
                <tr>
                    <td class="text-center">
                        {{ $loop->iteration + ($peminjamans->firstItem()-1) }}
                    </td>
                    <td>
                        <div class="fw-bold text-primary">
                            {{ $item->kode_peminjaman }}
                        </div>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            {{ $item->anggota->nama ?? '-' }}
                        </div>
                    </td>
                    <td> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }} </td>
                    <td> {{ \Carbon\Carbon::parse($item->batas_kembali)->translatedFormat('d M Y') }} </td> 
                    <td>
                        @if($item->tanggal_kembali)
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->translatedFormat('d M Y') }}
                        @else
                            <span class="text-muted">
                                -
                            </span>
                        @endif

                    </td>
                    <td>
                    <div class="book-items">
                            {{-- 2 buku pertama --}}
                            @foreach($item->details->take(2) as $detail)
                                <div class="book-item">
                                    <i class="fas fa-book"></i>
                                    <span>{{ $detail->buku->judul_buku }}</span>
                                    @if($detail->jumlah > 1)
                                        <small>×{{ $detail->jumlah }}</small>
                                    @endif
                                </div>
                            @endforeach

                            {{-- Buku sisanya --}}
                            @if($item->details->count() > 2)
                                <div
                                    id="moreBooks{{ $item->id_peminjaman }}"
                                    class="more-books"
                                    style="display:none;">

                                    @foreach($item->details->skip(2) as $detail)

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
                                    data-target="moreBooks{{ $item->id_peminjaman }}"
                                    data-count="{{ $item->details->count()-2 }}">
                                    +{{ $item->details->count()-2 }} lainnya
                                </small>
                            @endif
                        </div>
                    </td>
                    <td class="text-center">
                        @if($item->status=='Dipinjam')
                            <span class="badge bg-primary">
                                Dipinjam
                            </span>

                        @elseif($item->status=='Dikembalikan')
                            <span class="badge bg-success">
                                Dikembalikan
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Terlambat
                            </span>
                        @endif
                    </td>

                    <td class="text-center">
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id_peminjaman }}">
                                <i class="fas fa-eye"></i>
                                </button>

                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id_peminjaman }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('transaksi.peminjaman.destroy',$item->id_peminjaman) }}" method="POST" class="form-delete m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                    <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                                @if(!$item->tanggal_kembali)
                                <form action="{{ route('transaksi.peminjaman.kembali',$item->id_peminjaman) }}" method="POST" class="form-kembalikan m-0">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm btn-kembalikan">
                                    Kembalikan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>

                @empty

                <tr>
                    <td colspan="9">
                        <div class="empty-data text-center py-5">
                            <div style="font-size:60px">
                                📖
                            </div>
                            <h5 class="mt-3">
                                Data Peminjaman Kosong
                            </h5>
                            <p class="text-muted mb-0">
                                Belum ada transaksi peminjaman.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <!-- Pagination -->

    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted"> Menampilkan {{ $peminjamans->firstItem() ?? 0 }} - {{ $peminjamans->lastItem() ?? 0 }} dari {{ $peminjamans->total() }}
            data
        </small>
        {{ $peminjamans->links('pagination::bootstrap-5') }}
    </div>
</div>



@include('transaksi.peminjaman.modal-tambah')
@foreach($peminjamans as $item)
    @include('transaksi.peminjaman.modal-detail')
    @include('transaksi.peminjaman.modal-edit')
@endforeach


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ==========================================
       AUTO SEARCH (500ms)
    ========================================== */

    let timer;
    const searchInput = document.getElementById('searchInput');
    const form = document.getElementById('searchForm');

    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            clearTimeout(timer);
            timer = setTimeout(function () {
                form.submit();
            }, 500);
        });
    }


    /* ==========================================
       FILTER OTOMATIS
    ========================================== */

    document.querySelectorAll(
        'select[name="status"], input[name="tanggal_pinjam"]'
    ).forEach(function (item) {

        item.addEventListener('change', function () {

            form.submit();

        });

    });


    /* ==========================================
       KONFIRMASI KEMBALIKAN
    ========================================== */

    document.querySelectorAll('.btn-kembalikan').forEach(function (button) {
        button.addEventListener('click', function () {
            let form = this.closest('.form-kembalikan');
            Swal.fire({
                title: 'Kembalikan Buku?',
                html:
                    '<div style="font-size:15px">' +
                    'Buku akan dikembalikan ke stok perpustakaan.' +
                    '</div>',
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Kembalikan',
                cancelButtonText: 'Batal',
                borderRadius: '15px'

            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    /* ==========================================
       KONFIRMASI HAPUS
    ========================================== */

    document.querySelectorAll('.btn-delete').forEach(function (button) {
        button.addEventListener('click', function () {
            let form = this.closest('.form-delete');
            Swal.fire({
                title: 'Hapus Data?',
                html:
                    '<div style="font-size:15px">' +
                    'Data peminjaman akan dihapus permanen.' +
                    '<br><br>' +
                    '<b>Tindakan ini tidak dapat dibatalkan.</b>' +
                    '</div>',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                borderRadius: '15px'

            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection