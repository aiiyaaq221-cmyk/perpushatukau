@extends('layouts.app')

@section('styles')
<link rel="stylesheet"
      href="{{ asset('css/master/anggota.css') }}">
@endsection


@if(session('success'))
<script>
Swal.fire({
    icon:'success',
    title:'Berhasil',
    text:'{{ session('success') }}',
    toast:true,
    timer:2000,
    position:'top-end',
    showConfirmButton:false
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon:'error',
    title:'Data Duplikat',
    text:'{{ $errors->first() }}',
    confirmButtonColor:'#dc3545'
});
</script>
@endif


@section('content')

<!-- HEADER -->
<div class="header-card">
    <div class="page-header">
        <div>
            <h2 class="page-title">
                👤 Data Anggota
            </h2>
            <p class="page-subtitle">
                Kelola data anggota Perpustakaan Hatukau
            </p>
        </div>

        <button
            class="btn btn-primary btn-modern"
            data-bs-toggle="modal"
            data-bs-target="#modalTambahAnggota">
            + Tambah Anggota
        </button>
    </div>
</div>


<!-- FILTER -->
<div class="modern-card mb-4">
    <form id="searchForm" method="GET">
        <div class="row g-3 align-items-end">
            <div class="col-lg-6">
                <label class="modern-label"> Cari Anggota </label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control modern-input" placeholder="Nama anggota / nomor anggota">
            </div>

            <div class="col-lg-3">
                <label class="modern-label">  Status </label>
                <select id="statusFilter" name="status" class="form-select modern-input">
                    <option value=""> Semua Status </option>
                    <option
                        value="Aktif"
                        {{ request('status')=='Aktif'?'selected':'' }}>
                        Aktif
                    </option>

                    <option
                        value="Tidak Aktif"
                        {{ request('status')=='Tidak Aktif'?'selected':'' }}>
                        Tidak Aktif
                    </option>
                </select>
            </div>

            <div class="col-lg-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary flex-fill">
                        <i class="fas fa-search me-1"></i> Cari
                    </button>

                    @if(request()->hasAny(['search','status']))
                        <a href="{{ route('master.anggota.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    @endif
                </div>                
            </div>
        </div>
    </form>
</div>

<!-- TABLE -->
<div class="modern-card" id="tableData">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="fw-bold mb-1"> Data Anggota  </h5>
            <small class="text-muted"> Total :
                <strong> {{ $anggotas->count() }} </strong>
                anggota
            </small>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table modern-table align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Anggota</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur</th> 
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th width="180"> Aksi </th>
                </tr>
            </thead>

            <tbody>
            @forelse($anggotas as $anggota)
                <tr>
                    <td class="text-center"> {{ $loop->iteration + ($anggotas->firstItem()-1) }} </td>
                    <td>
                        <span class="fw-semibold text-primary">
                            {{ $anggota->kode_anggota }}
                        </span>
                    </td>
                    <td>
                        <div class="fw-semibold">{{ $anggota->nama }}</div>
                        <small class="text-muted">
                            {{ Str::limit($anggota->alamat,35) }}
                        </small>
                    </td>
                    
                    <td>
                        @if ($anggota->tanggal_lahir)
                            {{ \Carbon\Carbon::parse($anggota->tanggal_lahir)->translatedFormat('d F Y') }}
                        @else
                            -
                        @endif
                    </td>
                    
                    <td>{{ $anggota->jenis_kelamin }}</td>

                    <td>
                        @if ($anggota->umur !== '-')
                            {{ $anggota->umur }} Tahun
                        @else
                            -
                        @endif
                    </td>

                    <td> {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d-m-Y') }}</td>
                    <td>
                        @if($anggota->status=='Aktif')
                            <span class="badge bg-success">
                                Aktif
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Tidak Aktif
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-2">
                            <button
                                class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailAnggota{{ $anggota->id_anggota }}">
                                <i class="fas fa-eye"></i>
                            </button>

                            <button
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editAnggota{{ $anggota->id_anggota }}">
                                <i class="fas fa-edit"></i>
                            </button>

                            <button
                                class="btn btn-danger btn-sm btn-hapus"
                                data-url="{{ route('master.anggota.destroy',$anggota->id_anggota) }}"
                                data-nama="{{ $anggota->nama }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-data">
                            <div style="font-size:60px"> 👥 </div>
                            <h5> Data Anggota Kosong </h5>
                            <p> Belum ada anggota yang terdaftar. </p>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
        <small class="text-muted">
        Menampilkan {{ $anggotas->firstItem()??0 }} - {{ $anggotas->lastItem()??0 }} dari {{ $anggotas->total() }} data
        </small>
        {{ $anggotas->fragment('tableData')->links('pagination::bootstrap-5') }}
    </div>
</div>


@include('master.anggota.modal-detail')
@include('master.anggota.modal-tambah')
@include('master.anggota.modal-edit')

<form id="formHapus" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

<script>
// HAPUS
document.querySelectorAll('.btn-hapus').forEach(button=>{

    button.addEventListener('click',function(){

        let url=this.dataset.url;
        let nama=this.dataset.nama;

        Swal.fire({

            title:'Hapus Anggota?',

            html:`
                Data anggota <strong>${nama}</strong> akan dihapus permanen.
            `,

            icon:'warning',

            showCancelButton:true,

            confirmButtonText:'Ya, Hapus',

            cancelButtonText:'Batal',

            reverseButtons:true,

            confirmButtonColor:'#dc3545',

            cancelButtonColor:'#6c757d'

        }).then((result)=>{

            if(result.isConfirmed){

                let form=document.getElementById('formHapus');

                form.action=url;

                form.submit();

            }

        });

    });

});

</script>

@endsection