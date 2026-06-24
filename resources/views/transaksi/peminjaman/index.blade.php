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
    showConfirmButton: false
});
</script>

@endif

@if(session('error'))

<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{ session("error") }}'
});
</script>

@endif


@section('content')
<div class="header-card">
    <div class="page-header">
        <div class="page-info">
            <h2 class="page-title"> 📖 Data Peminjaman </h2>
            <p class="page-subtitle"> Kelola transaksi peminjaman buku perpustakaan </p>
        </div>
        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjaman"> + Tambah Peminjaman </button>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <h3>{{ $totalPeminjaman }}</h3>
            <p>Total Peminjaman</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card green">
            <h3>{{ $dipinjam }}</h3>
            <p>Sedang Dipinjam</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card orange">
            <h3>{{ $dikembalikan }}</h3>
            <p>Dikembalikan</p>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="modern-card">
    <div class="table-responsive">
        <table class="table modern-table align-middle ">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Tanggal Kembali</th>
                    <th>Total Buku</th>
                    <th>Status</th>
                    <th width="220">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjamans as $item)
                <tr>

                    <td class="text-center"> {{ $loop->iteration }} </td>
                    <td>
                        <span class="fw-bold text-primary">
                            {{ $item->kode_peminjaman }}
                        </span>
                    </td>
                    <td> {{ $item->anggota->nama ?? '-' }}  </td>
                    <td> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }} </td>
                    <td>  {{ \Carbon\Carbon::parse($item->batas_kembali)->format('d-m-Y') }} </td>
                    <td>
                        @if($item->tanggal_kembali)
                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>

                    <td class="text-center"> {{ $item->details->sum('jumlah') }} Buku </td>
                    <td class="text-center">
                        @if($item->status == 'Dipinjam')
                            <span class="badge bg-primary"> Dipinjam </span>

                        @elseif($item->status == 'Dikembalikan')
                            <span class="badge bg-success"> Dikembalikan </span>

                        @elseif($item->status == 'Terlambat')
                            <span class="badge bg-danger"> Terlambat  </span>
                        @endif
                    </td>

                    <td class="text-center">
                        {{-- DETAIL --}}
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id_peminjaman }}"> 
                            Detail 
                        </button>
                        {{-- EDIT --}}
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit{{ $item->id_peminjaman }}">
                            Edit 
                        </button>

                        {{-- KEMBALIKAN --}}
                        @if($item->tanggal_kembali == null)
                            <form action="{{ route('transaksi.peminjaman.kembali', $item->id_peminjaman) }}"
                                method="POST" class="d-inline form-kembalikan">

                                @csrf

                                <button type="submit" class="btn btn-success btn-sm">
                                    Kembalikan
                                </button>
                            </form>
                        @endif

                        {{-- HAPUS --}}
                        <form
                            action="{{ route('transaksi.peminjaman.destroy', $item->id_peminjaman) }}"
                            method="POST"
                            class="d-inline form-delete">

                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-delete">

                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty

                <tr>
                    <td colspan="9" class="text-center py-4">
                        Tidak ada data peminjaman
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>


<!-- kembalikan -->
<script>

document.querySelectorAll('.btn-kembalikan').forEach(button => {
    button.addEventListener('click', function(){
        let form = this.closest('.form-kembalikan');
        Swal.fire({
            title: 'Kembalikan Buku?',
            text: 'Stok buku akan dikembalikan ke perpustakaan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Kembalikan',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if(result.isConfirmed){

                form.submit();
            }
        });
    });
});

</script>

<!-- hapus -->
<script>

document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function(){
            let form = this.closest('.form-delete');
            Swal.fire({
                title: 'Hapus Data?',
                text: 'Data peminjaman akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {

                if(result.isConfirmed){

                    form.submit();
                }
            });
        });
    });
});
</script>


@include('transaksi.peminjaman.modal-tambah')

@foreach($peminjamans as $item)
    @include('transaksi.peminjaman.modal-detail')
    @include('transaksi.peminjaman.modal-edit')
@endforeach

@endsection