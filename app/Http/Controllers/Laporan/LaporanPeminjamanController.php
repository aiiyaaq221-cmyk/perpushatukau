<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class LaporanPeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with('anggota');

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

            $query->where(
                'status',
                $request->status
            );

        }

        $peminjamans = $query
            ->latest()
            ->paginate(10);

        // Statistik
        $totalPeminjaman = Peminjaman::count();

        $dipinjam = Peminjaman::where(
            'status',
            'Dipinjam'
        )->count();

        $dikembalikan = Peminjaman::where(
            'status',
            'Dikembalikan'
        )->count();

        $terlambat = Peminjaman::where(
            'status',
            'Terlambat'
        )->count();

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
}