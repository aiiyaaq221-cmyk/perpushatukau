@foreach($bukus as $buku)
<div class="modal fade" 
    id="editBuku{{ $buku->id_buku }}" 
    tabindex="-1" 
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form action="{{ route('master.buku.update',$buku->id_buku) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header-custom">
                    <div> 
                        <h5>📚 Edit Data Buku</h5>
                        <p> Perbarui informasi buku pada perpustakaan </p>
                    </div>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row g-4">

                        <!-- Kategori -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Kategori Buku
                            </label>

                            <select name="id_kategori" class="form-select modern-input">
                                @foreach($kategoris as $kategori)
                                    <option
                                        value="{{ $kategori->id_kategori }}"
                                        {{ $buku->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>

                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kode Buku -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Kode Buku
                                <small class="text-danger">
                                    (Opsional)
                                </small>
                            </label>

                            <input type="text"  name="kode_buku" class="form-control modern-input" value="{{ $buku->kode_buku }}" placeholder="Contoh: BK001">
                        </div>

                        <!-- Judul Buku -->
                        <div class="col-md-6">
                            <label class="modern-label">
                                Judul Buku
                            </label>

                            <input
                                type="text"
                                name="judul_buku"
                                class="form-control modern-input"
                                value="{{ $buku->judul_buku }}">
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
                                value="{{ $buku->pengarang }}">
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
                                value="{{ $buku->penerbit }}">
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
                                value="{{ $buku->tahun_terbit }}">
                        </div>

                        <!-- Tanggal Masuk -->
                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Tanggal Masuk
                            </label>

                            <input
                                type="date"
                                name="tanggal_masuk"
                                class="form-control modern-input">
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
                                value="{{ $buku->sumber }}">
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
                               value="{{ $buku->jilid }}">
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
                                value="{{ $buku->edisi }}">
                        </div>

                        <!-- Jumlah Buku -->
                        <div class="col-md-4 mb-3"> 
                            <label class="modern-label"> 
                                Jumlah Buku </label> 
                                
                            <input 
                                type="number" 
                                name="jumlah_buku" 
                                class="form-control modern-input" 
                                value="{{ $buku->jumlah_buku }}"> 
                        </div>

                        <!-- Stok -->
                        <div class="col-12 mb-3">
                            <label class="modern-label">
                                Stok Tersedia
                            </label>

                            <input
                                type="number"
                                name="stok_tersedia"
                                class="form-control modern-input"
                                value="{{ $buku->stok_tersedia }}"
                                required>
                        </div>

                        <!-- Cover -->
                        <div class="col-12">
                            <label class="modern-label">
                                Cover Buku
                            </label>

                            @if($buku->cover)
                                <div class="text-center mb-3">
                                    <img
                                        src="{{ asset('storage/'.$buku->cover) }}"
                                        style="
                                            width:120px;
                                            height:160px;
                                            object-fit:cover;
                                            border-radius:12px;                                       ">
                                </div>
                            @endif

                            <input
                                type="file"
                                name="cover"
                                class="form-control modern-input">
                        </div>

                        <!-- Keterangan -->
                        <div class="col-12">
                            <label class="modern-label">
                                Keterangan
                                <span class="optional">(Opsional)</span>
                            </label>

                            <textarea
                                class="form-control modern-textarea"
                                rows="4"
                                name="keterangan">{{ $buku->keterangan }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

