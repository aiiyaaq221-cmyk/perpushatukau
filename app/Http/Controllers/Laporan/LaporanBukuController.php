<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\DetailPeminjaman;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanBukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter pencarian
        if($request->filled('search')){
            $query->where(function($q) use ($request){
                $q->where(
                    'judul_buku',
                    'like',
                    '%'.$request->search.'%'
                )
                ->orWhere(
                    'pengarang',
                    'like',
                    '%'.$request->search.'%'
                )
                ->orWhere(
                    'kode_buku',
                    'like',
                    '%'.$request->search.'%'
                );
            });
        }

        // Filter kategori
        if($request->filled('kategori')){
            $query->where(
                'id_kategori',
                $request->kategori
            );
        }

        // Filter tanggal masuk
        if($request->filled('tanggal')){
            $query->whereDate(
                'tanggal_masuk',
                $request->tanggal
            );
        }

        $bukus = $query
            ->orderBy('judul_buku', 'asc')
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $totalBuku = Buku::count();
        $jumlahBuku = Buku::sum('jumlah_buku');
        $totalDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->whereNull('tanggal_kembali');})->sum('jumlah');
        
        $totalKategori = Kategori::count();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view(
            'laporan.buku',
            compact(
                'bukus',
                'kategoris',
                'totalBuku',
                'jumlahBuku',
                'totalDipinjam',
                'totalKategori'
            )
        );
    }

    public function exportExcel()
    {
        return Excel::download(
            new BukuExport(),
            'laporan_buku.xlsx'
        );
    }

   
    public function exportPdf()
    {
        Carbon::setLocale('id');

        $bukus = Buku::with('kategori')
            ->latest()
            ->get();

        $tanggalCetak = Carbon::now('Asia/Jayapura')->translatedFormat('d F Y');
        $jamCetak = Carbon::now('Asia/Jayapura')->format('H:i');
        $jumlahBuku = Buku::sum('jumlah_buku');

        $pdf = PDF::loadView(
            'laporan.pdf.buku',
            compact(
                'bukus',
                'tanggalCetak',
                'jamCetak',
                'jumlahBuku'
            )
        )->setPaper('A4', 'landscape');

        return $pdf->download('laporan-buku.pdf');
    }
}
