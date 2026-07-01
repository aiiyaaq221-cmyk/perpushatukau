<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Exports\PengembalianExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LaporanPengembalianController extends Controller
{
    public function index(Request $request)
    {
        $pengembalians = $this
        ->getFilteredPengembalian($request)
        ->get();

        $totalPengembalian = Pengembalian::count();

        $tepatWaktu = Pengembalian::where(
            'status_pengembalian',
            'Tepat Waktu'
        )->count();

        $terlambat = Pengembalian::where(
            'status_pengembalian',
            'Terlambat'
        )->count();

        return view(
            'laporan.pengembalian',
            compact(
                'pengembalians',
                'totalPengembalian',
                'tepatWaktu',
                'terlambat'
            )
        );
    }

    public function exportExcel(Request $request)
    {
        $pengembalians = $this
            ->getFilteredPengembalian($request)
            ->get();

        return Excel::download(
            new PengembalianExport($pengembalians),
            'Laporan_Pengembalian_' .
            Carbon::now('Asia/Jayapura')
                ->format('dmY_His')
            . '.xlsx'
        );
    }
    
    public function exportPdf(Request $request)
    {
        $pengembalians = $this
            ->getFilteredPengembalian($request)
            ->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.pengembalian',
            [
                'pengembalians' => $pengembalians,
                'tanggalCetak' => Carbon::now('Asia/Jayapura')
                    ->translatedFormat('d F Y'),

                'jamCetak' => Carbon::now('Asia/Jayapura')
                    ->format('H:i') . ' WIT',

                'jumlahData' => $pengembalians->count(),
            ]
        );

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download(
            'Laporan_Pengembalian_' .
            Carbon::now('Asia/Jayapura')
                ->format('dmY_His')
            . '.pdf'
        );
    }

    private function getFilteredPengembalian(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.anggota',
            'peminjaman.details.buku'
        ]);

        // Filter Nama
        if ($request->filled('nama')) {
            $query->whereHas('peminjaman.anggota', function ($q) use ($request) {
                $q->where(
                    'nama',
                    'like',
                    '%' . $request->nama . '%'
                );
            });
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_kembali',
                $request->tanggal
            );
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where(
                'status_pengembalian',
                $request->status
            );
        }

        return $query->latest();
    }
}