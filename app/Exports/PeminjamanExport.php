<?php

namespace App\Exports;

use App\Models\Peminjaman;
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

class PeminjamanExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithEvents
{
    protected $no = 1;

    protected $jumlahData = 0;
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Peminjaman::with([
            'anggota',
            'details.buku'
        ]);

        // Filter Nama Anggota
        if ($this->request->filled('nama')) {

            $query->whereHas('anggota', function ($q) {

                $q->where(
                    'nama',
                    'LIKE',
                    '%' . trim($this->request->nama) . '%'
                );

            });

        }

        // Filter Dari Tanggal
        if ($this->request->filled('dari')) {

            $query->whereDate(
                'tanggal_pinjam',
                '>=',
                $this->request->dari
            );

        }

        // Filter Sampai Tanggal
        if ($this->request->filled('sampai')) {

            $query->whereDate(
                'tanggal_pinjam',
                '<=',
                $this->request->sampai
            );

        }

        $data = $query
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
            'Tanggal Pinjam',
            'Batas Kembali',
            'Status',
            'Keterangan'
        ];
    }

    public function map($peminjaman): array
    {
        $judulBuku = $peminjaman->details
            ->map(function ($detail) {
                return optional($detail->buku)->judul_buku;
            })
            ->filter()
            ->implode(', ');

        return [
            $this->no++,
            $peminjaman->kode_peminjaman,
            $peminjaman->anggota->nama ?? '-',
            $judulBuku ?: '-',
            Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y'),
            Carbon::parse($peminjaman->batas_kembali)->format('d-m-Y'),
            $peminjaman->status,
            $peminjaman->keterangan ?: '-',
        ];
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet;

                /*
                |--------------------------------------------------
                | Ruang Header
                |--------------------------------------------------
                */

                $sheet->insertNewRowBefore(1, 7);

                /*
                |--------------------------------------------------
                | Judul
                |--------------------------------------------------
                */

                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'PERPUSTAKAAN HATUKAU');

                $sheet->mergeCells('A2:H2');
                $sheet->setCellValue('A2', 'LAPORAN DATA PEMINJAMAN BUKU');

                /*
                |--------------------------------------------------
                | Informasi Cetak
                |--------------------------------------------------
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
                |--------------------------------------------------
                | Style Judul
                |--------------------------------------------------
                */

                $sheet->getStyle('A1:H2')->applyFromArray([

                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],

                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ]

                ]);

                /*
                |--------------------------------------------------
                | Header Tabel
                |--------------------------------------------------
                */

                $sheet->getStyle('A8:H8')->applyFromArray([

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
                |--------------------------------------------------
                | Border
                |--------------------------------------------------
                */

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A8:H{$lastRow}")
                    ->applyFromArray([
 
                        'borders' => [

                            'allBorders' => [

                                'borderStyle' => Border::BORDER_THIN,

                            ]

                        ]

                    ]);

                /*
                |--------------------------------------------------
                | Alignment
                |--------------------------------------------------
                */

                $sheet->getStyle("A8:A{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getStyle("E8:G{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);

            }

        ];
    }
}