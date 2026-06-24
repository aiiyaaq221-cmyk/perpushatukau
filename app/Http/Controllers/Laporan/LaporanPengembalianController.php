<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;

class LaporanPengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::with([
            'peminjaman.anggota'
        ]);

        if ($request->filled('nama')) {
            $query->whereHas(
                'peminjaman.anggota',
                function ($q) use ($request) {

                    $q->where(
                        'nama',
                        'like',
                        '%' . $request->nama . '%'
                    );
                }
            );
        }

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_kembali',
                $request->tanggal
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status_pengembalian',
                $request->status
            );
        }

        $pengembalians = $query
            ->latest()
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
}