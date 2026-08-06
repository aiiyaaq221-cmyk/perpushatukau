<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
                    ->orWhere('isbn', 'like', "%{$search}%");
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
                    $query->where('jumlah_buku', '>', 5);
                    break;

                case 'hampir':
                    $query->whereBetween('jumlah_buku', [1, 5]);
                    break;

                case 'habis':
                    $query->where('jumlah_buku', 0);
                    break;
            }
        }

        $bukus = $query
            ->orderBy('judul_buku', 'asc')
            ->paginate(10)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $jumlahBuku = Buku::sum('jumlah_buku');

        return view('master.buku.index', compact(
            'bukus',
            'kategoris',
            'jumlahBuku'
        ));
    }

    public function store(Request $request)
    {    

        $request->validate([
            'id_kategori'    => 'required',
            'judul_buku'     => 'required',
            'pengarang'      => 'required',
            'jumlah_buku'    => 'required|integer',
            'kode_buku'      => 'nullable|unique:bukus,kode_buku',
            'jilid'          => 'nullable',
            'edisi'          => 'nullable',
            'keterangan'     => 'nullable',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'isbn'           => 'nullable|string|max:20',
            'deskripsi'      => 'nullable|string|max:5000',
        ]);

        $cover = null;

        // Upload manual
        if ($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('buku', 'public');
        }

        // Cover dari Open Library
        elseif($request->filled('cover_url')){
            $image = Http::get($request->cover_url);
            if($image->successful()){
                $filename = 'buku/'.time().'.jpg';
                Storage::disk('public') ->put($filename, $image->body());
                $cover = $filename;
            }
        }

        Buku::create([
            'id_kategori'    => $request->id_kategori,
            'kode_buku'      => $request->filled('kode_buku') ? strtoupper(trim($request->kode_buku)) : null,
            'isbn'           => $request->isbn,
            'judul_buku'     => Str::title(trim($request->judul_buku)),
            'pengarang'      => Str::title(trim($request->pengarang)),
            'penerbit'       => $request->penerbit ? Str::title(trim($request->penerbit)) : null,
            'tahun_terbit'   => $request->tahun_terbit,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'jilid'          => $request->jilid,
            'edisi'          => $request->edisi,
            'sumber'         => $request->sumber ? Str::title(trim($request->sumber)) : null,
            'jumlah_buku'    => $request->jumlah_buku,
            'cover'          => $cover,
            'deskripsi'      => $request->deskripsi,
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
            'isbn'           => 'nullable|string|max:20',
            'deskripsi'      => 'nullable|string|max:5000',
        ]);

        $data = [
            'id_kategori'    => $request->id_kategori,
            'kode_buku'      => $request->filled('kode_buku')
                                ? strtoupper(trim($request->kode_buku))
                                : null,
            'isbn'           => $request->isbn,
            'judul_buku'     => Str::title(trim($request->judul_buku)),
            'pengarang'      => Str::title(trim($request->pengarang)),
            'penerbit'       => Str::title(trim($request->penerbit)),
            'tahun_terbit'   => $request->tahun_terbit,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'jilid'          => $request->jilid,
            'edisi'          => $request->edisi,
            'sumber'         => $request->sumber ? Str::title(trim($request->sumber)) : null,
            'jumlah_buku'    => $request->jumlah_buku,
            'deskripsi'      => $request->deskripsi,
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