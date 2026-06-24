@foreach($anggotas as $anggota)

<div
    class="modal fade"
    id="detailAnggota{{ $anggota->id_anggota }}"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Detail Anggota
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <!-- Body -->
            <div class="modal-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Kode Anggota
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->kode_anggota ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Nama Lengkap
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->nama }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Jenis Kelamin
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->jenis_kelamin }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            No. Telepon
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->no_telp ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Email
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->email ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="text-muted small">
                            Tanggal Daftar
                        </label>

                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($anggota->tanggal_daftar)->format('d F Y') }}
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small">
                            Alamat
                        </label>

                        <div class="fw-semibold">
                            {{ $anggota->alamat }}
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="text-muted small">
                            Status
                        </label>

                        <div>

                            @if($anggota->status == 'Aktif')

                                <span class="badge bg-success px-3 py-2">
                                    Aktif
                                </span>

                            @else

                                <span class="badge bg-danger px-3 py-2">
                                    Tidak Aktif
                                </span>

                            @endif

                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                    Tutup
                </button>

            </div>

        </div>

    </div>

</div>

@endforeach