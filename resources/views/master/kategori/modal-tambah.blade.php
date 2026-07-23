<div class="modal fade"
     id="modalTambahKategori"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered">

        <form action="{{ route('master.kategori.store') }}"
              method="POST">

            @csrf

            <div class="modal-content modern-modal border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header border-0 px-4 py-3"
                     style="background:linear-gradient(135deg,#c3d6ff,#e9f0ff);">

                    <div class="d-flex align-items-center">
                        <div class="modal-icon rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center">
                            <i class="fas fa-folder-open text-primary"></i>
                        </div>

                        <div class="ms-3">

                            <h5 class="modal-title fw-bold mb-1">
                                Tambah Kategori
                            </h5>

                            <small class="text-muted">

                                Tambahkan kategori buku baru

                            </small>

                        </div>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- BODY -->
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="modern-label"> Nama Kategori </label>
                        <input type="text" name="nama_kategori" class="form-control modern-input" placeholder="Contoh : Novel"
                            required>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button"
                            class="btn btn-light rounded-pill px-4"
                            data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>