@foreach($kategoris as $kategori)

<div class="modal fade"
     id="editKategori{{ $kategori->id_kategori }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-md modal-dialog-centered">

        <form action="{{ route('master.kategori.update',$kategori->id_kategori) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content modern-modal border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- HEADER -->
                <div class="modal-header border-0 px-4 py-3"
                     style="background:linear-gradient(135deg,#FFE8B5,#FFF5DE);">

                    <div class="d-flex align-items-center">

                        <div class="modal-icon rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center">

                            <i class="fas fa-edit text-warning"></i>

                        </div>

                        <div class="ms-3">

                            <h5 class="modal-title fw-bold mb-1">

                                Edit Kategori

                            </h5>

                            <small class="text-muted">

                                Perbarui nama kategori

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

                        <label class="modern-label">

                            Nama Kategori

                        </label>

                        <input
                            type="text"
                            name="nama_kategori"
                            value="{{ $kategori->nama_kategori }}"
                            class="form-control modern-input"
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
                            class="btn btn-warning rounded-pill px-4">
                        <i class="fas fa-pen me-1"></i>
                        Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endforeach