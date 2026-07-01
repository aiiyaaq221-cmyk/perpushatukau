@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/master/kategori.css') }}">
@endsection

@section('content')
<div class="header-card">
    <div class="page-header">
        <div>
            <h2 class="page-title"> 📂 Kategori Buku </h2>
            <p class="page-subtitle"> Kelola kategori buku Perpustakaan Hatukau </p>
        </div>
        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTambahKategori"> + Tambah Kategori </button>
    </div>
</div>
<!-- Pencarian -->
<div class="modern-card mb-4">
    <form id="searchKategori" method="GET">
        <label class="modern-label mb-2">
            Cari Kategori
        </label>

        <div class="row g-2 align-items-center">
            <div class="col-lg-9">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" class="form-control modern-input search-input"
                        placeholder="Masukkan nama kategori...">
                </div>
            </div>

            <div class="col-lg-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search me-1"></i>
                        Cari
                    </button>

                    @if(request()->hasAny(['search']))
                        <a href="{{ route('master.kategori.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>                
            </div>
        </div>
    </form>
</div>

    <!-- TABEL -->
    <div class="modern-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1"> Data Kategori  </h5>
                <small class="text-muted">
                    Total : <strong> {{ $kategoris->count() }} </strong> Kategori
                </small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table modern-table align-middle">
                <thead>
                    <tr>
                        <th width="70"> No </th>
                        <th> Nama Kategori </th>
                        <th width="170"> Jumlah Buku </th>
                        <th width="180"> Aksi </th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kategoris as $kategori)

                    <tr>
                        <td class="text-center"> {{ $loop->iteration }} </td>
                        <td>
                            <div class="fw-semibold">
                                {{ $kategori->nama_kategori }}
                            </div>
                        </td>

                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                {{ $kategori->bukus_count }}
                                Buku
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <button
                                    class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editKategori{{ $kategori->id_kategori }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form
                                    id="delete-form-{{ $kategori->id_kategori }}"
                                    action="{{ route('master.kategori.destroy', $kategori->id_kategori) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $kategori->id_kategori }})">
                                        <i class="fas fa-trash"></i>                                        
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">
                            <div class="empty-data text-center py-5">

                                <div style="font-size:55px"> 📂  </div>
                                <h5 class="mt-3"> Data Kategori Kosong </h5>

                                <p class="text-muted mb-0">
                                    Belum ada kategori yang ditambahkan.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


@include('master.kategori.modal-tambah')
@include('master.kategori.modal-edit')

@endsection


@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function(){
        let timer;
        const form = document.getElementById("searchKategori");
        const input = document.getElementById("searchInput");
        input.addEventListener("keyup", function(){
            clearTimeout(timer);
            timer = setTimeout(function(){
                form.submit();
            },500);
        });
    });

function confirmDelete(id)
{
    Swal.fire({
        title:'Hapus Kategori?',
        text:'Data kategori yang dihapus tidak dapat dikembalikan.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#dc3545',
        cancelButtonColor:'#6c757d',
        confirmButtonText:'Ya, Hapus!',
        cancelButtonText:'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            document.getElementById('delete-form-'+id).submit();
        }
    });
}
</script>

@endsection