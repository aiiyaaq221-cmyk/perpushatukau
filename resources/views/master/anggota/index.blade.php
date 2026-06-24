@extends('layouts.app')

@section('styles')
<link rel="stylesheet"
      href="{{ asset('css/master/anggota.css') }}">
@endsection


@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000,
    toast: true,
    position: 'top-end'
});
</script>
@endif



@section('content')
<div class="header-card">
    <div class="page-header">
        <div>
            <h2 class="page-title"> 👤 Data Anggota </h2>
            <p class="page-subtitle"> Kelola data anggota Perpustakaan Hatukau </p>
        </div>
        <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTambahAnggota">  + Tambah Anggota </button>
    </div>
</div>

<!-- Statistik -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="stat-card blue">
            <h3>
                {{ $totalAnggota }}
            </h3>

            <p>
                Total Anggota
            </p>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card green">

            <h3>
                {{ $anggotaAktif }}
            </h3>

            <p>
                Anggota Aktif
            </p>

        </div>

    </div>

    <div class="col-md-4">

        <div class="stat-card orange">

            <h3>
                {{ $totalAnggota - $anggotaAktif }}
            </h3>

            <p>
                Tidak Aktif
            </p>

        </div>

    </div>

</div>

<!-- Card -->
<div class="modern-card">
    <div class="table-responsive">
        <table class="table modern-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Umur</th>
                    <th>Alamat</th>
                    <th>No. Telp</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

                @forelse($anggotas as $anggota)

                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ $anggota->nama }} </td>
                    <td> {{ $anggota->jenis_kelamin }}</td>
                    <td> {{ $anggota->umur }}</td>
                    <td> {{ $anggota->alamat }} </td>
                    <td> {{ $anggota->no_telp ?? '-' }}  </td>
                    <td> {{ $anggota->email ?? '-' }} </td>
                    <td>
                        {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d-m-Y') }}
                    </td>

                    <td>

                        @if($anggota->status == 'Aktif')

                            <span class="badge bg-success">
                                Aktif
                            </span>

                        @else

                            <span class="badge bg-danger">
                                Tidak Aktif
                            </span>

                        @endif

                    </td>

                    <td class="text-center">
                        <div class="action-buttons">

                            <button
                                type="button"
                                class="btn btn-info btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#detailAnggota{{ $anggota->id_anggota }}">
                                Detail
                            </button>

                            <button
                                type="button"
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editAnggota{{ $anggota->id_anggota }}">
                                Edit
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger btn-sm btn-hapus"
                                data-url="{{ route('master.anggota.destroy', $anggota->id_anggota) }}"
                                data-nama="{{ $anggota->nama }}">
                                Hapus
                            </button>

                        </div>

                    </td>
                </tr>
                @empty

                <tr>
                    <td colspan="10">

                        <div class="empty-data">

                            <div style="font-size:60px">
                                👥
                            </div>

                            <h5>
                                Data Anggota Kosong
                            </h5>

                            <p>
                                Belum ada anggota yang terdaftar
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
       </table>
    </div>
</div>


@include('master.anggota.modal-detail')
@include('master.anggota.modal-tambah')
@include('master.anggota.modal-edit')


<form
    id="formHapus"
    method="POST"
    style="display:none;">

    @csrf
    @method('DELETE')

</form>

<script>

document.querySelectorAll('.btn-hapus').forEach(button => {

    button.addEventListener('click', function () {

        let url = this.dataset.url;
        let nama = this.dataset.nama;

        Swal.fire({
            title: 'Hapus Anggota?',
            html: `
                <div style="font-size:15px">
                    Data anggota
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
            cancelButtonColor: '#6c757d',
            borderRadius: '15px'
        }).then((result) => {

            if (result.isConfirmed) {

                let form = document.getElementById('formHapus');
                form.action = url;
                form.submit();

            }

        });

    });

});

</script>


@endsection