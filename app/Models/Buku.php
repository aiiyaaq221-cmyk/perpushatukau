<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{ 
    protected $table = 'bukus';
    
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'kode_buku',
        'isbn',
        'judul_buku',
        'id_kategori',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'tanggal_masuk',
        'jilid',
        'edisi',
        'sumber',
        'jumlah_buku',
        'cover',
        'deskripsi',
        'keterangan',

    ];

    public function kategori()
    {
        return $this->belongsTo(
            Kategori::class,
            'id_kategori',
            'id_kategori'
        );
    }

    public function detailPeminjamans()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_buku',
            'id_buku'
        );
    }
}
