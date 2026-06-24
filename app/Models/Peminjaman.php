<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'kode_peminjaman',
        'id_anggota',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_kembali',
        'status',
        'keterangan'
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class,
            'id_anggota',
            'id_anggota'
        );
    }

    public function details()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    public function pengembalian()
    {
        return $this->hasOne(
            Pengembalian::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }
}
