@foreach($anggotas as $anggota)

<div class="modal fade"
     id="detailAnggota{{ $anggota->id_anggota }}"
     tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 py-3" style="background:linear-gradient(135deg,#c3d6ff,#e9f0ff);">
                <div> <h4 class="mb-0 fw-bold"> 👤 Detail Anggota </h4>
                    <small class="text-muted"> {{ $anggota->nama }} </small>
                </div>

                <button class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            {{-- BODY --}}
            <div class="modal-body p-4">

                <div class="row g-4">

                    {{-- LEFT --}}
                    <div class="col-lg-4">

                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">

                            <div class="avatar mb-3 fs-1">
                                👤
                            </div>

                            <h4 class="mb-1">
                                {{ $anggota->nama }}
                            </h4>

                            <small class="text-muted">
                                {{ $anggota->kode_anggota }}
                            </small>

                            <hr>

                            @if($anggota->status=='Aktif')

                                <span class="badge bg-success rounded-pill px-3 py-2">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                    Tidak Aktif
                                </span>

                            @endif

                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-lg-8">

                        <div class="card border-0 shadow-sm rounded-4 p-4">

                            <h5 class="mb-4">
                                📌 Informasi Anggota
                            </h5>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Kode Anggota</small>
                                        <div class="fw-bold">
                                            {{ $anggota->kode_anggota }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Nama Lengkap</small>
                                        <div class="fw-bold">
                                            {{ $anggota->nama }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Jenis Kelamin</small>
                                        <div class="fw-bold">
                                            {{ $anggota->jenis_kelamin }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>No. Telepon</small>
                                        <div class="fw-bold">
                                            {{ $anggota->no_telp ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Email</small>
                                        <div class="fw-bold">
                                            {{ $anggota->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Tanggal Daftar</small>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d-m-Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="info-box">
                                        <small>Alamat</small>
                                        <div class="fw-bold">
                                            {{ $anggota->alamat }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Status</small>

                                        <div class="mt-2">

                                            @if($anggota->status=='Aktif')

                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    Aktif
                                                </span>

                                            @else

                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    Tidak Aktif
                                                </span>

                                            @endif

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 p-3">

                <button class="btn btn-secondary px-4"
                        data-bs-dismiss="modal">

                    Tutup

                </button>

            </div>

        </div>

    </div>

</div>

@endforeach