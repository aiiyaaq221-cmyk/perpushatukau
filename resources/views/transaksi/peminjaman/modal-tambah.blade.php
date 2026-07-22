<div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" aria-labelledby="modalTambahPeminjamanLabel"aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('transaksi.peminjaman.store') }}" method="POST">
                @csrf
                <div class="modal-header border-0 text-dark" style=" background: #c3d6ff; border-bottom: 1px solid #e7dcc0 !important; ">
                    <h5 class="modal-title" id="modalTambahPeminjamanLabel"> 📖 Tambah Peminjaman Buku </h5>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"> </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        {{-- Anggota --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                Anggota
                            </label>

                            <select name="id_anggota" class="form-select" required>
                                <option value=""> Pilih Anggota </option>
                                @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id_anggota }}">
                                    {{ $anggota->kode_anggota }}
                                    -
                                    {{ $anggota->nama }}
                                </option>
                                @endforeach
                            </select>

                        </div>

                        {{-- Tanggal Pinjam --}}
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Tanggal Pinjam
                            </label>

                            <input type="date"
                                   name="tanggal_pinjam"
                                   id="tanggal_pinjam"
                                   class="form-control"
                                   value="{{ date('Y-m-d') }}"
                                   required>

                        </div>

                        {{-- Batas Kembali --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">  Batas Kembali  </label>
                            <input type="date" name="batas_kembali" id="batas_kembali" class="form-control" required>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <h6 class="mb-0">
                            Daftar Buku
                        </h6>

                        <button type="button"
                                class="btn btn-success btn-sm"
                                id="add-buku">

                            + Tambah Buku

                        </button>

                    </div>

                    <div id="buku-wrapper">
                        <div class="row buku-item mb-3">
                            <div class="col-md-7">
                                <select name="buku[0][id_buku]" class="form-select" required>
                                    <option value="">Pilih Buku</option>

                                    @foreach($bukus as $buku)
                                        <option value="{{ $buku->id_buku }}">
                                            {{ $buku->judul_buku }} - Stok: {{ $buku->jumlah_buku }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <input type="number" name="buku[0][jumlah]" min="1" class="form-control" required>
                            </div>

                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-buku">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label"> Keterangan </label>
                        <textarea name="keterangan" rows="3" class="form-control" placeholder="Opsional"></textarea>
                    </div>
                </div>

                <div class="modal-footer custom-footer">
                    <button type="button"
                            class="btn-cancel"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn-save">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function () {

    // ==========================
    // Tambah Buku
    // ==========================
    const addButton = document.getElementById('add-buku');
    const wrapper = document.getElementById('buku-wrapper');

    let index = 1;

    addButton.addEventListener('click', function () {

        let html = `
        <div class="row buku-item mb-3">

            <div class="col-md-7">
                <select name="buku[${index}][id_buku]" class="form-select" required>
                    <option value="">Pilih Buku</option>

                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id_buku }}">
                            {{ $buku->judul_buku }} - Stok: {{ $buku->jumlah_buku }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-3">
                <input type="number"
                       name="buku[${index}][jumlah]"
                       min="1"
                       class="form-control"
                       required>
            </div>

            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger remove-buku">
                    Hapus
                </button>
            </div>

        </div>
        `;

        wrapper.insertAdjacentHTML('beforeend', html);
        index++;
    });

    document.addEventListener('click', function (e) {

        if (e.target.classList.contains('remove-buku')) {

            const items = document.querySelectorAll('.buku-item');

            if (items.length > 1) {
                e.target.closest('.buku-item').remove();
            }

        }

    });

    // ==========================
    // Otomatis Batas Kembali (+3 Hari)
    // ==========================
    const tanggalPinjam = document.getElementById("tanggal_pinjam");
    const batasKembali = document.getElementById("batas_kembali");

    function setBatasKembali() {

        if (!tanggalPinjam.value) return;

        let tgl = new Date(tanggalPinjam.value);

        tgl.setDate(tgl.getDate() + 3);

        let yyyy = tgl.getFullYear();
        let mm = String(tgl.getMonth() + 1).padStart(2, '0');
        let dd = String(tgl.getDate()).padStart(2, '0');

        batasKembali.value = `${yyyy}-${mm}-${dd}`;
    }

    // Saat modal dibuka / halaman dimuat
    setBatasKembali();

    // Jika tanggal pinjam diubah
    tanggalPinjam.addEventListener("change", setBatasKembali);

});
</script>