<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Reservasi - {{ $reservation->reservation_code }}</title>
    <!-- FontAwesome untuk Icon (Opsional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            color: #000;
            margin: 0;
            padding: 20px;
            background-color: #f4f6f9;
        }

        /* Container Tombol Cetak & Kembali */
        .action-bar {
            max-width: 380px;
            margin: 0 auto 15px auto;
            display: flex;
            gap: 10px;
        }

        .btn-print {
            flex: 1;
            padding: 10px 15px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background 0.2s;
        }

        .btn-print:hover {
            background: #218838;
        }

        .btn-close-window {
            padding: 10px 15px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            text-decoration: none;
        }

        /* Kartu Struk Belanja */
        .receipt-card {
            max-width: 380px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 4px 0;
            vertical-align: top;
        }

        /* CSS Khusus Saat Mode Cetak/Print */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .action-bar {
                display: none; /* Sembunyikan tombol saat mencetak */
            }
            .receipt-card {
                border: none;
                box-shadow: none;
                padding: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- Tombol Aksi Atas -->
    <div class="action-bar">
        <button onclick="window.close()" class="btn-close-window">Tutup</button>
        <button onclick="window.print()" class="btn-print">
            <i class="fas fa-print"></i> Cetak Struk
        </button>
    </div>

    <!-- Tampilan Struk -->
    <div class="receipt-card">
        <div class="text-center">
            <h2 style="margin:0; font-size:18px;">SAVORA JUNCTION RESTO</h2>
            <p style="margin: 3px 0;">Jl. Kuliner No. 123, Resto City</p>
            <p style="margin: 3px 0;">Telp: 0838-7150-0590</p>
        </div>

        <div class="line"></div>

        <table>
            <tr>
                <td>Kode:</td>
                <td class="text-right"><strong>{{ $reservation->reservation_code }}</strong></td>
            </tr>
            <tr>
                <td>Nama:</td>
                <td class="text-right">{{ $reservation->name }}</td>
            </tr>
            <tr>
                <td>Tgl/Jam:</td>
                <td class="text-right">{{ date('d/m/Y', strtotime($reservation->reservation_date)) }} - {{ $reservation->reservation_time }}</td>
            </tr>
            <tr>
                <td>No. Meja:</td>
                <td class="text-right">Meja {{ $reservation->table_number }} ({{ $reservation->guest_count }} Orang)</td>
            </tr>
            <tr>
                <td>Status:</td>
                <td class="text-right">{{ strtoupper($reservation->status) }} ({{ strtoupper($reservation->payment_status) }})</td>
            </tr>
        </table>

        <div class="line"></div>

        <!-- Rincian Menu -->
        <table>
            <thead>
                <tr>
                    <th style="text-align:left;">Menu</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservation->details as $detail)
                    <tr>
                        <td>{{ $detail->menu->name ?? 'Menu Dihapus' }}</td>
                        <td class="text-center">{{ $detail->qty }}</td>
                        <td class="text-right">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Hanya Reservasi Meja</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="line"></div>

        <table>
            <tr>
                <td><strong>TOTAL TAGIHAN</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <div class="line"></div>

        <div class="text-center" style="margin-top:15px;">
            <p style="margin:2px 0;">~ Terima Kasih Atas Kunjungan Anda ~</p>
            <p style="margin:2px 0; font-size:11px; color:#555;">Simpan struk ini sebagai bukti reservasi</p>
        </div>
    </div>

</body>
</html>
