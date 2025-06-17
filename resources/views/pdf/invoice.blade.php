<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            background-color: #e0f2fe;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #0ea5e9;
        }

        .info {
            text-align: center;
            font-size: 13px;
            color: #555;
        }

        .section {
            margin-bottom: 20px;
        }

        .section p {
            margin: 5px 0;
        }

        .section strong {
            display: inline-block;
            width: 180px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th {
            background-color: #bae6fd;
            text-align: left;
            padding: 8px;
            font-weight: 600;
            font-size: 12px;
            color: #0c4a6e;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #ccc;
        }

        .total {
            text-align: right;
            font-size: 14px;
            font-weight: bold;
            margin-top: 12px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 11px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Invoice AksaLaundry</h2>
        <div class="info">
            <p>{{ $order->midtrans_order_id }}</p>
            <p>Tanggal Pemesanan: {{ $order->created_at->format('d M Y') }}</p>
        </div>
    </div>
    @php
        $statusPembayaran = match ($order->status_pembayaran) {
            'unpaid' => 'Belum Bayar',
            'pending' => 'Menunggu',
            'paid' => 'Lunas',
            default => ucfirst($order->status_pembayaran),
        };

    @endphp

    <div class="section">
        <p><strong>Nama Pelanggan:</strong> {{ $order->name }}</p>
        <p><strong>Jenis Layanan:</strong> {{ ucfirst($order->type) }} -
            {{ str_replace('_', ' + ', $order->service_type) }}
        </p>
        <p><strong>Pengantaran:</strong> {{ ucfirst($order->delivery_option) }}</p>
        <p><strong>Status Pesanan:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Status Pembayaran:</strong> {{ $statusPembayaran }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $harga = [
                    'satuan' => [
                        'cuci' => [
                            'baju' => 5000,
                            'celana' => 6000,
                            'jaket' => 8000,
                            'gaun' => 10000,
                            'sprey_kasur' => 12000,
                        ],
                        'setrika' => [
                            'baju' => 3000,
                            'celana' => 4000,
                            'jaket' => 5000,
                            'gaun' => 6000,
                            'sprey_kasur' => 8000,
                        ],
                    ],
                    'kiloan' => [
                        'cuci' => 16000,
                        'setrika' => 12000,
                    ],
                ];

                $total = 0;
            @endphp

            @if ($order->type === 'satuan')
                @foreach (['baju', 'celana', 'jaket', 'gaun', 'sprey_kasur'] as $item)
                    @if ($order->$item)
                        @php
                            $jumlah = $order->$item;
                            $serviceTypes = explode('_', $order->service_type);
                            $subtotal = 0;

                            foreach ($serviceTypes as $service) {
                                $hargaSatuan = $harga['satuan'][$service][$item] ?? 0;
                                $subtotal += $hargaSatuan * $jumlah;
                            }

                            $total += $subtotal;
                        @endphp
                        <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $item)) }}</td>
                            <td>{{ $jumlah }} pcs</td>
                            <td>
                                @foreach ($serviceTypes as $service)
                                    Rp {{ number_format($harga['satuan'][$service][$item] ?? 0, 0, ',', '.') }}
                                    ({{ ucfirst($service) }})<br>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @endforeach
            @else
                @php
                    $serviceTypes = explode('_', $order->service_type);
                    $subtotal = 0;
                    foreach ($serviceTypes as $service) {
                        $hargaPerKg = $harga['kiloan'][$service] ?? 0;
                        $subtotal += $hargaPerKg * $order->weight;
                    }
                    $total = $subtotal;
                @endphp
                <tr>
                    <td>Berat Laundry</td>
                    <td>{{ $order->weight }} kg</td>
                    <td>
                        @foreach ($serviceTypes as $service)
                            Rp {{ number_format($harga['kiloan'][$service] ?? 0, 0, ',', '.') }} /kg
                            ({{ ucfirst($service) }})<br>
                        @endforeach
                    </td>
                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>

            @endif
        </tbody>
        @if ($order->delivery_option === 'jemput')
            @php
                $biayaJemput = 4000;
            @endphp
            <tr>
                <td><strong>Biaya Jemput</strong></td>
                <td colspan="2"></td>
                <td>Rp {{ number_format($biayaJemput, 0, ',', '.') }}</td>
            </tr>
        @endif

        <tr>
            <td><strong>Total</strong></td>
            <td colspan="2"></td>
            <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami</p>
    </div>
</body>

</html>