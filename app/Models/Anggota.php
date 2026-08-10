<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\User;

class Anggota extends Model
{
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'kode_anggota',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
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

    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return '-';
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    public function user()
    {
        return $this->hasOne(
            User::class,
            'id_anggota',
            'id_anggota'
        );
    }
}
