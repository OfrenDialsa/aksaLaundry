<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Bulanan - {{ $bulan }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #333;
            padding: 40px;
            background-color: #f9fafb;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            text-align: center;
        }

        h2 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #0284c7;
        }

        p {
            font-size: 14px;
            color: #666;
            margin-top: 0;
        }

        .note {
            margin-top: 24px;
            font-size: 13px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Invoice Bulanan - AksaLaundry</h2>
        <p>Periode: {{ $bulan }}</p>
        <p>Tidak ada pesanan yang dibayar pada bulan ini.</p>

        <div class="note">
            Terima kasih telah menggunakan layanan kami.
        </div>
    </div>
</body>
</html>
