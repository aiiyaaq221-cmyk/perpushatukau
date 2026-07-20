<?php

namespace App\Exports;

use App\Models\Buku;
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

class BukuExport implements
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
        $buku = Buku::with('kategori')
            ->latest()
            ->get();

        $this->jumlahBuku = $buku->sum('jumlah_buku');

        return $buku;
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Buku',
            'Judul Buku',
            'Kategori',
            'Pengarang',
            'Penerbit',
            'Tahun',
            'Tanggal Masuk',
            'Jilid',
            'Edisi',
            'Sumber',
            'Jumlah',
            'Keterangan'
        ];
    }

    public function map($buku): array
    {
        return [
            $this->no++,
            $buku->kode_buku,
            $buku->judul_buku,
            $buku->kategori->nama_kategori ?? '-',
            $buku->pengarang,
            $buku->penerbit,
            $buku->tahun_terbit,
            Carbon::parse($buku->tanggal_masuk)->format('d-m-Y'),
            $buku->jilid,
            $buku->edisi,
            $buku->sumber,
            $buku->jumlah_buku,
            $buku->keterangan ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                $sheet->insertNewRowBefore(1,7);

                $sheet->mergeCells('A1:N1');
                $sheet->setCellValue('A1','PERPUSTAKAAN HATUKAU');

                $sheet->mergeCells('A2:N2');
                $sheet->setCellValue('A2','LAPORAN DATA BUKU');

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
                    'Jumlah Buku : ' . $this->jumlahBuku . ' Buku'
                );

                $sheet->getStyle('A1:N2')->applyFromArray([

                    'font'=>[
                        'bold'=>true,
                        'size'=>16
                    ],

                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER
                    ]

                ]);

                $sheet->getStyle('A8:N8')->applyFromArray([

                    'font'=>[
                        'bold'=>true,
                        'color'=>[
                            'rgb'=>'FFFFFF'
                        ]
                    ],

                    'fill'=>[
                        'fillType'=>Fill::FILL_SOLID,
                        'startColor'=>[
                            'rgb'=>'198754'
                        ]
                    ],

                    'alignment'=>[
                        'horizontal'=>Alignment::HORIZONTAL_CENTER,
                        'vertical'=>Alignment::VERTICAL_CENTER
                    ]

                ]);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A8:N{$lastRow}")
                    ->applyFromArray([

                        'borders'=>[

                            'allBorders'=>[

                                'borderStyle'=>Border::BORDER_THIN

                            ]

                        ]

                    ]);

                $sheet->getStyle("A8:B{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("G8:M{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            }

        ];
    }
}