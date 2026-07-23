<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::withCount('bukus');

        if ($request->filled('search')) {
            $query->where(
                'nama_kategori',
                'like',
                '%' . $request->search . '%'
            );
        }

        $kategoris = $query
            ->orderBy('nama_kategori', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('master.kategori.index', compact('kategoris'));
    }


    public function store(Request $request)
    {
        $namaKategori = Str::title(trim($request->nama_kategori));

        if (Kategori::where('nama_kategori', $namaKategori)->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Kategori sudah tersedia.');
        }

        Kategori::create([
            'nama_kategori' => $namaKategori
        ]);

        return back()->with(
            'success',
            'Kategori berhasil ditambahkan.'
        );
    }


    public function update(Request $request, $id)
    {
        dd($request->all(), $request->file('cover'));
        $namaKategori = Str::title(trim($request->nama_kategori));

        $cek = Kategori::where('nama_kategori', $namaKategori)
            ->where('id_kategori', '!=', $id)
            ->exists();

        if ($cek) {
            return back()
                ->withInput()
                ->with('error', 'Kategori sudah tersedia.');
        }

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => $namaKategori
        ]);

        return back()->with(
            'success',
            'Kategori berhasil diubah.'
        );
    }

     
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}