<!-- Modal Tambah Buku -->
<div class="modal fade" id="modalTambahBuku" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form action="{{ route('master.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header-custom">
                    <div>
                        <h5>📚 Tambah Data Buku</h5>
                        <p> Lengkapi informasi buku yang akan ditambahkan ke perpustakaan </p>
                    </div>
                    <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"> </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label class="modern-label"> Kategori Buku </label>
                            <select name="id_kategori" class="form-select modern-input" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kode Buku -->
                        <div class="col-md-6">
                            <label class="modern-label"> Kode Buku
                                <small class="text-danger"> (Opsional) </small>
                            </label>
                            <input type="text" name="kode_buku" class="form-control modern-input" placeholder="Contoh: 987-602-03-0112-9">
                        </div>

                        <!-- Judul Buku -->
                        <div class="col-md-6">
                            <label class="modern-label"> Judul Buku </label>
                            <input type="text" name="judul_buku" class="form-control modern-input"  placeholder="Masukkan judul buku" required>
                        </div>

                        <!-- Pengarang -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Pengarang
                            </label>

                            <input
                                type="text"
                                name="pengarang"
                                class="form-control modern-input"
                                placeholder="Nama pengarang"
                                required>
                        </div>

                        <!-- Penerbit -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Penerbit
                            </label>

                            <input
                                type="text"
                                name="penerbit"
                                class="form-control modern-input"
                                placeholder="Nama penerbit">
                        </div>

                        <!-- Tahun Terbit -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Tahun Terbit
                            </label>

                            <input
                                type="number"
                                name="tahun_terbit"
                                class="form-control modern-input"
                                placeholder="2025">
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Tanggal Masuk
                            </label>

                            <input
                                type="date"
                                name="tanggal_masuk"
                                value="{{ date('Y-m-d') }}"
                                class="form-control">
                        </div>

                        <!-- Sumber -->
                        <div class="col-md-6 ">
                            <label class="modern-label">
                                Sumber Buku
                            </label>

                            <input
                                type="text"
                                name="sumber"
                                class="form-control modern-input"
                                placeholder="Contoh: Sumbangan Perpus Nasional Maluku">
                        </div>

                        <!-- Jilid -->
                        <div class="col-md-4 ">
                            <label class="modern-label">
                                Jilid
                                <small class="text-danger">
                                    (Opsional)
                                </small>
                            </label>

                            <input
                                type="text"
                                name="jilid"
                                class="form-control modern-input"
                                placeholder="Jilid">
                        </div>

                        <!-- Edisi -->
                        <div class="col-md-4  ">
                            <label class="modern-label">
                                Edisi
                                <small class="text-danger">
                                    (Opsional)
                                </small>
                            </label>

                            <input
                                type="text"
                                name="edisi"
                                class="form-control modern-input"
                                placeholder="Edisi">
                        </div>

                        <!-- Jumlah Buku -->
                        <div class="col-md-4 mb-3"> 
                            <label class="modern-label"> 
                                Jumlah Buku </label> 
                                
                            <input 
                                type="number" 
                                name="jumlah_buku" 
                                class="form-control modern-input" 
                                placeholder="Jumlah buku" required> 
                        </div>

                        <!-- Cover -->
                        <div class="col-12 mb-3">

                            <label class="modern-label">
                                Cover Buku
                            </label>

                            <div class="upload-cover">
                                <i class="bi bi-book-half cover-icon"></i>
                                <h6>Pilih Cover</h6>
                                <small>  JPG, PNG, WEBP  </small>
                                <input type="file" name="cover" id="coverInput"    hidden>
                                <img id="preview" class="cover-preview">
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label class="modern-label"> Keterangan
                                <span class="text-danger">(Opsional)</span>
                            </label>
                            <textarea  class="form-control modern-textarea"  rows="4"  name="keterangan" placeholder="Masukkan keterangan buku..."></textarea>
                        </div>
                </div>

                <!-- Footer -->                
                <div class="modal-footer custom-footer">
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">  Batal </button>
                    <button type="submit" class="btn-save"> Simpan </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Preview Cover -->
<script>
document.querySelector('.upload-cover')
.addEventListener('click', function () {
    document.getElementById('coverInput').click();
});

document.getElementById('coverInput')
.addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(event){
            const preview =
                document.getElementById('preview');
            preview.src = event.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});
</script>