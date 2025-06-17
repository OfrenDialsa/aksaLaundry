<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Bulanan - {{ $bulan }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #333;
            padding: 24px;
        }

        .header {
            background-color: #e0f2fe;
            padding: 24px;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 32px;
        }

        h2 {
            margin: 0;
            font-size: 22px;
            color: #0284c7;
        }

        .section {
            margin-bottom: 14px;
            font-weight: 600;
        }

        .section span {
            display: block;
            font-weight: normal;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
            font-size: 12px;
        }

        th {
            background-color: #bae6fd;
            color: #075985;
            text-align: left;
            padding: 10px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .highlight {
            background-color: #f0f9ff;
        }

        .total-row td {
            font-weight: bold;
            background-color: #e0f7fa;
        }

        .total-semua {
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 16px;
            padding-top: 12px;
            border-top: 2px solid #ccc;
        }

        .footer {
            text-align: center;
            font-size: 11px;
            color: #777;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Invoice Bulanan - AksaLaundry</h2>
        <p>Nama: {{ $user->name }}</p>
        <p>Periode: {{ $bulan }}</p>
    </div>

    @php
        $grandTotal = 0;
        $hargaSatuan = $harga['satuan'] ?? [];
        $hargaKiloan = $harga['kiloan'] ?? 0;
    @endphp

    @foreach ($orders as $order)
        @php $orderTotal = 0; @endphp

        <div class="section">
            Order #{{ $order->id }} &mdash; Tanggal: {{ $order->created_at->format('d M Y') }}
            <span>Order Id: {{ $order->midtrans_order_id ?? '-' }}</span>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @if ($order->type === 'satuan')
                    @foreach (['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur'] as $item)
                        @php $jumlah = $order->$item; @endphp
                        @if ($jumlah)
                            @php
                                $hargaItem = $hargaSatuan[$item] ?? 0;
                                $subtotal = $hargaItem * $jumlah;
                                $orderTotal += $subtotal;
                            @endphp
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $item)) }}</td>
                                <td>{{ $jumlah }} pcs</td>
                                <td>Rp {{ number_format($hargaItem, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    @php
                        $subtotal = $order->weight * $hargaKiloan;
                        $orderTotal += $subtotal;
                    @endphp
                    <tr>
                        <td>Berat Laundry</td>
                        <td>{{ $order->weight }} kg</td>
                        <td>Rp {{ number_format($hargaKiloan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endif

                @if ($order->delivery_option === 'jemput')
                    @php
                        $biayaJemput = 4000;
                        $orderTotal += $biayaJemput;
                    @endphp
                    <tr class="highlight">
                        <td>Biaya Jemput</td>
                        <td colspan="2"></td>
                        <td>Rp {{ number_format($biayaJemput, 0, ',', '.') }}</td>
                    </tr>
                @endif

                <tr class="total-row">
                    <td colspan="3" style="text-align:right">Total</td>
                    <td>Rp {{ number_format($orderTotal, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @php $grandTotal += $orderTotal; @endphp
    @endforeach

    <div class="total-semua">
        Total Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}
    </div>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami bulan ini!</p>
    </div>
</body>
</html>
