<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan {{ $order->order_number }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #FDF8F3;
            color: #2D2522;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        table, td {
            border-collapse: collapse;
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #FDF8F3;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(91, 58, 41, 0.05);
            border: 1px solid rgba(91, 58, 41, 0.08);
        }
        .header {
            background-color: #ffffff;
            text-align: center;
            padding: 40px 30px 20px;
            border-bottom: 1px dashed #F5ECE0;
        }
        .logo {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-cover;
            box-shadow: 0 4px 10px rgba(91, 58, 41, 0.15);
            margin-bottom: 12px;
        }
        .brand-name {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 24px;
            font-weight: 700;
            color: #5B3A29;
            margin: 0 0 4px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .brand-slogan {
            font-size: 11px;
            color: #B78A58;
            margin: 0;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 600;
        }
        .content {
            padding: 40px 35px;
        }
        .invoice-title-row {
            margin-bottom: 25px;
        }
        .invoice-title {
            font-size: 18px;
            font-weight: 700;
            color: #5B3A29;
            margin: 0;
        }
        .status-badge {
            display: inline-block;
            background-color: #E8F5E9;
            color: #2E7D32;
            font-size: 12px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 5px;
        }
        .details-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .details-table th {
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #8E7A74;
            letter-spacing: 0.5px;
            padding: 6px 0;
            width: 35%;
        }
        .details-table td {
            font-size: 14px;
            font-weight: 700;
            color: #2D2522;
            padding: 6px 0;
        }
        .item-table {
            width: 100%;
            margin-bottom: 30px;
        }
        .item-table th {
            background-color: #FAF6F0;
            color: #5B3A29;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px;
            text-align: left;
        }
        .item-table td {
            padding: 16px 12px;
            border-bottom: 1px solid #FAF6F0;
            font-size: 14px;
        }
        .item-name {
            font-weight: bold;
            color: #2D2522;
            margin-bottom: 4px;
        }
        .item-meta {
            font-size: 12px;
            color: #8E7A74;
        }
        .totals-table {
            width: 100%;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .totals-table td {
            padding: 8px 12px;
            font-size: 14px;
        }
        .totals-table .label {
            color: #7A655F;
            text-align: right;
            width: 60%;
        }
        .totals-table .value {
            text-align: right;
            font-weight: bold;
            color: #2D2522;
        }
        .totals-table .discount {
            color: #2E7D32;
        }
        .totals-table .final-label {
            font-size: 16px;
            font-weight: bold;
            color: #5B3A29;
            border-top: 2px solid #F5ECE0;
            padding-top: 15px;
            text-align: right;
        }
        .totals-table .final-value {
            font-size: 20px;
            font-weight: 800;
            color: #5B3A29;
            border-top: 2px solid #F5ECE0;
            padding-top: 15px;
            text-align: right;
        }
        .divider {
            height: 1px;
            background-color: #F5ECE0;
            margin: 30px 0;
        }
        .footer {
            background-color: #FDFBF8;
            text-align: center;
            padding: 30px;
            font-size: 12px;
            color: #8E7A74;
            border-top: 1px solid #F5ECE0;
        }
        .social-link {
            color: #5B3A29;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table class="wrapper" width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center">
                <div class="container">
                    <!-- Header -->
                    <div class="header">
                        <img class="logo" src="{{ asset('images/logo-arimbi.png') }}" alt="Arimbi Queen Logo">
                        <h1 class="brand-name">Arimbi Queen</h1>
                        <p class="brand-slogan">Anggun • Sopan • Percaya Diri</p>
                    </div>

                    <!-- Content -->
                    <div class="content">
                        <div class="invoice-title-row">
                            <h2 class="invoice-title">Invoice Pembayaran #{{ $order->order_number }}</h2>
                            <span class="status-badge">Lunas</span>
                        </div>

                        <p style="margin-top: 0; margin-bottom: 25px; font-size: 14px; color: #7A655F;">
                            Terima kasih atas pesanan Anda! Pembayaran Anda telah kami terima dan pesanan akan segera diproses untuk pengiriman. Berikut rincian transaksi Anda:
                        </p>

                        <!-- Transaksi Details -->
                        <table class="details-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Tanggal Pembayaran</th>
                                <td>{{ $order->updated_at ? $order->updated_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <th>Nama Penerima</th>
                                <td>{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>No. Telepon / WA</th>
                                <td>{{ $order->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Pengiriman</th>
                                <td>{{ $order->customer_address }}, {{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }} ({{ $order->customer_postal_code }})</td>
                            </tr>
                        </table>

                        <!-- Item Table -->
                        <table class="item-table" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th style="text-align: center; width: 15%;">Jumlah</th>
                                    <th style="text-align: right; width: 25%;">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="item-name">{{ $item->product ? $item->product->name : 'Produk Arimbi' }}</div>
                                        <div class="item-meta">Size: {{ $item->size_name ?? '-' }}</div>
                                    </td>
                                    <td style="text-align: center; font-weight: bold;">{{ $item->quantity }}</td>
                                    <td style="text-align: right; font-weight: bold; color: #5B3A29;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @php
                            $subtotalProducts = $order->items->sum(function($item) {
                                return $item->price * $item->quantity;
                            });
                        @endphp

                        <!-- Totals -->
                        <table class="totals-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <td class="label">Subtotal Produk</td>
                                <td class="value">Rp {{ number_format($subtotalProducts, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Ongkos Kirim ({{ strtoupper($order->courier) }})</td>
                                <td class="value">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            @if($order->points_discount > 0)
                            <tr>
                                <td class="label discount">Potongan Poin ({{ number_format($order->points_used, 0, ',', '.') }} Poin)</td>
                                <td class="value discount">-Rp {{ number_format($order->points_discount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="final-label">Total Dibayar</td>
                                <td class="final-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0 0 10px;">Ini adalah bukti pembayaran sah dari sistem **Arimbi Queen**.</p>
                        <p style="margin: 0 0 15px;">Jika Anda memiliki pertanyaan tentang pesanan ini, hubungi kami di <a class="social-link" href="https://wa.me/628123456789" target="_blank">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} **Arimbi Queen**. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
