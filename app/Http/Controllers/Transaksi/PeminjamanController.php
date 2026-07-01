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
    public function index(Request $request)
    {
        // ==============================
        // Update otomatis status terlambat
        // ==============================
        Peminjaman::whereNull('tanggal_kembali')
            ->where('status', 'Dipinjam')
            ->whereDate('batas_kembali', '<', now())
            ->update([
                'status' => 'Terlambat'
            ]);

        // ==============================
        // Query
        // ==============================
        $query = Peminjaman::with([
            'anggota',
            'details.buku'
        ]);

        // ==============================
        // Search
        // ==============================
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'kode_peminjaman',
                    'like',
                    '%' . $search . '%'
                )

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
                'status',
                $request->status
            );

        }

        // ==============================
        // Filter Tanggal Pinjam
        // ==============================
        if ($request->filled('tanggal_pinjam')) {

            $query->whereDate(
                'tanggal_pinjam',
                $request->tanggal_pinjam
            );

        }

        // ==============================
        // Data
        // ==============================
        $peminjamans = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        // ==============================
        // Modal Tambah
        // ==============================
        $anggotas = Anggota::where(
            'status',
            'Aktif'
        )->orderBy('nama')->get();

        $bukus = Buku::where(
            'stok_tersedia',
            '>',
            0
        )->orderBy('judul_buku')->get();

        return view(
            'transaksi.peminjaman.index',
            compact(
                'peminjamans',
                'anggotas',
                'bukus'
            )
        );
    }

    /**
     * STORE PEMINJAMAN
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
            $last = Peminjaman::orderBy('id_peminjaman','desc')->first();
            $next = $last ? $last->id_peminjaman + 1 : 1;
            $kode = 'PJM-' . str_pad($next, 6, '0', STR_PAD_LEFT);

            // Huruf kapital otomatis
            $keterangan = $request->filled('keterangan')
                ? ucfirst(strtolower(trim($request->keterangan)))
                : null;

            // Simpan peminjaman
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $kode,
                'id_anggota'      => $request->id_anggota,
                'tanggal_pinjam'  => $request->tanggal_pinjam ?? now()->toDateString(),
                'batas_kembali'   => $request->batas_kembali,
                'status'          => 'Dipinjam',
                'keterangan'      => $keterangan,
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

                // Simpan detail
                DetailPeminjaman::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
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
     * SHOW DETAIL
     */
    public function show($id)
    {
        $peminjaman = Peminjaman::with(['anggota', 'details.buku'])
            ->findOrFail($id);

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

        // Huruf kapital otomatis
        $keterangan = $request->filled('keterangan')
            ? ucfirst(strtolower(trim($request->keterangan)))
            : null;

        $peminjaman->update([
            'id_anggota'      => $request->id_anggota,
            'batas_kembali'   => $request->batas_kembali,
            'keterangan'      => $keterangan,
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

            $statusPengembalian = now()->gt($peminjaman->batas_kembali)
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

            // Kembalikan stok
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