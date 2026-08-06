<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahBuku = Buku::sum('jumlah_buku');

        return view('welcome', compact('jumlahBuku'));
    }

    public function searchBooks(Request $request)
    {
        $search = $request->search;

        $featuredBooks = Buku::where('jumlah_buku', '>', 0)
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('judul_buku', 'like', "%{$search}%")
                    ->orWhere('pengarang', 'like', "%{$search}%");

                });

            })
            ->latest()
            ->get();

        return view('partials.book-list', compact('featuredBooks'))->render();
    }


    public function books(Request $request)
    {
        $query = Buku::with('kategori');

        // Search
        if ($request->filled('search')) {

            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('judul_buku', 'like', "%{$search}%")
                ->orWhere('pengarang', 'like', "%{$search}%")
                ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $books = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('books.index', compact(
            'books',
            'kategoris'
        ));
    }

    public function show(Buku $buku)
    {
        return view('books.show', compact('buku'));
    }
}