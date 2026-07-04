<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Pengunjung;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Greeting
        |--------------------------------------------------------------------------
        */

        $jam = Carbon::now('Asia/Jayapura')->hour;

        if ($jam < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($jam < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($jam < 18) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }

        /*
        |--------------------------------------------------------------------------
        | Statistik
        |--------------------------------------------------------------------------
        */

        $totalBuku = Buku::sum('jumlah_buku');

        $totalAnggota = Anggota::count();

        $totalPengunjung = Pengunjung::count();

        $pengunjungHariIni = Pengunjung::whereDate(
            'tanggal_kunjungan',
            today()
        )->count();

        $kunjunganMinggu = Pengunjung::whereBetween(
            'tanggal_kunjungan',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->count();

        $totalPeminjaman = Peminjaman::count();

        $peminjamanAktif = Peminjaman::whereNull(
            'tanggal_kembali'
        )->count();

        $totalPengembalian = Pengembalian::count();

        $terlambat = Peminjaman::whereNull('tanggal_kembali')
            ->whereDate('batas_kembali', '<', today())
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Hari Ini
        |--------------------------------------------------------------------------
        */

        $pinjamHariIni = Peminjaman::whereDate(
            'tanggal_pinjam',
            today()
        )->count();

        $kembaliHariIni = Pengembalian::whereDate(
            'tanggal_kembali',
            today()
        )->count();

        /*
        |--------------------------------------------------------------------------
        | Buku Hampir Habis
        |--------------------------------------------------------------------------
        */

        $bukuMenipis = Buku::where('stok_tersedia', '<=', 3)
            ->orderBy('stok_tersedia')
            ->orderBy('judul_buku')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Pengunjung Terbaru
        |--------------------------------------------------------------------------
        */

        $pengunjungTerbaru = Pengunjung::with('anggota')
            ->latest('tanggal_kunjungan')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Peminjaman Terbaru
        |--------------------------------------------------------------------------
        */

        $peminjamanTerbaru = Peminjaman::with([
            'anggota',
            'details.buku'
        ])
        ->orderByRaw("
            CASE
                WHEN tanggal_kembali IS NULL
                THEN 1
                ELSE 2
            END
        ")
        ->latest()
        ->take(5)
        ->get();

        // ===========================
        // Statistik Buku
        // ===========================

        $totalBuku = Buku::sum('jumlah_buku');

        $stokAman = Buku::where('stok_tersedia', '>', 5)->count();

        $stokMenipis = Buku::whereBetween('stok_tersedia', [1, 5])->count();

        $stokHabis = Buku::where('stok_tersedia', 0)->count();

        // ===================================
        // Grafik Dashboard
        // ===================================

        $grafikPengunjung = [];
        $grafikPinjam = [];
        $grafikKembali = [];

        for ($i = 1; $i <= 12; $i++) {

            $grafikPengunjung[] = Pengunjung::whereYear(
                'tanggal_kunjungan',
                Carbon::now()->year
            )
            ->whereMonth(
                'tanggal_kunjungan',
                $i
            )
            ->count();

            $grafikPinjam[] = Peminjaman::whereYear(
                'tanggal_pinjam',
                Carbon::now()->year
            )
            ->whereMonth(
                'tanggal_pinjam',
                $i
            )
            ->count();

            $grafikKembali[] = Pengembalian::whereYear(
                'tanggal_kembali',
                Carbon::now()->year
            )
            ->whereMonth(
                'tanggal_kembali',
                $i
            )
            ->count();

        }

        // ===================================
        // Ringkasan Grafik
        // ===================================

        $totalBulanIni = Pengunjung::whereYear(
            'tanggal_kunjungan',
            Carbon::now()->year
        )
        ->whereMonth(
            'tanggal_kunjungan',
            Carbon::now()->month
        )
        ->count();

        $bulan = [
            'Jan','Feb','Mar','Apr',
            'Mei','Jun','Jul','Agu',
            'Sep','Okt','Nov','Des'
        ];

        $nilaiTertinggi = max($grafikPengunjung);

        $bulanTertinggi = $bulan[
            array_search(
                $nilaiTertinggi,
                $grafikPengunjung
            )
        ];

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Dashboard
        |--------------------------------------------------------------------------
        */

        $notifikasi = [];

        if ($terlambat > 0) {
            $notifikasi[] = [
                'warna' => 'danger',
                'icon'  => 'fa-clock',
                'text'  => $terlambat . ' peminjaman terlambat'
            ];
        }

        if ($bukuMenipis->count() > 0) {
            $notifikasi[] = [
                'warna' => 'warning',
                'icon'  => 'fa-book',
                'text'  => $bukuMenipis->count() . ' buku hampir habis'
            ];
        }

        if ($pinjamHariIni > 0) {
            $notifikasi[] = [
                'warna' => 'primary',
                'icon'  => 'fa-book-open',
                'text'  => $pinjamHariIni . ' peminjaman hari ini'
            ];
        }

        if ($kembaliHariIni > 0) {
            $notifikasi[] = [
                'warna' => 'success',
                'icon'  => 'fa-rotate-left',
                'text'  => $kembaliHariIni . ' pengembalian hari ini'
            ];
        }

        // ===================================
        // Aktivitas Hari Ini
        // ===================================

        $pinjamHariIni = Peminjaman::whereDate(
            'tanggal_pinjam',
            Carbon::today()
        )->count();

        $kembaliHariIni = Pengembalian::whereDate(
            'tanggal_kembali',
            Carbon::today()
        )->count();

        $terlambat = Peminjaman::whereNull('tanggal_kembali')
            ->whereDate('batas_kembali','<',Carbon::today())
            ->count();
            
        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(
        'totalBuku',
        'totalAnggota',
        'pengunjungHariIni',
        'kunjunganMinggu',

        'totalPeminjaman',
        'peminjamanAktif',
        'totalPengembalian',

        'stokAman',
        'stokMenipis',
        'stokHabis',

        'pengunjungTerbaru',
        'peminjamanTerbaru',

        'grafikPengunjung',
        'grafikPinjam',
        'grafikKembali',

        'pinjamHariIni',
        'kembaliHariIni',
        'pengunjungHariIni',
        'terlambat',


        'totalBulanIni',
        'bulanTertinggi',
        'nilaiTertinggi'
        ));
    }
}