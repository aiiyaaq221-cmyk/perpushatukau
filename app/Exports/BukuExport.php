<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Buku::with('kategori')
            ->get()
            ->map(function ($buku) {
                return [
                    'Kode Buku'      => $buku->kode_buku,
                    'Judul Buku'     => $buku->judul_buku,
                    'Kategori'       => $buku->kategori->nama_kategori ?? '-',
                    'Pengarang'      => $buku->pengarang,
                    'Penerbit'       => $buku->penerbit,
                    'Tahun Terbit'   => $buku->tahun_terbit,
                    'Tanggal Masuk'  => $buku->tanggal_masuk,
                    'Jilid'          => $buku->jilid,
                    'Edisi'          => $buku->edisi,
                    'Sumber'         => $buku->sumber,
                    'Jumlah Buku'    => $buku->jumlah_buku,
                    'Stok Tersedia'  => $buku->stok_tersedia,
                    'Keterangan'     => $buku->keterangan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Judul Buku',
            'Kategori',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Tanggal Masuk',
            'Jilid',
            'Edisi',
            'Sumber',
            'Jumlah Buku',
            'Stok Tersedia',
            'Keterangan'
        ];
    }
}