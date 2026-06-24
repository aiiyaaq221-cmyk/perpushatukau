<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengunjung extends Model
{
    protected $table = 'pengunjungs';
    protected $primaryKey = 'id_tamu';

    protected $fillable = [
        'id_anggota',
        'jenis_pengunjung',
        'nama',
        'alamat',
        'umur',
        'jenis_kelamin',
        'status_pengunjung',
        'tujuan',
        'keterangan',
        'tanggal_kunjungan'
    ];

    public function anggota()
    {
        return $this->belongsTo(
            Anggota::class,
            'id_anggota',
            'id_anggota'
        );
    }

}
