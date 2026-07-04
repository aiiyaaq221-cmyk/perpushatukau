<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Search
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {

                $q->where('judul_buku', 'like', "%{$search}%")
                ->orWhere('kode_buku', 'like', "%{$search}%")
                ->orWhere('pengarang', 'like', "%{$search}%");

            });

        }

        // Filter kategori
        if ($request->filled('kategori')) {

            $query->where('id_kategori', $request->kategori);

        }

        // Filter status stok
        if ($request->filled('status')) {

            switch ($request->status) {

                case 'tersedia':
                    $query->where('stok_tersedia', '>', 5);
                    break;

                case 'hampir':
                    $query->whereBetween('stok_tersedia', [1, 5]);
                    break;

                case 'habis':
                    $query->where('stok_tersedia', 0);
                    break;
            }

        }

        $bukus = $query
            ->orderBy('judul_buku', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::all();

        return view('master.buku.index', compact(
            'bukus',
            'kategoris'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori'    => 'required',
            'judul_buku'     => 'required',
            'pengarang'      => 'required',
            'jumlah_buku'    => 'required|integer',
            'stok_tersedia'  => 'required|integer',

            'kode_buku'      => 'nullable|unique:bukus,kode_buku',
            'jilid'          => 'nullable',
            'edisi'          => 'nullable',
            'keterangan'     => 'nullable',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $cover = null;

        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('buku', 'public');
        }

        Buku::create([
            'id_kategori'    => $request->id_kategori,
            'kode_buku'      => $request->filled('kode_buku')
                                ? strtoupper(trim($request->kode_buku))
                                : null,
            'judul_buku'     => Str::title(trim($request->judul_buku)),
            'pengarang'      => Str::title(trim($request->pengarang)),
            'penerbit'       => $request->penerbit ? Str::title(trim($request->penerbit)) : null,
            'tahun_terbit'   => $request->tahun_terbit,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'jilid'          => $request->jilid,
            'edisi'          => $request->edisi,
            'sumber'         => $request->sumber ? Str::title(trim($request->sumber)) : null,
            'jumlah_buku'    => $request->jumlah_buku,
            'stok_tersedia'  => $request->stok_tersedia,
            'cover'          => $cover,
            'keterangan'     => $request->keterangan ? Str::title(trim($request->keterangan)) : null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data buku berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'id_kategori'   => 'required',
            'kode_buku'     => 'nullable|unique:bukus,kode_buku,' . $id . ',id_buku',
            'judul_buku'    => 'required',
            'pengarang'     => 'required',
            'penerbit'      => 'required',
            'tahun_terbit'  => 'required',
            'cover'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'id_kategori'    => $request->id_kategori,
            'kode_buku'      => $request->filled('kode_buku')
                                ? strtoupper(trim($request->kode_buku))
                                : null,
            'judul_buku'     => Str::title(trim($request->judul_buku)),
            'pengarang'      => Str::title(trim($request->pengarang)),
            'penerbit'       => Str::title(trim($request->penerbit)),
            'tahun_terbit'   => $request->tahun_terbit,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'jilid'          => $request->jilid,
            'edisi'          => $request->edisi,
            'sumber'         => $request->sumber ? Str::title(trim($request->sumber)) : null,
            'jumlah_buku'    => $request->jumlah_buku,
            'stok_tersedia'  => $request->stok_tersedia,
            'keterangan'     => $request->keterangan ? Str::title(trim($request->keterangan)) : null,
        ];

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('buku', 'public');
        }

        $buku->update($data);
        return redirect()
            ->back()
            ->with('success', 'Data buku berhasil diupdate');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()
            ->back()
            ->with('success', 'Data buku berhasil dihapus');
    }
}