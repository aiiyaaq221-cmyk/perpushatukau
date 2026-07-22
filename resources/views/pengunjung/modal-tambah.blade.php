<div class="modal fade" id="modalTambahPengunjung" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('pengunjung.store') }}" method="POST" class="w-100">
            @csrf
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- HEADER -->
                <div class="modal-header border-0 text-dark" style=" background: #c3d6ff; border-bottom: 1px solid #e7dcc0 !important; ">
                    <div>
                       <h4 class="modal-title fw-bold text-dark mb-1">
                            👤 Tambah Pengunjung </h4>

                        <p class="text-muted mb-0 small">
                            Tambahkan data kunjungan pengunjung perpustakaan
                        </p></div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"> </button> 
                </div>

                <!-- BODY -->
                <div class="modal-body"
                    style="
                        padding:35px;
                        display:flex; justify-content:center; ">

                    <div style="width:100%; max-width:550px;">
                        <!-- JENIS PENGUNJUNG -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold fs-5 mb-2">
                                Jenis Pengunjung
                            </label>

                            <select name="jenis_pengunjung" id="jenisPengunjung" class="form-select form-select-lg" required>
                                <option value=""> -- Pilih Jenis Pengunjung -- </option>
                                <option value="anggota"> Anggota </option>
                                <option value="non_anggota"> Non Anggota </option>
                            </select>
                        </div>

                        <!-- CONTAINER DETAIL -->
                        <div id="detailPengunjung" style="display:none;">
                            <!-- FORM ANGGOTA -->
                            <div id="formAnggota" style="display:none;">
                                <div class="mb-4">
                                    <label class="form-label fw-semibold"> Pilih Anggota </label>
                                    <select name="id_anggota" class="form-select">
                                        <option value=""> -- Pilih Anggota -- </option>
                                        @foreach($anggotas as $anggota)
                                            <option value="{{ $anggota->id_anggota }}">
                                                {{ $anggota->kode_anggota }}
                                                -
                                                {{ $anggota->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- FORM NON ANGGOTA -->
                            <div id="formNonAnggota" style="display:none;">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold"> Nama </label>
                                        <input type="text" name="nama" class="form-control">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-semibold"> Umur </label>
                                        <input type="number" name="umur" class="form-control">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold"> Jenis Kelamin </label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value=""> Pilih </option>
                                        <option value="L"> Laki-laki </option>
                                        <option value="P"> Perempuan </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold"> Alamat </label>
                                    <textarea name="alamat" rows="3" class="form-control"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold"> Status Pengunjung </label>
                                    <input type="text" name="status_pengunjung" class="form-control" placeholder="Warga, Organisasi, Siswa, dll">
                                </div>
                            </div>

                            <!-- TUJUAN -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold"> Tujuan </label>
                                <select name="tujuan" class="form-select" required>
                                    <option value=""> Pilih Tujuan </option>
                                    <option value="Membaca"> Membaca </option>
                                    <option value="Meminjam Buku"> Meminjam Buku </option>
                                    <option value="Mengembalikan Buku"> Mengembalikan Buku </option>
                                    <option value="Penelitian"> Penelitian </option>
                                    <option value="Lainnya"> Lainnya </option>
                                </select>
                            </div>

                            <!-- KETERANGAN -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold"> Keterangan </label>
                                <textarea name="keterangan" rows="4" class="form-control" placeholder="Tambahkan keterangan..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal"> Batal </button>
                    <button type="submit" class="btn btn-primary px-4"> 💾 Simpan </button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const jenis = document.getElementById('jenisPengunjung');
    const detail = document.getElementById('detailPengunjung');
    const anggota = document.getElementById('formAnggota');
    const nonAnggota = document.getElementById('formNonAnggota');

    jenis.addEventListener('change', function () {

        detail.style.display = 'none';
        anggota.style.display = 'none';
        nonAnggota.style.display = 'none';

        if (this.value === 'anggota') {
            detail.style.display = 'block';
            anggota.style.display = 'block';
        }

        if (this.value === 'non_anggota') {
            detail.style.display = 'block';
            nonAnggota.style.display = 'block';
        }
    });
});
</script>