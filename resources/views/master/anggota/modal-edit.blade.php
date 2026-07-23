@foreach($anggotas as $anggota)

<div class="modal fade"
     id="editAnggota{{ $anggota->id_anggota }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-edit">
        <form action="{{ route('master.anggota.update', $anggota->id_anggota) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content modern-modal border-0 shadow-lg rounded-4 overflow-hidden">

                {{-- HEADER --}}
                <div class="modal-header border-0 px-4 py-3" style="background:linear-gradient(135deg,#c3d6ff,#e9f0ff);">

                    <div class="d-flex align-items-center">

                        <div class="rounded-circle bg-white shadow-sm d-flex align-items-center justify-content-center modal-icon">
                            <i class="fas fa-user text-primary"></i>
                        </div>

                        <div class="ms-3">
                            <h5 class="modal-title fw-bold mb-1">
                                Edit Data Anggota
                            </h5>

                            <small class="text-muted">
                                {{ $anggota->kode_anggota }}
                            </small>
                        </div>

                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>
                
                {{-- BODY --}}
                <div class="modal-body p-4">
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-body text-center py-4">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width:90px;height:90px;font-size:40px;">
                                {{ strtoupper(substr($anggota->nama,0,1)) }}
                            </div>

                            <h4 class="fw-bold mb-1">  {{ $anggota->nama }} </h4>
                            <div class="text-muted mb-3">{{ $anggota->kode_anggota }} </div>

                            @if($anggota->status=='Aktif')
                                <span class="badge bg-success rounded-pill px-4 py-2">
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-danger rounded-pill px-4 py-2">
                                    Tidak Aktif
                                </span>

                            @endif
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-header bg-white border-0 pt-4">
                                    <h5 class="fw-bold mb-0"> 👤 Informasi Pribadi  </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="modern-label"> Nama Anggota </label>
                                        <input type="text"  name="nama"  value="{{ $anggota->nama }}" class="form-control modern-input">
                                    </div>

                                    <div class="mb-3">
                                        <label class="modern-label"> Jenis Kelamin </label>
                                        <select name="jenis_kelamin" class="form-select modern-input">
                                            <option value="L"
                                                {{ $anggota->jenis_kelamin=='L' ? 'selected' : '' }}>
                                                Laki-Laki
                                            </option>

                                            <option value="P"
                                                {{ $anggota->jenis_kelamin=='P' ? 'selected' : '' }}>
                                                Perempuan
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="modern-label"> Umur </label>
                                        <input type="number" name="umur" value="{{ $anggota->umur }}" class="form-control modern-input">
                                    </div>

                                    <div class="mb-0">
                                        <label class="modern-label">
                                            Email
                                        </label>
                                        <input type="email"  name="email"  value="{{ $anggota->email }}" class="form-control modern-input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- INFORMASI KEANGGOTAAN --}}
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-header bg-white border-0 pt-4">
                                    <h5 class="fw-bold mb-0">
                                        📋 Informasi Keanggotaan
                                    </h5>

                                </div>

                                <div class="card-body">

                                    <div class="mb-3">

                                        <label class="modern-label">

                                            Tanggal Daftar

                                        </label>

                                        <input
                                            type="date"
                                            name="tanggal_daftar"
                                            value="{{ $anggota->tanggal_daftar }}"
                                            class="form-control modern-input">

                                    </div>
                                    <div class="mb-3">
                                        <label class="modern-label">  Nomor Telepon </label>

                                        <input type="text"
                                            name="no_telp"
                                            value="{{ $anggota->no_telp }}"
                                            class="form-control modern-input"
                                            maxlength="12"
                                            inputmode="numeric"
                                            pattern="[0-9]{1,12}"
                                            oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                    </div>

                                    <div class="mb-0">
                                        <label class="modern-label"> Status </label>
                                        <select name="status" class="form-select modern-input">
                                            <option value="Aktif"
                                                {{ $anggota->status=='Aktif' ? 'selected' : '' }}>
                                                Aktif
                                            </option>

                                            <option value="Tidak Aktif"
                                                {{ $anggota->status=='Tidak Aktif' ? 'selected' : '' }}>
                                                Tidak Aktif
                                            </option>
                                        </select>
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- ALAMAT --}}
                        <div class="col-12">

                            <div class="card border-0 shadow-sm rounded-4">

                                <div class="card-header bg-white border-0 pt-4">

                                    <h5 class="fw-bold mb-0">
                                        📍 Alamat
                                    </h5>

                                </div>

                                <div class="card-body">

                                    <textarea
                                        name="alamat"
                                        rows="4"
                                        class="form-control modern-textarea">{{ $anggota->alamat }}</textarea>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4">

                    <button
                        type="button"
                        class="btn btn-light px-4 py-2 rounded-pill"
                        data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary px-4 py-2 rounded-pill">

                        💾 Update Data

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

@endforeach