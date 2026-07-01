@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')

<div class="container-fluid py-4">

    <!-- Welcome Card -->
    <div class="welcome-card mb-4">

        <div>
            <h1>
                Hello {{ Auth::user()->name ?? 'Admin' }}!
            </h1>
            <p> Selamat datang di Sistem Informasi
                Perpustakaan Hatukau Negeri Batumerah </p>
        </div>

        <!-- <div>
            <img
                src="{{ asset('images/reading.png') }}"
                alt="Reading">
        </div> -->
    </div>

    <!-- Statistik -->
    <div class="stat-row">
        <div class="stat-card blue">
            <small>Total Buku</small>
                <h2>  {{ $totalBuku }}  </h2>
        </div>

        <div class="stat-card green">
            <small>Total Anggota</small>
                <h2> {{ $totalAnggota }}  </h2>
        </div>

        <div class="stat-card yellow">
            <small>Pengunjung Hari Ini</small>
                <h2> {{ $pengunjungHariIni }}  </h2>
        </div>

        <div class="stat-card red">
            <small>Total Peminjaman</small>
            <h2>{{ $totalPeminjaman }}</h2>
        </div>
    </div>

    <!-- Grafik -->
    <div class="chart-card">
        <div class="chart-header">
            <h3> Grafik Kunjungan Per Bulan  </h3>
            <span class="chart-subtitle">
                Statistik Pengunjung Tahun {{ date('Y') }}
            </span>
        </div>

        <div class="chart-summary">
            <div class="summary-item">
                <span>Total Bulan Ini</span>
                <h4>{{ $totalBulanIni }}</h4>
            </div>
            <div class="summary-item">
                <span>Bulan Tertinggi</span>
                <h4>{{ $bulanTertinggi }} </h4>
            </div>
            <div class="summary-item">
                <span>Kunjungan Tertinggi</span>
                <h4>{{ $nilaiTertinggi }}</h4>
            </div>
        </div>

        <div class="chart-wrapper">
            <canvas id="visitorChart"></canvas>
        </div>
    </div>

    <!-- Tabel -->
    <div class="table-card">
        <h3> Tabel Kunjungan Terbaru</h3>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pengunjung</th>
                        <th>Alamat</th>
                        <th>Status/Jabatan</th>
                        <th>Maksud & Tujuan</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pengunjungTerbaru as $item)
                    <tr>
                        <td> {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d-m-Y') }}  </td>
                        <td> {{ $item->nama }}  </td>
                        <td> {{ $item->alamat }}  </td>
                        <td>
                            @if($item->jenis_pengunjung == 'anggota')

                                <span class="badge bg-success">
                                    {{ $item->anggota->status ?? 'Aktif' }}
                                </span>
                            @else

                                <span class="badge bg-secondary">
                                    {{ $item->status_pengunjung }}
                                </span>

                            @endif
                        </td>
                        <td> {{ $item->tujuan }}</td>

                        <td>
                            @if($item->jenis_kelamin == 'Laki-laki')
                                <span class="gender male">
                                    Laki-laki
                                </span>
                            @else
                                <span class="gender female">
                                    Perempuan
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Belum ada data pengunjung
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

        <div class="table-card mt-4">
        <h3> 📖 Peminjaman Terbaru </h3>
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Anggota</th>
                        <th>Tanggal Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Total Buku</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($peminjamanTerbaru as $item)

                    <tr>
                        <td> {{ $item->kode_peminjaman }}</td>
                        <td> {{ $item->anggota->nama }} </td>
                        <td> {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') }}</td>
                        <td> {{ \Carbon\Carbon::parse($item->batas_kembali)->format('d-m-Y') }}</td>
                        <td> {{ $item->details->sum('jumlah') }}</td>

                        <td>
                            @if($item->status == 'Dipinjam')
                                <span class="badge bg-primary">
                                    Dipinjam
                                </span>

                            @elseif($item->status == 'Dikembalikan')
                                <span class="badge bg-success">
                                    Dikembalikan
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Terlambat
                                </span>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data peminjaman
                        </td>
                    </tr>

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx =
        document.getElementById('visitorChart');

    new Chart(ctx, {

        type: 'line',

        data: {

            labels: [
                'Jan','Feb','Mar','Apr',
                'Mei','Jun','Jul','Agu',
                'Sep','Okt','Nov','Des'
            ],

            datasets: [{
                label: 'Jumlah Pengunjung',
                data: @json($grafik),
                borderColor:'#E9930A',
                backgroundColor:
                    'rgba(233,147,10,0.15)',
                fill:true,
                tension:0.4,
                borderWidth:4,
                pointRadius:6,
                pointHoverRadius:10,
                pointBackgroundColor:'#fff',
                pointBorderColor:'#E9930A',
                pointBorderWidth:3
            }]
        },

        options: {
            responsive:true,
            maintainAspectRatio:false,
            interaction:{
                intersect:false,
                mode:'index'
            },
            plugins:{
                legend:{
                    display:false
                },
                tooltip:{
                    backgroundColor:'#1F2937',
                    titleColor:'#fff',
                    bodyColor:'#fff',
                    padding:12,
                    callbacks:{
                        label:function(context){
                            return context.parsed.y +
                                ' Pengunjung';
                        }
                    }
                }
            },

            scales:{
                y:{
                    beginAtZero:true,
                    ticks:{
                        stepSize:10
                    }
                },

                x:{
                    grid:{
                        display:false
                    }
                }
            }
        }
    });
});
</script>
@endpush