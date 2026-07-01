<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PengembalianExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
{
    protected $no = 1;

    protected $jumlahData = 0;

    public function collection()
    {
        $data = Pengembalian::with([
            'peminjaman.anggota',
            'peminjaman.details.buku'
        ])
        ->latest()
        ->get();

        $this->jumlahData = $data->count();

        return $data;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Peminjaman',
            'Nama Anggota',
            'Judul Buku',
            'Tanggal Kembali',
            'Status',
            'Keterangan'
        ];
    }

    public function map($pengembalian): array
    {
        $judulBuku = $pengembalian->peminjaman->details
            ->map(function ($detail) {
                return optional($detail->buku)->judul_buku;
            })
            ->filter()
            ->implode(', ');

        return [
            $this->no++,
            $pengembalian->peminjaman->kode_peminjaman ?? '-',
            $pengembalian->peminjaman->anggota->nama ?? '-',
            $judulBuku ?: '-',
            Carbon::parse($pengembalian->tanggal_kembali)->format('d-m-Y'),
            $pengembalian->status_pengembalian,
            $pengembalian->keterangan ?: '-',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                /*
                |--------------------------------------------------------------------------
                | Sisipkan ruang untuk header laporan
                |--------------------------------------------------------------------------
                */

                $sheet->insertNewRowBefore(1, 7);

                /*
                |--------------------------------------------------------------------------
                | Judul
                |--------------------------------------------------------------------------
                */

                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', 'PERPUSTAKAAN HATUKAU');

                $sheet->mergeCells('A2:G2');
                $sheet->setCellValue('A2', 'LAPORAN DATA PENGEMBALIAN BUKU');

                /*
                |--------------------------------------------------------------------------
                | Informasi Cetak
                |--------------------------------------------------------------------------
                */

                $sheet->setCellValue(
                    'A4',
                    'Tanggal Cetak : ' .
                    Carbon::now('Asia/Jayapura')->translatedFormat('d F Y')
                );

                $sheet->setCellValue(
                    'A5',
                    'Jam Cetak : ' .
                    Carbon::now('Asia/Jayapura')->format('H:i') . ' WIT'
                );

                $sheet->setCellValue(
                    'A6',
                    'Jumlah Data : ' . $this->jumlahData . ' Data'
                );

                /*
                |--------------------------------------------------------------------------
                | Style Judul
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A1:G2')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],

                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ]

                ]);

                /*
                |--------------------------------------------------------------------------
                | Header Tabel
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle('A8:G8')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'color' => [
                            'rgb' => 'FFFFFF'
                        ]
                    ],

                    'fill' => [

                        'fillType' => Fill::FILL_SOLID,

                        'startColor' => [
                            'rgb' => '198754'
                        ]

                    ],

                    'alignment' => [

                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER

                    ]

                ]);

                /*
                |--------------------------------------------------------------------------
                | Border Seluruh Tabel
                |--------------------------------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A8:G{$lastRow}")
                    ->applyFromArray([

                        'borders' => [

                            'allBorders' => [

                                'borderStyle' => Border::BORDER_THIN,

                            ]

                        ]

                    ]);

                /*
                |--------------------------------------------------------------------------
                | Alignment
                |--------------------------------------------------------------------------
                */

                $sheet->getStyle("A8:A{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("E8:F{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            }

        ];
    }
}