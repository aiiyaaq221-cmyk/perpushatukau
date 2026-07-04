<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Carbon\Carbon;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class LaporanAnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

         // Cari Nama atau Alamat
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->keyword . '%')
                ->orWhere('alamat', 'like', '%' . $request->keyword . '%');
            });
        }

        $anggotas=$query
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonAktif = Anggota::where('status', 'Tidak Aktif')->count();
        $anggotaBaru = Anggota::whereMonth(
            'tanggal_daftar',
            Carbon::now()->month
        )->whereYear(
            'tanggal_daftar',
            Carbon::now()->year
        )->count();

        return view('laporan.anggota', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonAktif',
            'anggotaBaru'
        ));
    }

   
    public function exportExcel()
    {
        return Excel::download(new AnggotaExport, 'laporan-anggota.xlsx');
    }


    public function exportPdf()
    {
        $anggotas = Anggota::all();

        Carbon::setLocale('id');

        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        $jamCetak = Carbon::now()->format('H:i');
        $jumlahData = $anggotas->count();

        $pdf = PDF::loadView('laporan.pdf.anggota_pdf', compact(
            'anggotas',
            'tanggalCetak',
            'jamCetak',
            'jumlahData'
        ));

        return $pdf->download('laporan-anggota.pdf');
    }
}
