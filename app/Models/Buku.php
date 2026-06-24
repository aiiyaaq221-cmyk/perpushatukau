<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{ 
    protected $table = 'bukus';
    
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'id_kategori',
        'kode_buku',
        'judul_buku',
        'pengarang',
        'penerbit',
        'tahun_terbit',
        'tanggal_masuk',
        'jilid',
        'edisi',
        'sumber',
        'jumlah_buku',
        'stok_tersedia',
        'cover',
        'keterangan'
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
