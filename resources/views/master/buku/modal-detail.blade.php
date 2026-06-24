<div class="modal fade" id="detailBukuModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header-custom">
                <div>
                    <h5>📚 Detail Buku</h5>
                    <p>Informasi lengkap data buku</p>
                </div>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4">

                <div class="row g-4">

                    <!-- COVER -->
                    <div class="col-md-4 text-center">
                        <img id="detail_cover"
                             class="img-fluid rounded"
                             style="width:150px;height:220px;object-fit:cover;box-shadow:0 5px 15px rgba(0,0,0,.1);">

                        <div class="mt-3">
                            <span id="detail_status" class="badge"></span>
                        </div>
                    </div>

                    <!-- INFO -->
                    <div class="col-md-8">

                        <h4 id="detail_judul" class="fw-bold mb-1"></h4>

                        <p class="text-muted mb-2">
                            <span id="detail_kode"></span>
                        </p>

                        <hr>

                        <div class="row">

                            <div class="col-6 mb-2">
                                <small class="text-muted">Pengarang</small>
                                <div id="detail_pengarang"></div>
                            </div>

                            <div class="col-6 mb-2">
                                <small class="text-muted">Penerbit</small>
                                <div id="detail_penerbit"></div>
                            </div>

                            <div class="col-6 mb-2">
                                <small class="text-muted">Kategori</small>
                                <div id="detail_kategori"></div>
                            </div>

                            <div class="col-6 mb-2">
                                <small class="text-muted">Tahun Terbit</small>
                                <div id="detail_tahun"></div>
                            </div>

                            <div class="col-6 mb-2">
                                <small class="text-muted">Stok</small>
                                <div id="detail_stok"></div>
                            </div>

                            <div class="col-6 mb-2">
                                <small class="text-muted">Jumlah Buku</small>
                                <div id="detail_jumlah"></div>
                            </div>

                            <div class="col-12 mt-2">
                                <small class="text-muted">Keterangan</small>
                                <div id="detail_keterangan"></div>
                            </div>

                        </div>
                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<script>
function setDetailBuku(buku) {

    // cover
    document.getElementById('detail_cover').src =
        buku.cover ? '/storage/' + buku.cover : '/img/no-image.png';

    // judul & kode
    document.getElementById('detail_judul').innerText = buku.judul_buku;
    document.getElementById('detail_kode').innerText = buku.kode_buku ?? '-';

    // info lain
    document.getElementById('detail_pengarang').innerText = buku.pengarang ?? '-';
    document.getElementById('detail_penerbit').innerText = buku.penerbit ?? '-';
    document.getElementById('detail_kategori').innerText = buku.kategori?.nama_kategori ?? '-';
    document.getElementById('detail_tahun').innerText = buku.tahun_terbit ?? '-';
    document.getElementById('detail_stok').innerText = buku.stok_tersedia ?? 0;
    document.getElementById('detail_jumlah').innerText = buku.jumlah_buku ?? 0;
    document.getElementById('detail_keterangan').innerText = buku.keterangan ?? '-';

    // status badge
    let status = '';
    let className = '';

    if (buku.stok_tersedia > 5) {
        status = 'Tersedia';
        className = 'bg-success';
    } else if (buku.stok_tersedia > 0) {
        status = 'Hampir Habis';
        className = 'bg-warning';
    } else {
        status = 'Habis';
        className = 'bg-danger';
    }

    const badge = document.getElementById('detail_status');
    badge.innerText = status;
    badge.className = 'badge ' + className;
}
</script>