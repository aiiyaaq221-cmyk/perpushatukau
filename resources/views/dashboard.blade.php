@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<div class="container-fluid py-3">
    <div class="dashboard-welcome mb-3">
        <div class="dashboard-welcome-left">
            <h2>👋 Hello, {{ Auth::user()->name }}</h2>
            <p>
                Selamat datang di Sistem Informasi
                Perpustakaan Hatukau Negeri Batumerah.
            </p>
        </div>

        <div class="dashboard-welcome-right">
            <h5>{{ now()->translatedFormat('l') }}</h5>
            <span>{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    <!-- =====================================
     QUICK ACTION
    ===================================== -->
    <div class="dashboard-quick-action">
        <a href="{{ route('master.buku.index') }}" class="dashboard-quick-btn">
            <div class="dashboard-quick-icon dashboard-blue">
                <i class="fas fa-book"></i>
            </div>
            <span>Data Buku</span>
        </a>

        <a href="{{ route('master.anggota.index') }}" class="dashboard-quick-btn">
            <div class="dashboard-quick-icon dashboard-green">
                <i class="fas fa-users"></i>
            </div>
            <span>Data Anggota</span>
        </a>

        <a href="{{ route('transaksi.peminjaman.index') }}" class="dashboard-quick-btn">
            <div class="dashboard-quick-icon dashboard-orange">
                <i class="fas fa-hand-holding"></i>
            </div>
            <span>Peminjaman</span>
        </a>

        <a href="{{ route('pengunjung.index') }}" class="dashboard-quick-btn">
            <div class="dashboard-quick-icon dashboard-purple">
                <i class="fas fa-door-open"></i>
            </div>
            <span>Pengunjung</span>
        </a>

    </div>

    <!-- =====================================
     AKTIVITAS HARI INI
    ===================================== -->
    <div class="dashboard-activity-card">
        <h3 class="dashboard-activity-title">
            Aktivitas Hari Ini
        </h3>
        <div class="activity-list">
            <div class="dashboard-activity-item">
                <div class="dashboard-activity-icon dashboard-blue">
                    <i class="fas fa-book-reader"></i>
                </div>

                <div class="dashboard-activity-content">
                    <h6>
                        {{ $pinjamHariIni }}
                        Peminjaman
                    </h6>

                    <small>
                        Transaksi peminjaman hari ini
                    </small>
                </div>
            </div>

            <div class="dashboard-activity-item">
                <div class="dashboard-activity-icon dashboard-green">
                    <i class="fas fa-undo-alt"></i>
                </div>

                <div class="dashboard-activity-content">
                    <h6>
                        {{ $kembaliHariIni }}
                        Pengembalian
                    </h6>

                    <small>
                        Buku berhasil dikembalikan
                    </small>
                </div>
            </div>

            <div class="dashboard-activity-item">
                <div class="dashboard-activity-icon dashboard-yellow">
                    <i class="fas fa-user-check"></i>
                </div>

                <div class="dashboard-activity-content">
                    <h6>
                        {{ $pengunjungHariIni }}
                        Pengunjung
                    </h6>

                    <small>
                        Pengunjung perpustakaan hari ini
                    </small>
                </div>
            </div>

            <div class="dashboard-activity-item">
                <div class="dashboard-activity-icon dashboard-red">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="dashboard-activity-content">
                    <h6>
                        {{ $terlambat }}
                        Buku Terlambat
                    </h6>

                    <small>
                        Belum dikembalikan
                    </small>
                </div>
            </div>
        </div>
    </div>

    {{-- CARD --}}
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">
                <div class="dashboard-info-icon dashboard-blue">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="dashboard-info-content">
                    <span>Jumlah Buku</span>
                    <h3>{{ $stokTersedia }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">
                <div class="dashboard-info-icon dashboard-green">
                    <i class="fas fa-users"></i>
                </div>
                <div class="dashboard-info-content">
                    <span>Total Anggota</span>
                    <h3>{{ $totalAnggota }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">                
                <div class="dashboard-info-icon dashboard-purple-light">
                    <i class="fas fa-users"></i>
                </div>

                <div class="dashboard-info-content">
                    <span>kategori</span>
                    <h3>{{ $totalKategori }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">
                <div class="dashboard-info-icon dashboard-red">
                    <i class="fas fa-book-reader"></i>
                </div>
                <div class="dashboard-info-content">
                    <span>Total Peminjaman</span>
                    <h3>{{ $totalPeminjaman }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">
                <div class="dashboard-info-icon dashboard-blue-light">
                    <i class="fas fa-bookmark"></i>
                </div>

                <div class="dashboard-info-content">
                    <span>Peminjaman Aktif</span>
                    <h3>{{ $peminjamanAktif }}</h3>
                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">

                <div class="dashboard-info-icon dashboard-red-light">
                    <i class="fas fa-clock"></i>
                </div>

                <div class="dashboard-info-content">
                    <span>Terlambat</span>
                    <h3>{{ $terlambat }}</h3>
                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">

                <div class="dashboard-info-icon dashboard-green-light">
                    <i class="fas fa-undo"></i>
                </div>

                <div class="dashboard-info-content">
                    <span>Pengembalian</span>
                    <h3>{{ $totalPengembalian }}</h3>
                </div>

            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="dashboard-info-card">
                <div class="dashboard-info-icon dashboard-orange">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="dashboard-info-content">
                    <span>Pengunjung Hari Ini</span>
                    <h3>{{ $pengunjungHariIni }}</h3>
                </div>
            </div>
        </div>

    </div>


     {{-- =========================================
        GRAFIK AKTIVITAS PERPUSTAKAAN
    ========================================= --}}
    <div class="dashboard-card mb-4">
         <div class="dashboard-card-header">
            <div>
                <h4>Grafik Aktivitas Perpustakaan</h4>
                <small>
                    Tahun {{ date('Y') }}
                </small>
            </div>

            <div class="dashboard-chart-summary">
                <div class="dashboard-summary-box">
                    <span>Bulan Ini</span>
                    <strong>{{ $totalBulanIni }}</strong>
                </div>

               <div class="dashboard-summary-box">
                    <span>Tertinggi</span>
                    <strong>{{ $bulanTertinggi }}</strong>
                </div>
            </div>
        </div>

        <div class="dashboard-chart-box">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>


    {{-- =========================================
        INFORMASI TERBARU
    ========================================= --}}
    <div class="row g-4">
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card h-100">
                <div class="dashboard-table-header">
                    <div>
                        <h5 class="dashboard-table-title">
                            <i class="fas fa-users text-warning me-2"></i>
                            Pengunjung Terbaru
                        </h5>

                        <small class="dashboard-table-subtitle">
                            {{ $pengunjungTerbaru->count() }}
                            data kunjungan terbaru
                        </small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tujuan</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($pengunjungTerbaru as $item)
                            <tr>
                                <td> {{ Str::limit($item->nama,18) }} </td>
                                <td>{{ Str::limit($item->tujuan,15) }}</td>
                                <td>
                                    <span class="dashboard-badge dashboard-badge-date">
                                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M') }}
                                    </span>
                                </td>
                            </tr>

                            @empty

                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Belum ada data
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- ===========================
            PEMINJAMAN TERBARU
        ============================ --}}
        <div class="col-xl-4 col-lg-6">
            <div class="dashboard-card h-100">
                <div class="table-header">
                    <div>
                        <h5 class="dashboard-table-title">
                            <i class="fas fa-book-open text-primary me-2"></i>
                            Peminjaman Terbaru
                        </h5>
                        <small class="dashboard-table-subtitle">
                            {{ $peminjamanTerbaru->count() }}
                            transaksi terbaru
                        </small>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($peminjamanTerbaru as $item)
                            <tr>
                                <td> {{ Str::limit($item->anggota->nama,15) }}</td>
                                <td>{{ $item->details->sum('jumlah') }} </td>
                                <td>
                                    @php

                                        $status =
                                            is_null($item->tanggal_kembali)
                                            ? (
                                                now()->gt($item->batas_kembali)
                                                ? 'Terlambat'
                                                : 'Dipinjam'
                                            )
                                            : 'Dikembalikan';

                                    @endphp

                                    @if($status=='Dipinjam')
                                        <span class="dashboard-badge dashboard-badge-primary">
                                            Dipinjam
                                        </span>

                                    @elseif($status=='Dikembalikan')

                                        <span class="dashboard-badge dashboard-badge-success">
                                            Kembali
                                        </span>
                                    @else

                                        <span class="dashboard-badge dashboard-badge-danger">
                                            Terlambat
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            @empty

                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    Belum ada data
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- ===========================
            STATUS STOK BUKU
        ============================ --}}
        <div class="col-xl-4">
            <div class="dashboard-card h-100">
                <div class="table-header">
                    <div>
                        <h5 class="dashboard-table-title">
                            <i class="fas fa-box-open text-success me-2"></i>
                            Status Stok Buku
                        </h5>
                            <small class="dashboard-table-subtitle"> Ringkasan stok koleksi</small>
                    </div>
                </div>

                <div class="dashboard-stock-card">
                    <div class="dashboard-stock-row">
                        <div>
                            <div class="dashboard-stock-title">
                                <i class="fas fa-check-circle text-success"></i>
                                Stok Aman
                            </div>
                            <small>Lebih dari 5 buku</small>
                        </div>
                        <strong>{{ $stokAman }} </strong>
                    </div>
                    <div class="progress dashboard-progress">
                        <div class="progress-bar bg-success"
                            style="width:100%">
                        </div>
                    </div>
                </div>

                <div class="stock-card mt-4">
                    <div class="dashboard-stock-row">
                        <div>
                            <div class="dashboard-stock-title">
                                <i class="fas fa-exclamation-circle text-warning"></i>
                                Stok Menipis
                            </div>
                            <small>1 - 5 buku</small>
                        </div>
                        <strong>
                            {{ $stokMenipis }}
                        </strong>
                    </div>

                    <div class="progress dashboard-progress">
                        <div class="progress-bar bg-warning"
                            style="width:65%">
                        </div>
                    </div>
                </div>

                <div class="stock-card mt-4">
                    <div class="dashboard-stock-row">
                        <div>
                            <div class="stock-title">
                                <i class="fas fa-times-circle text-danger"></i>
                                Stok Habis
                            </div>
                            <small>0 buku</small>
                        </div>

                        <strong>
                            {{ $stokHabis }}
                        </strong>
                    </div>

                    <div class="progress dashboard-progress">
                        <div class="progress-bar bg-danger"
                            style="width:35%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("visitorChart");
    new Chart(ctx, {
        type: "bar",
        data: {

            labels: [
                "Jan","Feb","Mar","Apr",
                "Mei","Jun","Jul","Agu",
                "Sep","Okt","Nov","Des"
            ],

            datasets: [
                {
                    label: "Pengunjung",
                    data: @json($grafikPengunjung),
                    backgroundColor: "#F59E0B",

                    borderRadius: 0,
                    borderSkipped: false,

                    barThickness: 12,
                    maxBarThickness: 12,

                    categoryPercentage: .75,
                    barPercentage: .85
                },

                {
                    label: "Peminjaman",
                    data: @json($grafikPinjam),
                    backgroundColor: "#2563EB",

                    borderRadius: 1,
                    borderSkipped: false,

                    barThickness: 12,
                    maxBarThickness: 12,

                    categoryPercentage: .75,
                    barPercentage: .85
                },

                {
                    label: "Pengembalian",
                    data: @json($grafikKembali),
                    backgroundColor: "#22C55E",
                    borderRadius: 0,
                    borderSkipped: false,
                    barThickness: 12,
                    maxBarThickness: 12,
                    categoryPercentage: .75,
                    barPercentage: .85
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 1200,
                easing: "easeOutQuart"
            },

            interaction: {
                mode: "index",
                intersect: false
            },

            plugins: {
                legend: {
                    position: "top",
                    labels: {
                        usePointStyle: true,
                        pointStyle: "circle",
                        boxWidth: 8,
                        boxHeight: 8,
                        padding: 20,
                        color: "#475569",
                        font: {
                            size: 13,
                            weight: "600"
                        }
                    }
                },

                tooltip: {
                    backgroundColor: "#1E293B",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    cornerRadius: 10,
                    padding: 12,
                    displayColors: true,
                    titleFont: {
                        size: 14,
                        weight: "bold"
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },

            layout: {
                padding: {
                    top: 10,
                    left: 10,
                    right: 15,
                    bottom: 0
                }
            },

            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },

                    ticks: {
                        color: "#64748B",
                        font: {
                            size: 12,
                            weight: "500"
                        }
                    }
                },

                y: {
                    beginAtZero: true,
                    grace: "15%",
                    ticks: {
                        stepSize: 5,
                        color: "#64748B",
                        font: {
                            size: 12
                        }
                    },

                    grid: {
                        drawBorder: false,
                        color: "rgba(148,163,184,.18)"
                    }
                }
            }
        }
    });
});
</script>
@endpush