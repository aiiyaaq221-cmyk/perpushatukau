<?php

namespace App\Exports;

use App\Models\Anggota;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnggotaExport implements FromQuery, WithHeadings
{
    public function query()
    {
        return Anggota::query()->select('id_anggota', 'nama', 'alamat', 'no_telp');
    }

    public function headings(): array
    {
         return [
        'ID Anggota',
        'Nama',
        'Alamat',
        'Telepon'];
    }

}

