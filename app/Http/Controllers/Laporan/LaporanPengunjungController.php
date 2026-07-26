<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Exports\PengunjungExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;    
use Carbon\Carbon;

class LaporanPengunjungController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengunjung::with('anggota');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Rentang Bulan
        if ($request->filled('bulan_awal') && $request->filled('bulan_akhir')) {
            $tahun = $request->tahun ?? now()->year;

            $tanggalAwal = Carbon::create( $tahun, $request->bulan_awal, 1)->startOfMonth();

            $tanggalAkhir = Carbon::create($tahun, $request->bulan_akhir, 1 )->endOfMonth();

            $query->whereBetween(
                'tanggal_kunjungan', [ $tanggalAwal, $tanggalAkhir ]
            );
        }

        if ($request->filled('status')) {

            if ($request->status == 'anggota') {
                $query->whereNotNull('id_anggota');
            }

            if ($request->status == 'umum') {
                $query->whereNull('id_anggota');
            }
        }

        $statistikQuery = clone $query;

        // tabel
        $pengunjungs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPengunjung = Pengunjung::count();

        $hariIni = Pengunjung::whereDate(
            'tanggal_kunjungan',
            now()
        )->count();

        $anggota = Pengunjung::whereNotNull('id_anggota')->count();

        $umum = Pengunjung::whereNull('id_anggota')->count();

        // total filter usia
        $usia = collect();

        foreach ($statistikQuery->get() as $item) {
            $umur = $item->anggota?->umur ?? $item->umur;

            if ($umur) {
                $usia->push($umur);
            }
        }

        $usiaTerbanyak = $usia
            ->countBy()
            ->sortDesc();

        $umurTerbanyak = $usiaTerbanyak->keys()->first();

        $totalUmur = $usiaTerbanyak->first();

        return view(
            'laporan.pengunjung',
            compact(
                'pengunjungs',
                'totalPengunjung',
                'hariIni',
                'anggota',
                'umum',
                'umurTerbanyak',
                'totalUmur'
            )
        );
    }

   public function exportExcel(Request $request)
    {
        return Excel::download(
            new PengunjungExport($request),
            'laporan_pengunjung.xlsx'
        );
    }


    public function exportPdf(Request $request)
    {
        Carbon::setLocale('id');

        $query = Pengunjung::with('anggota');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('alamat', 'like', '%' . $request->search . '%');
            });
        }

        
        // Filter Rentang Bulan
        if ($request->filled('bulan_awal') && $request->filled('bulan_akhir')) {
            $tahun = $request->tahun ?? now()->year;

            $tanggalAwal = Carbon::create( $tahun, $request->bulan_awal, 1)->startOfMonth();

            $tanggalAkhir = Carbon::create($tahun, $request->bulan_akhir, 1 )->endOfMonth();

            $query->whereBetween(
                'tanggal_kunjungan', [ $tanggalAwal, $tanggalAkhir ]
            );
        }

        $pengunjungs = $query->latest()->get();

        $tanggalCetak = Carbon::now('Asia/Jayapura')->translatedFormat('d F Y');
        $jamCetak = Carbon::now('Asia/Jayapura')->format('H:i');
        $jumlahData = $pengunjungs->count();

        $pdf = PDF::loadView(
            'laporan.pdf.pengunjung',
            compact(
                'pengunjungs',
                'tanggalCetak',
                'jamCetak',
                'jumlahData'
            )
        );

        return $pdf->download('laporan-pengunjung.pdf');
    }
}