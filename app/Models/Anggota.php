<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'jenis_kelamin',
        'alamat',
        'umur',
        'no_telp',
        'email',
        'tanggal_daftar',
        'status',
    ];

    public function pengunjungs()
    {
        return $this->hasMany(
            Pengunjung::class,
            'id_anggota',
            'id_anggota'
        );
    }

    public function peminjamans()
    {
        return $this->hasMany(
            Peminjaman::class,
            'id_anggota',
            'id_anggota'
        );
    }
}
