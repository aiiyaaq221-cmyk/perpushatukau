@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/pengunjung/pengunjung.css') }}">
@endsection

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        showConfirmButton: false,
        timer: 2000,
        toast: true,
        position: 'top-end'
    });

});
</script>
@endif

@section('content')
<div class="header-card">
    <div class="page-header">
        <div class="page-info">
             <h2 class="page-title">  Data Pengunjung </h2>
        <p class="page-subtitle"> Kelola data pengunjung Perpustakaan Hatukau </p>
    </div>
    <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTambahPengunjung"> + Tambah Pengunjung </button>
    </div>
</div>

    <!-- FILTER -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('pengunjung.index') }}">
                <div class="row g-3">
                    <div class="col-lg-5">
                        <label>Nama Pengunjung</label>
                        <input type="text" name="nama" class="form-control" placeholder="Cari nama..." value="{{ request('nama') }}">
                    </div>

                    <div class="col-lg-3">
                        <label>Tanggal Kunjungan</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-lg-2">
                        <label>Jenis Pengunjung</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="Anggota" {{ request('status')=='Anggota'?'selected':'' }}>Anggota</option>
                            <option value="Umum" {{ request('status')=='Umum'?'selected':'' }}>Non Anggota</option>
                        </select>
                    </div>

                    <div class="col-lg-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>
                        </button>
                        @if(request()->hasAny(['nama','tanggal','status']))
                        <a href="{{ route('pengunjung.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>



<!-- Tabel -->
 <div class="modern-card">
    <div class="table-header">
        <h5 class="table-title">Data Pengunjung</h5>
    </div>

    <div class="table-responsive">
        <table class="table modern-table align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th width="120">Tanggal</th>
                    <th width="180">Nama</th>
                    <th width="90">JK</th>
                    <th width="140">Status</th>
                    <th>Tujuan</th>
                   <th width="170">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengunjungs as $pengunjung)
                <tr>
                    <td class="text-center"> {{ $loop->iteration + ($pengunjungs->firstItem()-1) }} </td>
                    <td>
                        <div class="tanggal"> {{ \Carbon\Carbon::parse($pengunjung->tanggal_kunjungan)->translatedFormat('d M Y') }} </div>
                        <small class="text-muted"> {{ \Carbon\Carbon::parse($pengunjung->tanggal_kunjungan)->format('H:i') }} WIT </small>
                    </td>
                    <td>
                        <div class="nama-pengunjung"> {{ $pengunjung->nama }} </div>
                        @if($pengunjung->jenis_pengunjung=='anggota')
                            <span class="badge bg-primary mt-1">
                                Anggota
                            </span>
                        @endif
                    </td>
                    <td class="text-center"> {{ $pengunjung->jenis_kelamin }} </td>
                    <td class="text-center">
                        @if($pengunjung->jenis_pengunjung=='anggota')
                            <span class="badge bg-success">
                                {{ $pengunjung->anggota->status ?? 'Aktif' }}
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                {{ $pengunjung->status_pengunjung }}
                            </span>
                        @endif
                    </td>
                    <td> {{ $pengunjung->tujuan }} </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailPengunjung{{ $pengunjung->id_tamu }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editPengunjung{{ $pengunjung->id_tamu }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <form action="{{ route('pengunjung.destroy',$pengunjung->id_tamu) }}"
                                method="POST"
                                class="form-delete m-0">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    class="btn btn-danger btn-sm">

                                    <i class="fas fa-trash"></i>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7">
                        <div class="empty-data text-center py-5">
                            <div style="font-size:60px"> 👥 </div>
                            <h5 class="mt-3"> Data Pengunjung Kosong  </h5>
                            <p class="text-muted mb-0"> Belum ada data pengunjung. </p>
                        </div>
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted"> Menampilkan {{ $pengunjungs->firstItem() ?? 0 }} - {{ $pengunjungs->lastItem() ?? 0 }} dari {{ $pengunjungs->total() }} data </small>
            {{ $pengunjungs->links('pagination::bootstrap-5') }}
        </div>
        </div>
    </div>
</div>

@if(session('success'))

<script>

document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'success',
        title:'Berhasil',

        text:'{{ session("success") }}',

        confirmButtonColor:'#3085d6',

        allowOutsideClick:false,

        allowEscapeKey:true

    });

});

</script>

@endif



@if(session('error'))

<script>

document.addEventListener('DOMContentLoaded',function(){

    Swal.fire({

        icon:'error',

        title:'Gagal!',

        text:'{{ session("error") }}',

        confirmButtonColor:'#d33',

        allowOutsideClick:false,

        allowEscapeKey:true

    });

});

</script>

@endif


<script>
document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".form-delete").forEach(form => {

        form.addEventListener("submit", function(e){

            e.preventDefault();

            Swal.fire({
                title: "Hapus Data?",
                text: "Data pengunjung yang dihapus tidak dapat dikembalikan.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                cancelButtonColor: "#6c757d",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }).then((result)=>{

                if(result.isConfirmed){
                    form.submit();
                }

            });

        });

    });

});
</script>

@include('pengunjung.modal-tambah')
@include('pengunjung.modal-edit')
@include('pengunjung.modal-detail')

@endsection