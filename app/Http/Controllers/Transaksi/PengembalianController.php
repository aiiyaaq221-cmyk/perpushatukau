<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.anggota',
            'peminjaman.details.buku'
        ])
        ->latest()
        ->get();
       
        $totalPengembalian = $pengembalians->count();

        $tepatWaktu = $pengembalians
            ->where('status_pengembalian', 'Tepat Waktu')
            ->count();

        $terlambat = $pengembalians
            ->where('status_pengembalian', 'Terlambat')
            ->count();

         $persenTerlambat = $totalPengembalian > 0
            ? round(($terlambat / $totalPengembalian) * 100)
            : 0;
            
        return view(
            'transaksi.pengembalian.index',
            compact(
                'pengembalians',
                'totalPengembalian',
                'tepatWaktu',
                'terlambat',
                'persenTerlambat'
            )
        );
    }

    public function store($id)
    {
        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::with('details')
                ->findOrFail($id);

            foreach ($peminjaman->details as $detail) {

                Buku::where(
                    'id_buku',
                    $detail->id_buku
                )->increment(
                    'stok_tersedia',
                    $detail->jumlah
                );
            }

            $statusPengembalian =
                now()->gt($peminjaman->batas_kembali)
                ? 'Terlambat'
                : 'Tepat Waktu';

            Pengembalian::create([
                'id_peminjaman'       => $peminjaman->id_peminjaman,
                'tanggal_kembali'     => now(),
                'status_pengembalian' => $statusPengembalian,
                'keterangan'          => null
            ]);

            $peminjaman->update([
                'tanggal_kembali' => now(),
                'status'          => 'Dikembalikan'
            ]);

            DB::commit();

            return back()->with(
                'success',
                'Buku berhasil dikembalikan'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }


    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('anggota.show', compact('anggota'));
    }


    public function destroy($id)
    {
        try {

            $pengembalian = Pengembalian::findOrFail($id);

            $pengembalian->delete();

            return back()->with(
                'success',
                'Data pengembalian berhasil dihapus'
            );

        } catch (\Exception $e) {

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}