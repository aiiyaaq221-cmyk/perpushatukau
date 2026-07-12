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

        // Filter Tanggal Pinjam
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal );
        }

        // Filter Status
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'Dipinjam':
                    $query->whereNull('tanggal_kembali')
                        ->whereDate('batas_kembali', '>=', now());
                    break;
                case 'Terlambat':
                    $query->whereNull('tanggal_kembali')
                        ->whereDate('batas_kembali', '<', now());

                    break;
                case 'Dikembalikan':
                    $query->whereNotNull('tanggal_kembali');
                    break;
            }
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

        $terlambat = Peminjaman::whereNull('tanggal_kembali')
            ->whereDate('batas_kembali', '<', now())
            ->count();

        $dikembalikan = Peminjaman::whereNotNull('tanggal_kembali')
            ->count();

        return view(
            'laporan.peminjaman',
            compact(
                'peminjamans',
                'totalPeminjaman',
                'dipinjam',
                'dikembalikan',
                'terlambat'
            )
        );
    }

    public function exportPeminjamanExcel()
    {
        return Excel::download(
            new PeminjamanExport,
            'Laporan_Peminjaman.xlsx'
        );
    }

    public function exportPeminjamanPdf()
    {
        $peminjamans=Peminjaman::with([
            'anggota',
            'details.buku'
        ])->latest()->get();

        $pdf=Pdf::loadView(
            'laporan.pdf.peminjaman',
            [
                'peminjamans'=>$peminjamans,
                'tanggalCetak'=>Carbon::now('Asia/Jayapura')->translatedFormat('d F Y'),
                'jamCetak'=>Carbon::now('Asia/Jayapura')->format('H:i').' WIT',
                'jumlahData'=>$peminjamans->count()
            ]
        )->setPaper('A4','landscape');
        return $pdf->download('Laporan_Peminjaman.pdf');
    }
}