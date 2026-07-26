<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengembalian extends Model
{
    use SoftDeletes;

    protected $table = 'pengembalians';

    protected $primaryKey = 'id_pengembalian';

    protected $fillable = [
        'id_peminjaman',
        'tanggal_kembali',
        'status_pengembalian',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(
            Peminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }
}