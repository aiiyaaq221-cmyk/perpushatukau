<?php

namespace App\Exports;

use App\Models\Pengunjung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengunjungExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pengunjung::select(
            'nama',
            'alamat',
            'umur',
            'jenis_kelamin',
            'status_pengunjung',
            'tujuan',
            'tanggal_kunjungan'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Alamat',
            'Umur',
            'Jenis Kelamin',
            'Status',
            'Tujuan',
            'Tanggal Kunjungan'
        ];
    }
}