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

<div class="modern-card">

    <div class="table-responsive">

        <table class="table modern-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kategoris as $kategori)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $kategori->nama_kategori }}</td>

                        <td>

                            <button
                                class="btn btn-warning btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#editKategori{{ $kategori->id_kategori }}">

                                Edit
                            </button>
                        
                            <!--HAPUS  -->
                        <form
                            id="delete-form-{{ $kategori->id_kategori }}"
                            action="{{ route('master.kategori.destroy', $kategori->id_kategori) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                type="button"
                                class="btn btn-danger btn-sm"
                                onclick="confirmDelete({{ $kategori->id_kategori }})">

                                Hapus
                            </button>

                        </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3" class="text-center py-4">

                            <h5>📚 Data Kategori Kosong</h5>

                            <small>
                                Belum ada kategori yang ditambahkan
                            </small>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- Modal Tambah --}}
<div class="modal fade"
     id="modalTambahKategori"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Tambah Kategori
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action="{{ route('master.kategori.store') }}"
                method="POST">

                @csrf

                <div class="modal-body">

                    <label class="form-label">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        required>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

{{-- Modal Edit --}}
@foreach($kategoris as $kategori)

<div class="modal fade"
     id="editKategori{{ $kategori->id_kategori }}"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Kategori
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <form
                action="{{ route('master.kategori.update', $kategori->id_kategori) }}"
                method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <label class="form-label">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        value="{{ $kategori->nama_kategori }}"
                        required>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-warning">

                        Update
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach


<script>
function confirmDelete(id)
{
    Swal.fire({
        title: 'Hapus Kategori?',
        text: "Data kategori yang dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {

            document.getElementById('delete-form-' + id).submit();

        }

    });
}
</script>
@endsection