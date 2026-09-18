<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReservationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    private $rowNumber = 0;

    public function collection()
    {
        return Reservation::latest()->get();
    }

    // Header Kolom Excel
    public function headings(): array
    {
        return [
            'No',
            'Kode Reservasi',
            'Nama Pelanggan',
            'No. WhatsApp',
            'Tanggal Kedatangan',
            'Jam Kedatangan',
            'Meja',
            'Total Bayar',
            'Jumlah Tamu',
            'Status',
        ];
    }

    // Pemetaan Data per Baris
    public function map($reservation): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $reservation->code ?? $reservation->reservation_code ?? '-',
            $reservation->name ?? $reservation->customer_name ?? '-',
            $reservation->phone ?? $reservation->phone_number ?? $reservation->whatsapp ?? '-',
            $reservation->reservation_date ? date('d-m-Y', strtotime($reservation->reservation_date)) : '-',
            $reservation->reservation_time ? date('H:i', strtotime($reservation->reservation_time)) . ' WIB' : '-',
            is_object($reservation->table) ? 'Meja No. ' . $reservation->table->number : ($reservation->table_number ?? '-'),
            'Rp ' . number_format($reservation->total_price ?? $reservation->total_amount ?? 0, 0, ',', '.'),
            ($reservation->people_count ?? $reservation->guest_count ?? $reservation->guests ?? 0) . ' Tamu',
            ucfirst($reservation->status),
        ];
    }

    // Pewarnaan & Styling Tabel Excel
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow(); // Menghitung total baris data
        $highestColumn = 'J';                  // Kolom terakhir (A sampai J)

        // 1. Styling Header (Baris Pertama)
        $sheet->getStyle("A1:{$highestColumn}1")->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => '000000'], // Warna Teks Hitam
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC107'], // Warna Kuning khas Savora (#FFC107)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. Memberikan Border & Alignment ke Seluruh Tabel
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'D3D3D3'], // Border Abu-abu Tipis
                ],
            ],
        ]);

        // 3. Meratakan Teks Kolom (Center / Right)
        $sheet->getStyle("A2:A{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // No
        $sheet->getStyle("B2:B{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Kode
        $sheet->getStyle("E2:F{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tanggal & Jam
        $sheet->getStyle("G2:G{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Meja
        $sheet->getStyle("H2:H{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);  // Total Bayar
        $sheet->getStyle("I2:J{$highestRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER); // Tamu & Status

        // Tinggi baris header agar lebih lega
        $sheet->getRowDimension(1)->setRowHeight(28);

        return [];
    }
}
