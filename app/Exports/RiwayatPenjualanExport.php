<?php
namespace App\Exports;

use App\Models\PenjualanDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles; // Untuk styling
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk lebar kolom otomatis
use Maatwebsite\Excel\Concerns\WithColumnFormatting; // Untuk format angka/IDR
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RiwayatPenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithColumnFormatting
{
    protected $from, $to;

    public function __construct($from = null, $to = null)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return PenjualanDetail::with(['barang', 'penjualan'])
            ->when($this->from && $this->to, function($query) {
                $query->whereBetween('created_at', [$this->from.' 00:00:00', $this->to.' 23:59:59']);
            })
            ->latest()
            ->get();
    }

    public function headings(): array
    {
        return ["No. Nota", "Nama Pembeli", "Tanggal", "Nama Barang", "Qty", "Harga Satuan", "Subtotal"];
    }

    public function map($trx): array
    {
        return [
            "#TRX-" . $trx->penjualan_id,
            $trx->penjualan->nama_pembeli ?? 'Umum',
            $trx->created_at->format('d/m/Y H:i'),
            $trx->barang->nama_barang ?? 'Produk Dihapus',
            $trx->qty,
            $trx->harga,
            $trx->subtotal,
        ];
    }

    // 1. Format Mata Uang untuk Kolom F dan G (Harga & Subtotal)
    public function columnFormats(): array
    {
        return [
            'F' => '"Rp "#,##0',
            'G' => '"Rp "#,##0',
        ];
    }

    // 2. Desain Header & Border
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk Baris 1 (Header)
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4CAF50'] // Warna Hijau ala Kasir
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
            // Memberikan border ke seluruh cell yang ada datanya
            'A1:G' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}