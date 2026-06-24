<div
    class="modal fade"
    id="modalTambahAnggota"
    tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <form
            action="{{ route('master.anggota.store') }}"
            method="POST">

            @csrf

            <div class="modal-content modern-modal">

                <div class="modal-header border-0">

                    <div>
                        <h4 class="modal-title">
                            Tambah Anggota
                        </h4>

                        <small class="text-muted">
                            Tambahkan data anggota perpustakaan
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="modern-label"> Nama Anggota </label>
                            <input type="text" name="nama" class="form-control modern-input"  required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="modern-label"> Jenis Kelamin </label>
                            <select name="jenis_kelamin" class="form-select modern-input" required>
                                <option value=""> Pilih Jenis Kelamin </option>
                                <option value="L"> Laki-Laki </option>
                                <option value="P">  Perempuan  </option>
                            </select>

                        </div>
                            <div class="col-md-6 mb-3">

                            <label class="modern-label">
                                Umur </label>

                            <input
                                type="number"
                                name="umur"
                                class="form-control modern-input"
                                min="1"
                                required>
                        </div>


                        <div class="col-md-6 mb-3">

                            <label class="modern-label">
                                Tanggal Daftar
                            </label>

                            <input
                                type="date"
                                name="tanggal_daftar"
                                class="form-control modern-input"
                                value="{{ date('Y-m-d') }}"
                                required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="modern-label">
                                No. Telepon
                                <span class="optional">(Opsional)</span>
                            </label>

                            <input
                                type="text"
                                name="no_telp"
                                class="form-control modern-input">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="modern-label">
                                Email
                                <span class="optional">(Opsional)</span>
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control modern-input">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="modern-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                rows="3"
                                class="form-control modern-textarea"
                                required></textarea>

                        </div>

                        <div class="col-md-12">

                            <label class="modern-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select modern-input">

                                <option value="Aktif">
                                    Aktif
                                </option>

                                <option value="Tidak Aktif">
                                    Tidak Aktif
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        type="button"
                        class="btn btn-light"
                        data-bs-dismiss="modal">

                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Simpan Data
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>