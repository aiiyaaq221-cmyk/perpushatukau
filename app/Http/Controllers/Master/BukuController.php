<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->search) {
            $query->where(
                'judul_buku',
                'like',
                '%' . $request->search . '%'
            );
        }
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }
        
        $bukus = $query->latest()->get();

        $kategoris = Kategori::all();

        $totalBuku = Buku::count();
        $totalKategori = Kategori::count();
        $totalStok = Buku::sum('stok_tersedia');

        return view(
            'master.buku.index', compact(
                'bukus',
                'kategoris',
                'totalBuku',
                'totalKategori',
                'totalStok'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'jumlah_buku' => 'required|integer',
            'stok_tersedia' => 'required|integer',

            'kode_buku' => 'nullable',
            'jilid' => 'nullable',
            'edisi' => 'nullable',
            'keterangan' => 'nullable',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $cover = null;

        if ($request->hasFile('cover')) {

            $cover = $request->file('cover')
                ->store('buku', 'public');
        }

        Buku::create([
            'id_kategori' => $request->id_kategori,
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jilid' => $request->jilid,
            'edisi' => $request->edisi,
            'sumber' => $request->sumber,
            'jumlah_buku' => $request->jumlah_buku,
            'stok_tersedia' => $request->stok_tersedia,
            'cover' => $cover,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    
    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required',
            'kode_buku' => 'nullable|unique:bukus,kode_buku,' . $id . ',id_buku',
            'judul_buku' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'id_kategori' => $request->id_kategori,
            'kode_buku' => $request->kode_buku,
            'judul_buku' => $request->judul_buku,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'tanggal_masuk' => $request->tanggal_masuk,
            'jilid' => $request->jilid,
            'edisi' => $request->edisi,
            'sumber' => $request->sumber,
            'jumlah_buku' => $request->jumlah_buku,
            'stok_tersedia' => $request->stok_tersedia,
            'keterangan' => $request->keterangan,
        ];

        if ($request->hasFile('cover')) {

            // Hapus cover lama
            if ($buku->cover) {

                Storage::disk('public')
                    ->delete($buku->cover);
            }

            // Upload cover baru
            $data['cover'] = $request->file('cover')
                ->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()
            ->back()
            ->with(
                'success',
                'Data buku berhasil diupdate'
            );
    }
}
