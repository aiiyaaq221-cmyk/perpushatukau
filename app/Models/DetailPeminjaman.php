<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    protected $table = 'detail_peminjamans';
    protected $primaryKey = 'id_detail';
    protected $fillable = [
        'id_peminjaman',
        'id_buku',
        'jumlah',
        'keterangan'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    public function buku()
    {
        return $this->belongsTo(
            Buku::class,
            'id_buku',
            'id_buku'
        );
    }
}
