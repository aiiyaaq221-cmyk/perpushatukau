<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Pengunjung;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Buku
        $totalBuku = Buku::sum('jumlah_buku');

        // Statistik Anggota
        $totalAnggota = Anggota::count();

        // Pengunjung Hari Ini
        $pengunjungHariIni = Pengunjung::whereDate(
            'tanggal_kunjungan',
            Carbon::today()
        )->count();

        // Pengunjung Minggu Ini
        $kunjunganMinggu = Pengunjung::whereBetween(
            'tanggal_kunjungan',
            [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ]
        )->count();

        // Statistik Peminjaman
        $totalPeminjaman = Peminjaman::count();

        $peminjamanAktif = Peminjaman::where(
            'status',
            'Dipinjam'
        )->count();

        $totalPengembalian = Pengembalian::count();

        // Pengunjung Terbaru
        $pengunjungTerbaru = Pengunjung::with('anggota')
        ->latest('tanggal_kunjungan')
        ->take(10)
        ->get();

        // TAMBAHKAN DI SINI
        $peminjamanTerbaru = Peminjaman::with([
            'anggota',
            'details'
        ])
        ->latest()
        ->take(10)
        ->get();

        // Grafik Bulanan
        $grafik = [];

        for ($i = 1; $i <= 12; $i++) {

            $grafik[] = Pengunjung::whereYear(
                'tanggal_kunjungan',
                date('Y')
            )
            ->whereMonth(
                'tanggal_kunjungan',
                $i
            )
            ->count();
        }

        $totalTahunIni = array_sum($grafik);

        $bulanLabels = [
            'Jan','Feb','Mar','Apr',
            'Mei','Jun','Jul','Agu',
            'Sep','Okt','Nov','Des'
        ];

        $nilaiTertinggi = max($grafik);

        $indexTertinggi = array_search(
            $nilaiTertinggi,
            $grafik
        );

        $bulanTertinggi = $bulanLabels[$indexTertinggi];

        return view('dashboard', compact(
            'totalBuku',
            'totalAnggota',
            'pengunjungHariIni',
            'kunjunganMinggu',

            'totalPeminjaman',
            'peminjamanAktif',
            'totalPengembalian',

            'pengunjungTerbaru',
            'peminjamanTerbaru',

            'grafik',
            'totalTahunIni',
            'bulanTertinggi',
            'nilaiTertinggi'
        ));
    }
}