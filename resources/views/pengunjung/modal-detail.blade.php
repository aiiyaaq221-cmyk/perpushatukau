@foreach($pengunjungs as $pengunjung)
<div class="modal fade" id="detailPengunjung{{ $pengunjung->id_tamu }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- HEADER -->
            <div class="modal-header border-0 text-dark"
                    style=" background: #c3d6ff; border-bottom: 1px solid #e7dcc0 !important; ">
                <h5 class="modal-title fw-bold"> 📋 Detail Pengunjung </h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"> </button>
            </div>

            <div class="modal-body p-4">
                <!-- STATUS -->
                <div class="mb-4 text-center">
                    @if($pengunjung->id_anggota)
                        <span class="badge bg-success px-3 py-2 rounded-pill fs-6">
                            Anggota
                        </span>
                    @else
                        <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">
                            Non Anggota
                        </span>
                    @endif
                </div>

                <!-- DATA PENGUNJUNG -->
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <small class="text-muted d-block">
                                Nama Pengunjung
                            </small>

                            <div class="fw-semibold fs-6">
                                {{ $pengunjung->nama }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <small class="text-muted d-block"> Tanggal Kunjungan </small>
                            <div class="fw-semibold"> {{ \Carbon\Carbon::parse($pengunjung->tanggal_kunjungan)->format('d M Y H:i') }} </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <small class="text-muted d-block">
                                Jenis Kelamin
                            </small>

                            <div class="fw-semibold">
                                {{ $pengunjung->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <small class="text-muted d-block">
                                Tujuan
                            </small>

                            <div class="fw-semibold">
                                {{ $pengunjung->tujuan }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="bg-light rounded-3 p-3">
                            <small class="text-muted d-block">
                                Alamat
                            </small>

                            <div class="fw-semibold">
                                {{ $pengunjung->alamat ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded-3 p-3 h-100">
                            <small class="text-muted d-block">
                                Status Pengunjung
                            </small>

                            <div class="fw-semibold">
                                {{ $pengunjung->status_pengunjung ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="bg-light rounded-3 p-3">
                            <small class="text-muted d-block">
                                Keterangan
                            </small>

                            <div class="fw-semibold">
                                {{ $pengunjung->keterangan ?? '-' }}
                            </div>
                        </div>
                    </div>

                </div>

                <!-- DATA ANGGOTA -->
                @if($pengunjung->id_anggota)

                <div class="mt-4">

                    <div class="d-flex align-items-center mb-3">
                        <h6 class="fw-bold text-primary mb-0">
                            👤 Data Anggota
                        </h6>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted d-block">
                                    Kode Anggota
                                </small>

                                <div class="fw-semibold">
                                    {{ $pengunjung->anggota->kode_anggota ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted d-block">
                                    Nama Anggota
                                </small>

                                <div class="fw-semibold">
                                    {{ $pengunjung->anggota->nama ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border rounded-3 p-3 h-100">
                                <small class="text-muted d-block">
                                    No Telepon
                                </small>

                                <div class="fw-semibold">
                                    {{ $pengunjung->anggota->no_telp ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- FOOTER -->
            <div class="modal-footer border-0 bg-light">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal"> Tutup </button>
            </div>
        </div>
    </div>
</div>
@endforeach