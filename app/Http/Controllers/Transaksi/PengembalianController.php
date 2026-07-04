<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        // ==============================
        // Query
        // ==============================
        $query = Pengembalian::with([
            'peminjaman.anggota',
            'peminjaman.details.buku'
        ]);

        // ==============================
        // Search
        // ==============================
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->whereHas('peminjaman', function ($q) use ($search) {

                $q->where('kode_peminjaman', 'like', '%' . $search . '%')

                    ->orWhereHas('anggota', function ($anggota) use ($search) {

                        $anggota->where(
                            'nama',
                            'like',
                            '%' . $search . '%'
                        );

                    });

            });

        }

        // ==============================
        // Filter Status
        // ==============================
        if ($request->filled('status')) {

            $query->where(
                'status_pengembalian',
                $request->status
            );

        }

        // ==============================
        // Filter Tanggal Kembali
        // ==============================
        if ($request->filled('tanggal')) {

            $query->whereDate(
                'tanggal_kembali',
                $request->tanggal
            );

        }

        // ==============================
        // Data
        // ==============================
        $pengembalians = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // ==============================
        // View
        // ==============================
        return view(
            'transaksi.pengembalian.index',
            compact('pengembalians')
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