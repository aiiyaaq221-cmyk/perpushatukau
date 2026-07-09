<div class="modal fade"
     id="detail{{ $item->id_peminjaman }}"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Peminjaman
                </h5>

                <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>Kode</th>
                        <td>{{ $item->kode_peminjaman }}</td>
                    </tr>

                    <tr>
                        <th>Anggota</th>
                        <td>{{ $item->anggota->nama }}</td>
                    </tr>

                    <tr>
                        <th>Tanggal Pinjam</th>
                        <td>{{ $item->tanggal_pinjam }}</td>
                    </tr>

                    <tr>
                        <th>Batas Kembali</th>
                        <td>{{ $item->batas_kembali }}</td>
                    </tr>

                </table>
                <hr>

                <h6>Daftar Buku</h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($item->details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->buku->judul_buku }}</td>
                            <td>{{ $detail->jumlah }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>