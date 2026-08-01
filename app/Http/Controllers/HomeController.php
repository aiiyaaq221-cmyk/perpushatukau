<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'books' => Buku::count(),
            'members' => Anggota::count(),
            'categories' => Kategori::count(),
            'borrowings' => Peminjaman::count(),
        ];
    $jumlahBuku = Buku::count();

        return view('welcome', compact('stats', 'jumlahBuku'));
    }
}