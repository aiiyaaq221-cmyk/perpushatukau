@foreach($pengunjungs as $pengunjung)
<div class="modal fade" id="editPengunjung{{ $pengunjung->id_tamu }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('pengunjung.update', $pengunjung->id_tamu) }}">
            @csrf
            @method('PUT')

            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 text-dark"
                    style=" background: #c3d6ff;
                            border-bottom: 1px solid #e7dcc0 !important; ">
                    <div>
                        <h5 class="modal-title fw-bold mb-1"> ✏️ Edit Pengunjung </h5>
                        <small class="text-dark opacity-75"> Perbarui informasi data pengunjung </small>
                    </div>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"> </button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary"> Nama Pengunjung </label>
                            <input type="text" name="nama" value="{{ $pengunjung->nama }}" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary"> Jenis Kelamin </label>
                            <select name="jenis_kelamin"
                                    class="form-select rounded-3"
                                    required>
                                <option value="L"
                                    {{ $pengunjung->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>
                                <option value="P"
                                    {{ $pengunjung->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary"> Tujuan Kunjungan </label>
                            <select name="tujuan" class="form-select rounded-3" required>
                                <option value="Membaca" {{ $pengunjung->tujuan == 'Membaca' ? 'selected' : '' }}> Membaca </option>
                                <option value="Meminjam Buku" {{ $pengunjung->tujuan == 'Meminjam Buku' ? 'selected' : '' }}> Meminjam Buku </option>
                                <option value="Mengembalikan Buku" {{ $pengunjung->tujuan == 'Mengembalikan Buku' ? 'selected' : '' }}> Mengembalikan Buku </option>
                                <option value="Penelitian" {{ $pengunjung->tujuan == 'Penelitian' ? 'selected' : '' }}> Penelitian </option>
                                <option value="Lainnya" {{ $pengunjung->tujuan == 'Lainnya' ? 'selected' : '' }}> Lainnya </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary"> Status Pengunjung </label>
                            <input type="text" name="status_pengunjung" value="{{ $pengunjung->status_pengunjung }}" class="form-control rounded-3"placeholder="Warga, Organisasi, Pegawai, dll">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary"> Alamat </label>
                            <textarea name="alamat" rows="3" class="form-control rounded-3">{{ $pengunjung->alamat }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary"> Keterangan </label>
                            <textarea name="keterangan" rows="3" class="form-control rounded-3" placeholder="Tambahkan catatan jika diperlukan">{{ $pengunjung->keterangan }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light border rounded-3 px-4" data-bs-dismiss="modal"> Batal </button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 btn-update"> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: "success",
        title: "Berhasil",
        text: "{{ session('success') }}",
        confirmButtonColor:"#3085d6",
        timer:2500,
        showConfirmButton:false
    });
});
</script>
@endif

@endforeach