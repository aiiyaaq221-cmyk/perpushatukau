<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'pengembalian'
        ]);

        // Filter Nama Anggota
       if ($request->filled('nama')) {

            $query->whereHas('anggota', function ($q) use ($request) {

                $q->where(
                    'nama',
                    'LIKE',
                    '%' . trim($request->nama) . '%'
                );
            });
        }

        // Filter Dari Tanggal
        if ($request->filled('dari')) {
            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $request->dari
            );
        }

        // Filter Sampai Tanggal
        if ($request->filled('sampai')) {
            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $request->sampai
            );
        }

        $peminjamans = $query
            ->orderByRaw("
                CASE
                    WHEN status = 'Dipinjam' THEN 1
                    WHEN status = 'Terlambat' THEN 2
                    WHEN status = 'Dikembalikan' THEN 3
                    ELSE 4
                END
            ")
            ->orderByDesc('tanggal_pinjam')
            ->paginate(10)
            ->withQueryString();

        $totalPeminjaman = Peminjaman::count();

        $dipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereNull('tanggal_kembali');
        })->sum('jumlah');
        
        $dikembalikan = Peminjaman::whereNotNull('tanggal_kembali')
            ->count();

        $bukuTerpopuler = DetailPeminjaman::select('id_buku')
            ->selectRaw('SUM(jumlah) as total')
            ->with('buku')
            ->groupBy('id_buku')
            ->orderByDesc('total')
            ->first();

        $namaBuku = $bukuTerpopuler?->buku?->judul_buku;
        $totalDipinjam = $bukuTerpopuler?->total;

        return view(
            'laporan.peminjaman',
            compact(
                'peminjamans',
                'totalPeminjaman',
                'dipinjam',
                'dikembalikan',
                'namaBuku',
                'totalDipinjam'
            )
        );
    }

    public function exportPeminjamanExcel(Request $request)
    {
        return Excel::download(
            new PeminjamanExport($request),
            'Laporan_Peminjaman.xlsx'
        );
    }

    public function exportPeminjamanPdf(Request $request)
    {
        $query = Peminjaman::with([
            'anggota',
            'details.buku'
        ]);

        // Nama
        if ($request->filled('nama')) {

            $query->whereHas('anggota', function ($q) use ($request) {

                $q->where(
                    'nama',
                    'LIKE',
                    '%' . trim($request->nama) . '%'
                );

            });

        }

        // Dari
        if ($request->filled('dari')) {

            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $request->dari
            );

        }

        // Sampai
        if ($request->filled('sampai')) {

            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $request->sampai
            );

        }

        $peminjamans = $query->latest()->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.peminjaman',
            [
                'peminjamans' => $peminjamans,
                'tanggalCetak' => Carbon::now('Asia/Jayapura')->translatedFormat('d F Y'),
                'jamCetak' => Carbon::now('Asia/Jayapura')->format('H:i') . ' WIT',
                'jumlahData' => $peminjamans->count()
            ]
        )->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_Peminjaman.pdf');
    }
}