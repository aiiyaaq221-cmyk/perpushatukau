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
                            <select name="id_kategori" id="id_kategori" class="form-select modern-input" required>
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
                            <input type="text" name="judul_buku" id="judul_buku" class="form-control modern-input"  placeholder="Masukkan judul buku" required>
                        </div>

                        <!-- ISBN -->
                        <div class="col-md-6">
                            <label class="modern-label">ISBN</label>

                            <div class="input-group">
                                <input type="text" name="isbn" id="isbn" class="form-control modern-input" placeholder="Masukkan nomor ISBN">
                                <button type="button" class="btn btn-primary" id="btnCariISBN"> 🔍 </button>
                            </div>
                        </div>

                        <!-- Pengarang -->
                        <div class="col-md-6">
                            <label class="modern-label">Pengarang </label>
                            <input type="text" name="pengarang" id="pengarang" class="form-control modern-input" placeholder="Nama pengarang" required>
                        </div>

                        <!-- Penerbit -->
                        <div class="col-md-6">
                            <label class="modern-label"> Penerbit </label>
                            <input type="text"  name="penerbit" id="penerbit" class="form-control modern-input"
                                placeholder="Nama penerbit">
                        </div>

                        <!-- Tahun Terbit -->
                        <div class="col-md-6">
                            <label class="modern-label"> Tahun Terbit </label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit"
                                class="form-control modern-input" placeholder="2025">
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="col-md-6 mb-3">
                            <label class="modern-label"> Tanggal Masuk </label>
                            <input type="date" name="tanggal_masuk" value="{{ date('Y-m-d') }}" class="form-control">
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
                        <div class="col-md-6 ">
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
                        <div class="col-md-6  ">
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
                        <div class="col-md-6"> 
                            <label class="modern-label"> 
                                Jumlah Buku </label> 
                                
                            <input 
                                type="number" 
                                name="jumlah_buku" 
                                class="form-control modern-input" 
                                placeholder="Jumlah buku" required> 
                        </div>

                        <!-- deskripsi -->
                        <div class="col-12">
                            <label class="form-label"> Deskripsi Buku </label>
                            <textarea 
                                name="deskripsi" 
                                id="deskripsi" class="form-control" rows="5" 
                                placeholder="Masukkan deskripsi buku">
                            </textarea>
                        </div>

                        <!-- Cover -->
                        <div class="col-12 mb-3">
                            <label class="modern-label"> Cover Buku </label>
                            <div class="upload-cover">
                                <i class="bi bi-book-half cover-icon"></i>
                                <h6>Pilih Cover</h6>
                                <small>  JPG, PNG, WEBP  </small>
                                <input type="file" name="cover" id="coverInput" hidden>
                                <input type="hidden" name="cover_url" id="cover_url">
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



<script>

document.addEventListener('click', async function(e){

    if(e.target.id !== 'btnCariISBN') return;

    const isbn = document.getElementById('isbn').value.trim();

    if(isbn == ''){
        alert('Masukkan ISBN terlebih dahulu');
        return;
    }

    try{

        const response = await fetch(
            `https://openlibrary.org/api/books?bibkeys=ISBN:${isbn}&format=json&jscmd=data`
        );

        const data = await response.json();

        const key = `ISBN:${isbn}`;

        if(!data[key]){
            alert('Data buku tidak ditemukan');
            return;
        }

        const buku = data[key];

        // Judul
        document.getElementById('judul_buku').value =
            buku.title ?? '';

        // Pengarang
        document.getElementById('pengarang').value =
            buku.authors
                ? buku.authors.map(a => a.name).join(', ')
                : '';

        // Penerbit
        document.getElementById('penerbit').value =
            buku.publishers
                ? buku.publishers.map(p => p.name).join(', ')
                : '';

        // Tahun
        document.getElementById('tahun_terbit').value =
            buku.publish_date
                ? buku.publish_date.match(/\d{4}/)?.[0] ?? ''
                : '';

        // Deskripsi (Open Library sering tidak menyediakan deskripsi di endpoint ini)
        document.getElementById('deskripsi').value = '';

        //cover
        if(buku.cover){
            let cover =
                buku.cover.large ??
                buku.cover.medium ??
                buku.cover.small;

            document.getElementById('preview').src = cover;
            document.getElementById('preview').style.display = 'block';

            document.getElementById('cover_url').value = cover;
        }

        alert('Data buku berhasil ditemukan');

    }catch(error){

        console.error(error);

        alert('Terjadi kesalahan saat mengambil data.');

    }

});

</script>