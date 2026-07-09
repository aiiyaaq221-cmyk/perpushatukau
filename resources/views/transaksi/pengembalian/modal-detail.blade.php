@foreach($pengembalians as $item)

<div class="modal fade"
     id="detail{{ $item->id_pengembalian }}"
     tabindex="-1">

    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            {{-- HEADER --}}
            <div class="modal-header border-0 p-4"
                 style="background: linear-gradient(135deg,#c3d6ff,#e6eeff);">

                <div>
                    <h4 class="mb-0 fw-bold">
                        📖 Detail Pengembalian
                    </h4>

                    <small class="text-muted">
                        {{ $item->peminjaman->kode_peminjaman }}
                    </small>
                </div>

                <button class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            {{-- BODY --}}
            <div class="modal-body p-4">

                <div class="row g-4">

                    {{-- LEFT SIDE --}}
                    <div class="col-lg-4">

                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">

                            <div class="avatar mb-3 fs-1">
                                👤
                            </div>

                            <h5 class="mb-1">
                                {{ $item->peminjaman->anggota->nama }}
                            </h5>

                            <small class="text-muted">
                                {{ $item->peminjaman->anggota->kode_anggota }}
                            </small>

                            <hr>

                            <div class="mt-3">

                                @if($item->peminjaman->anggota->status == 'Aktif')
                                    <span class="badge bg-success px-3 py-2 rounded-pill">
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill">
                                        Tidak Aktif
                                    </span>
                                @endif

                            </div>

                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                   <div class="col-lg-8">
                        <div class="card border-0 shadow-sm rounded-4 p-4">
                            <h5 class="mb-4"> 📌 Informasi Pengembalian  </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Kode Peminjaman</small>
                                        <div class="fw-bold">
                                            {{ $item->peminjaman->kode_peminjaman }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Nama Anggota</small>
                                        <div class="fw-bold">
                                            {{ $item->peminjaman->anggota->nama }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Tanggal Pinjam</small>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pinjam)->format('d-m-Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Batas Kembali</small>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($item->peminjaman->batas_kembali)->format('d-m-Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Tanggal Kembali</small>
                                        <div class="fw-bold">
                                            {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="info-box">
                                        <small>Status Pengembalian</small>

                                        <div class="mt-2">

                                            @if($item->status_pengembalian == 'Tepat Waktu')
                                                <span class="badge bg-success px-3 py-2 rounded-pill">
                                                    Tepat Waktu
                                                </span>
                                            @else
                                                <span class="badge bg-danger px-3 py-2 rounded-pill">
                                                    Terlambat
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DAFTAR BUKU --}}
                        <div class="card border-0 shadow-sm rounded-4 p-4 mt-4">
                            <h5 class="mb-4">📚 Daftar Buku</h5>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="8%" class="text-center"> No </th>
                                            <th> Judul Buku </th>
                                            <th width="15%" class="text-center">Jumlah </th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @forelse($item->peminjaman->details as $detail)

                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>
                                                    <div class="fw-semibold">
                                                        {{ $detail->buku->judul_buku }}
                                                    </div>

                                                    <small class="text-muted">
                                                        {{ $detail->buku->kode_buku }}
                                                    </small>
                                                </td>

                                                <td class="text-center">
                                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                                        {{ $detail->jumlah }}
                                                    </span>
                                                </td>

                                            </tr>

                                        @empty

                                            <tr>
                                                <td colspan="3" class="text-center text-muted py-4">
                                                    Tidak ada data buku
                                                </td>
                                            </tr>

                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer border-0 p-3">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endforeach