@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/laporan/peminjaman.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container-fluid pt-1 pb-4">
    <div class="header-card mb-4">
        <div class="page-header">
            <div class="page-info">
                <h2 class="page-title"> 📚 Laporan Peminjaman </h2>
                <p class="page-subtitle">  Data seluruh transaksi peminjaman buku </p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('laporan.peminjaman.excel') }}" class="btn btn-success btn-modern-export"> 📊 Export Excel </a>
                <a href="{{ route('laporan.peminjaman.pdf') }}" class="btn btn-danger btn-modern-export"> 📄 Export PDF </a>
            </div>
        </div>
    </div>


    <!-- STATISTIK -->
    <div class="row mb-2">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card warning">
                <div class="card-body">
                    <small>Total Peminjaman</small>
                    <h2 class="fw-bold">
                        {{ $totalPeminjaman }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card primary">
                <div class="card-body">
                    <small>Sedang Dipinjam</small>
                    <h2 class="fw-bold">
                        {{ $dipinjam }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card success">
                <div class="card-body">
                    <small>Dikembalikan</small>
                    <h2 class="fw-bold">
                        {{ $dikembalikan }}
                    </h2>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card danger">
                <div class="card-body">
                    <small>Terlambat</small>
                    <h2 class="fw-bold">
                        {{ $terlambat }}
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- FILTER -->
    <div class="card border-0 shadow-sm mb-4 filter-card">
        <div class="card-body">
            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-5">
                        <label>Nama Peminjam</label>
                        <input type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Cari nama anggota..."
                            value="{{ request('nama') }}"
                            onkeyup="this.form.submit()">
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal Pengembalian</label>
                        <input type="date"
                            name="tanggal"
                            class="form-control"
                            value="{{ request('tanggal') }}">
                    </div>

                    <div class="col-md-2">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="Dipinjam" {{ request('status')=='Dipinjam'?'selected':'' }}>
                                Dipinjam
                            </option>
                            <option value="Dikembalikan" {{ request('status')=='Dikembalikan'?'selected':'' }}>
                                Dikembalikan
                            </option>
                            <option value="Terlambat" {{ request('status')=='Terlambat'?'selected':'' }}>
                                Terlambat
                            </option>
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end gap-2">

                        <button class="btn btn-primary flex-fill">
                            <i class="fas fa-search"></i> 
                        </button>

                        @if(request()->hasAny(['nama','tanggal','status']))
                            <a href="{{ route('laporan.peminjaman') }}"
                            class="btn btn-secondary">
                                Reset
                            </a>
                        @endif

                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- TABLE -->
    <div class="modern-card" id="tableData" >
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Data Peminjaman</h5>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table modern-table">
                <thead>
                    <tr>
                    <th  >No</th>
                    <th  >Kode</th>
                    <th  >Anggota</th>
                    <th >Buku</th>
                    <th >Pinjam</th>
                    <th  >Batas</th>
                    <th  >Durasi</th>
                    <th >Status</th>
                    <th  >Keterangan</th>
                    </tr>
                </thead>
            <tbody>

                @forelse($peminjamans as $item)
                    <tr>
                        <td class="text-center"> {{ $loop->iteration+($peminjamans->firstItem()-1) }} </td>
                        <td>
                            <div class="fw-bold text-primary">
                                {{ $item->kode_peminjaman }}
                            </div>
                        </td>
                        <td>
                            <div class="fw-semibold nama-anggota">
                                {{ $item->anggota->nama??'-' }}
                            </div>
                        </td>
                        <td>
                            <div class="book-items">
                                {{-- 2 buku pertama --}}
                                @foreach($item->details->take(2) as $detail)
                                    <div class="book-item">
                                        <i class="fas fa-book"></i>
                                        <span>{{ $detail->buku->judul_buku }}</span>
                                        @if($detail->jumlah > 1)
                                            <small>×{{ $detail->jumlah }}</small>
                                        @endif
                                    </div>
                                @endforeach

                                {{-- Buku sisanya --}}
                                @if($item->details->count() > 2)
                                    <div
                                        id="moreBooks{{ $item->id_peminjaman }}"
                                        class="more-books"
                                        style="display:none;">

                                        @foreach($item->details->skip(2) as $detail)

                                            <div class="book-item">
                                                <i class="fas fa-book"></i>
                                                <span>{{ $detail->buku->judul_buku }}</span>

                                                @if($detail->jumlah > 1)
                                                    <small>×{{ $detail->jumlah }}</small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <small
                                        class="toggle-books"
                                        data-target="moreBooks{{ $item->id_peminjaman }}"
                                        data-count="{{ $item->details->count()-2 }}">
                                        +{{ $item->details->count()-2 }} lainnya
                                    </small>
                                @endif
                            </div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->translatedFormat('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->batas_kembali)->translatedFormat('d M Y') }}</td>
                        <td class="text-center"> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->diffInDays($item->batas_kembali) }} Hari </td>
                        <td class="text-center">
                            @if($item->tanggal_kembali)

                                <span class="badge bg-success">
                                    Dikembalikan
                                </span>

                            @elseif(\Carbon\Carbon::parse($item->batas_kembali)->isPast())

                                <span class="badge bg-danger">
                                    Terlambat
                                </span>

                            @else

                                <span class="badge bg-primary">
                                    Dipinjam
                                </span>

                            @endif

                            </td>
                        <td> {{ $item->keterangan??'-' }} </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="8">
                            <div class="empty-data text-center py-5">
                                <div style="font-size:60px">📚</div>
                                <h5 class="mt-3">Data Peminjaman Kosong</h5>
                                <p class="text-muted mb-0">
                                Belum ada data peminjaman.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap">
            <small class="text-muted">
            Menampilkan {{ $peminjamans->firstItem()??0 }} - {{ $peminjamans->lastItem()??0 }} dari {{ $peminjamans->total() }} data
            </small>
            {{ $peminjamans->fragment('tableData')->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@endsection
