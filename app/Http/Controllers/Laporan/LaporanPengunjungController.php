<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengunjung;
use App\Exports\PengunjungExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_kunjungan',
                $request->tanggal
            );
        }

        if ($request->filled('status')) {

            if ($request->status == 'Anggota') {
                $query->whereNotNull('id_anggota');
            }

            if ($request->status == 'Umum') {
                $query->whereNull('id_anggota');
            }
        }

        $pengunjungs = $query
            ->latest()
            ->paginate(10);

        $totalPengunjung = Pengunjung::count();

        $hariIni = Pengunjung::whereDate(
            'tanggal_kunjungan',
            now()
        )->count();

        $anggota = Pengunjung::whereNotNull('id_anggota')->count();

        $umum = Pengunjung::whereNull('id_anggota')->count();

        return view(
            'laporan.pengunjung',
            compact(
                'pengunjungs',
                'totalPengunjung',
                'hariIni',
                'anggota',
                'umum'
            )
        );
    }

    public function exportExcel()
    {
        return Excel::download(
            new PengunjungExport(),
            'laporan_pengunjung.xlsx'
        );
    }

    public function exportPdf()
    {
        $pengunjungs = Pengunjung::all();

        $pdf = Pdf::loadView(
            'laporan.pdf.pengunjung',
            compact('pengunjungs')
        );

        return $pdf->download(
            'laporan_pengunjung.pdf'
        );
    }
}