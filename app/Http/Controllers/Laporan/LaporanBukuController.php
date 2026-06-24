<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Exports\BukuExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


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
            ->latest()
            ->paginate(10);

        // Statistik
        $totalBuku = Buku::count();

        $stokTersedia = Buku::sum('stok_tersedia');

        $totalDipinjam =
            Buku::sum('jumlah_buku')
            - Buku::sum('stok_tersedia');

        $totalKategori = Kategori::count();

        $kategoris = Kategori::orderBy(
            'nama_kategori'
        )->get();

        return view(
            'laporan.buku',
            compact(
                'bukus',
                'kategoris',
                'totalBuku',
                'stokTersedia',
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
        $bukus = Buku::with('kategori')->get();

        $pdf = Pdf::loadView(
            'laporan.pdf.buku',
            compact('bukus')
        );

        return $pdf->download(
            'laporan_buku.pdf'
        );
    }
}
