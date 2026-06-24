@foreach($anggotas as $anggota)

<div
    class="modal fade"
    id="editAnggota{{ $anggota->id_anggota }}"
    tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <form
            action="{{ route('master.anggota.update',$anggota->id_anggota) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content modern-modal">
                <div class="modal-header border-0">
                    <h4>Edit Anggota</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="modern-label">  Nama Anggota</label>
                            <input type="text" name="nama" value="{{ $anggota->nama }}" class="form-control modern-input">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Jenis Kelamin
                            </label>

                            <select
                                name="jenis_kelamin"
                                class="form-select modern-input">

                                <option value="L"
                                    {{ $anggota->jenis_kelamin == 'L' ? 'selected' : '' }}>
                                    Laki-Laki
                                </option>

                                <option value="P"
                                    {{ $anggota->jenis_kelamin == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>

                            </select>                            
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Umur
                            </label>

                            <input
                                type="number"
                                name="umur"
                                value="{{ $anggota->umur }}"
                                class="form-control modern-input">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Tanggal Daftar
                            </label>

                            <input
                                type="date"
                                name="tanggal_daftar"
                                value="{{ $anggota->tanggal_daftar }}"
                                class="form-control modern-input">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                No. Telepon
                            </label>

                            <input
                                type="text"
                                name="no_telp"
                                value="{{ $anggota->no_telp }}"
                                class="form-control modern-input">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="modern-label">
                                Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ $anggota->email }}"
                                class="form-control modern-input">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="modern-label">
                                Alamat
                            </label>

                            <textarea
                                name="alamat"
                                rows="3"
                                class="form-control modern-textarea">{{ $anggota->alamat }}</textarea>
                        </div>

                        <div class="col-md-12">
                            <label class="modern-label">
                                Status
                            </label>

                            <select
                                name="status"
                                class="form-select modern-input">

                                <option value="Aktif"
                                    {{ $anggota->status == 'Aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="Tidak Aktif"
                                    {{ $anggota->status == 'Tidak Aktif' ? 'selected' : '' }}>
                                    Tidak Aktif
                                </option>

                            </select>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        Update Data
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endforeach