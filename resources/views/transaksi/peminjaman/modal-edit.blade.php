<div class="modal fade"
     id="edit{{ $item->id_peminjaman }}"
     tabindex="-1">

    <div class="modal-dialog">

        <form
            action="{{ route('transaksi.peminjaman.update', $item->id_peminjaman) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Edit Peminjaman
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Anggota
                        </label>

                        <select
                            name="id_anggota"
                            class="form-select">

                            @foreach($anggotas as $anggota)

                            <option
                                value="{{ $anggota->id_anggota }}"
                                {{ $item->id_anggota == $anggota->id_anggota ? 'selected' : '' }}>

                                {{ $anggota->nama }}

                            </option>

                            @endforeach

                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            Batas Kembali
                        </label>

                        <input
                            type="date"
                            name="batas_kembali"
                            class="form-control"
                            value="{{ $item->batas_kembali }}">
                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Keterangan
                        </label>

                        <textarea
                            name="keterangan"
                            class="form-control">{{ $item->keterangan }}</textarea>
                    </div>
                </div>

                <div class="modal-footer">
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