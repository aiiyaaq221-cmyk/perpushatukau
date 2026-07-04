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
             ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'master.kategori.index',
            compact('kategoris')
        );
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        Kategori::create([
            'nama_kategori' => Str::title(trim($request->nama_kategori))
        ]);

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'nama_kategori' => Str::title(trim($request->nama_kategori))
        ]);

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil diubah');
    }

    
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil dihapus');
    }
}