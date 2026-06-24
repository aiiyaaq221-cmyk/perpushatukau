<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Anggota;
use Carbon\Carbon;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


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

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $anggotas = $query->latest()->get();

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

        $pdf = PDF::loadView('laporan.anggota_pdf', compact('anggotas'));

        return $pdf->download('laporan-anggota.pdf');
    }
}
