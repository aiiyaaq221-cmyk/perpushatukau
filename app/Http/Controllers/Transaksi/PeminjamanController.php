<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * LIST PEMINJAMAN
     */
    public function index()
    {
        // update otomatis status terlambat
        Peminjaman::whereNull('tanggal_kembali')
            ->where('status', 'Dipinjam')
            ->whereDate('batas_kembali', '<', now())
            ->update([
                'status' => 'Terlambat'
            ]);

            
        $peminjamans = Peminjaman::with(['anggota', 'details.buku'])
            ->latest()
            ->get();

        $anggotas = Anggota::where('status', 'Aktif')->get();
        $bukus = Buku::where('stok_tersedia', '>', 0)->get();

        $totalPeminjaman = Peminjaman::count();
        $dipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $dikembalikan = Peminjaman::where('status', 'Dikembalikan')->count();
        $terlambat = Peminjaman::where('status', 'Terlambat')->count();

        return view('transaksi.peminjaman.index', compact(
            'peminjamans',
            'anggotas',
            'bukus',
            'totalPeminjaman',
            'dipinjam',
            'dikembalikan',
            'terlambat'
        ));
    }

    /**
     * STORE PEMINJAMAN (PINJAM BUKU)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required',
            'batas_kembali' => 'required|date',
            'buku' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Generate kode peminjaman
            $last = Peminjaman::latest()->first();
            $nomor = $last ? ((int) substr($last->kode_peminjaman, 4)) + 1 : 1;
            $kode = 'PJM-' . str_pad($nomor, 4, '0', STR_PAD_LEFT);

            // Simpan peminjaman
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $kode,
                'id_anggota'      => $request->id_anggota,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'batas_kembali'   => $request->batas_kembali,
                'status'          => 'Dipinjam',
                'keterangan'      => $request->keterangan,
            ]);

            // Simpan detail buku
            foreach ($request->buku as $item) {
                $buku = Buku::findOrFail($item['id_buku']);

                // Cek stok
                if ($buku->stok_tersedia < $item['jumlah']) {
                    throw new \Exception(
                        'Stok buku "' . $buku->judul_buku . '" tidak mencukupi.'
                    );
                }

                // Kurangi stok
                $buku->decrement('stok_tersedia', $item['jumlah']);

                // Simpan detail peminjaman
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman, // sesuaikan PK
                    'id_buku'       => $item['id_buku'],
                    'jumlah'        => $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('transaksi.peminjaman.index')
                ->with('success', 'Peminjaman berhasil ditambahkan.');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * SHOW DETAIL (optional kalau dipakai)
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'details.buku']) ->findOrFail($id);
        return view('transaksi.peminjaman.show', compact('peminjaman'));
    }

    /**
     * UPDATE PEMINJAMAN
     */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        if ($peminjaman->status == 'Dikembalikan') {
            return back()->with('error', 'Data yang sudah dikembalikan tidak bisa diubah');
        }

        $peminjaman->update([
            'id_anggota' => $request->id_anggota,
            'batas_kembali' => $request->batas_kembali,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Data peminjaman berhasil diubah');
    }

    /**
     * KEMBALIKAN BUKU
     */
    
    public function kembali($id)
    {
        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::with('details.buku')
                ->findOrFail($id);

            if ($peminjaman->tanggal_kembali) {
                return back()->with('error', 'Sudah dikembalikan');
            }

            foreach ($peminjaman->details as $detail) {
                $detail->buku->increment(
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

    /**
     * DELETE PEMINJAMAN
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::with('details.buku')
                ->findOrFail($id);

            // balikin stok dulu
            foreach ($peminjaman->details as $detail) {
                $detail->buku->increment('stok_tersedia', $detail->jumlah);
            }

            $peminjaman->delete();

            DB::commit();
            return back()->with('success', 'Data peminjaman berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}