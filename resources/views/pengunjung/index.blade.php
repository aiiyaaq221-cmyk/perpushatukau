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


<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <h3>{{ $totalPengunjung }}</h3>
            <p>Total Kunjungan</p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card green">
            <h3>{{ $pengunjungHariIni }} </h3>
            <p>Hari Ini </p>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card orange">
            <h3>{{ $nonAnggota }}</h3>
            <p> Non Anggota </p>
        </div>
    </div>
</div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-body">
             <form id="filterForm" method="GET" action="{{ route('pengunjung.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label>Nama Pengunjung</label>
                        <input  type="text" name="nama" id="namaInput" class="form-control" placeholder="Cari nama..."
                            value="{{ request('nama') }}" onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Kunjungan</label>
                        <input type="date" name="tanggal" id="tanggalInput" class="form-control"
                            value="{{ request('tanggal') }}" onchange="this.form.submit()">
                    </div>

                    <div class="col-md-2">
                        <label>Jenis Pengunjung</label>
                        <select name="status" id="statusInput" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua</option>

                            <option value="Anggota"
                                {{ request('status') == 'Anggota' ? 'selected' : '' }}>
                                Anggota
                            </option>

                            <option value="Umum"
                                {{ request('status') == 'Umum' ? 'selected' : '' }}>
                                NonAnggota
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">
                        <button class="btn btn-primary flex-fill"> <i class="fas fa-search"> Filter</i> </button>

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
    <div class="table-responsive">
        <table class="table modern-table text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Status/Jabatan</th>
                    <th>Tujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pengunjungs as $pengunjung)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                   <td>
                        <div class="fw-semibold text-dark">
                            {{ \Carbon\Carbon::parse($pengunjung->tanggal_kunjungan)
                                ->timezone('Asia/Jayapura')
                                ->format('d M Y') }}
                        </div>

                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($pengunjung->tanggal_kunjungan)
                                ->timezone('Asia/Jayapura')
                                ->format('H:i') }} WIT
                        </small>
                    </td>
                    <td>
                        {{ $pengunjung->nama }}

                        @if($pengunjung->jenis_pengunjung == 'anggota')
                            <span class="badge bg-primary ms-1">
                                Anggota
                            </span>
                        @endif
                    </td>
                    <td>{{ $pengunjung->jenis_kelamin }}</td>
                    <td>                        
                        @if($pengunjung->jenis_pengunjung == 'anggota')

                            <span class="badge bg-success">

                                {{ $pengunjung->anggota->status ?? 'Aktif' }}

                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $pengunjung->status_pengunjung }}
                            </span>

                        @endif
                    </td>

                    <td>{{ $pengunjung->tujuan }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-info btn-sm action-btn">
                                Detail
                            </button>

                            <button class="btn btn-warning btn-sm action-btn">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm action-btn">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty

                <tr>
                    <td colspan="6">
                        <div class="empty-data">
                            <div style="font-size:60px">
                                👥
                            </div>
                            <h5> Data Pengunjung Kosong </h5>
                            <p> Belum ada data kunjungan </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.btn-hapus').forEach(button => {

        button.addEventListener('click', function () {

            let url = this.dataset.url;
            let nama = this.dataset.nama;

            Swal.fire({
                title: 'Hapus Pengunjung?',
                html: `
                    <div style="font-size:15px">
                        Data pengunjung
                        <br>
                        <strong>${nama}</strong>
                        <br><br>
                        akan dihapus permanen.
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then((result) => {

                if (result.isConfirmed) {

                    const form = document.getElementById('formHapus');
                    form.action = url;
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