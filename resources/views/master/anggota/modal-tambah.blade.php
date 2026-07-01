<div class="modal fade" id="modalTambahAnggota" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form action="{{ route('master.anggota.store') }}" method="POST">
            @csrf

            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header" 
                    style="background:linear-gradient(135deg,#86a9f4,#7b9cf5);">
                    <div>
                        <h4 class="modal-title fw-bold mb-1"> 👤 Tambah Anggota </h4>
                        <small class="modal-subtitle">
                            Tambahkan data anggota Perpustakaan Hatukau
                        </small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"> </button>
                </div>

                <!-- BODY -->
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="modern-label"> Nama Anggota </label>
                            <input type="text" name="nama" class="form-control modern-input" placeholder="Masukkan nama anggota" required>
                        </div>

                        <div class="col-md-6">
                            <label class="modern-label"> Jenis Kelamin </label>
                            <select name="jenis_kelamin" class="form-select modern-input" required>
                                <option value=""> -- Pilih Jenis Kelamin -- </option>
                                <option value="L"> Laki-Laki </option>
                                <option value="P"> Perempuan </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="modern-label">  Umur </label>
                            <input type="number" name="umur" class="form-control modern-input" placeholder="Masukkan umur" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="modern-label">Tanggal Daftar </label>
                            <input type="date" name="tanggal_daftar" class="form-control modern-input" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="modern-label"> Nomor Telepon
                                <span class="optional"> (Opsional) </span>
                            </label>
                            <input type="text" name="no_telp" class="form-control modern-input" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label class="modern-label"> Email
                                <span class="optional"> (Opsional) </span>
                            </label>
                            <input type="email" name="email" class="form-control modern-input" placeholder="email@gmail.com">
                        </div>

                        <div class="col-md-12">
                            <label class="modern-label"> Alamat </label>
                            <textarea name="alamat" rows="4"  class="form-control modern-textarea" placeholder="Masukkan alamat lengkap..." required></textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="modern-label"> Status Anggota </label>
                            <select name="status" class="form-select modern-input">
                                <option value="Aktif"> Aktif </option>
                                <option value="Tidak Aktif"> Tidak Aktif </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 px-4 pb-4 pt-2">
                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button  type="submit" class="btn btn-primary px-4 rounded-pill">
                        💾 Simpan Data
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>