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
                    <input type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari judul dan kode buku"
                        value="{{ request('search') }}">
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
    <div class="modern-card" id="tableData">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div>
                <h5 class="fw-bold mb-1"> Data Buku</h5>
                <small class="text-muted">
                    Total :
                    <strong>{{ $jumlahBuku }}</strong> Buku
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
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bukus as $buku)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration + ($bukus->firstItem()-1) }} </td>
                        <td class="text-center">
                            @if($buku->cover)
                                <img src="{{ asset('storage/' . $buku->cover) }}" class="book-cover">
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
                        <td class="text-center">{{ $buku->jumlah_buku }}</td>
                        <td class="text-center">
                            @if($buku->jumlah_buku > 5)
                                <span class="badge bg-success">
                                    Tersedia
                                </span>
                            @elseif($buku->jumlah_buku > 0)
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
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailBukuModal" 
                                    onclick="setDetailBuku({{ $buku }})"> <i class="fas fa-eye"></i>  </button>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editBuku{{ $buku->id_buku }}"> <i class="fas fa-edit"></i> </button>
                                
                                <form action="{{ route('master.buku.destroy',$buku->id_buku) }}"
                                    method="POST"
                                    class="formDelete d-inline">

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
            <hr>

@include('master.buku.modal-detail')
@include('master.buku.edit')
        </div>
        
        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">
            Menampilkan {{ $bukus->firstItem()??0 }} - {{ $bukus->lastItem()??0 }} dari {{ $bukus->total() }} data
            </small>
            {{ $bukus->fragment('tableData')->links('pagination::bootstrap-5') }}
        </div>
    </div>


@include('master.buku.modal-tambah') 


@push('scripts')

<script>

document.querySelectorAll('.formDelete').forEach(function(form){
    form.addEventListener('submit',function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Hapus Buku?',
            text: 'Data buku yang dihapus tidak dapat dikembalikan.',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Ya, Hapus',

            cancelButtonText: 'Batal',

            reverseButtons:true

        }).then((result)=>{

            if(result.isConfirmed){

                form.submit();

            }

        });

    });

});

</script>

@endpush

@endsection