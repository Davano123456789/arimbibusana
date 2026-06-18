<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan {{ $order->order_number }}</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #FDF8F3; color: #2D2522; margin: 0; padding: 0; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%;">
    <table width="100%" cellspacing="0" cellpadding="0" style="background-color: #FDF8F3; padding: 40px 20px; table-layout: fixed; width: 100%;">
        <tr>
            <td align="center" style="padding: 0;">
                <div style="max-width: 600px; width: 100%; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(91, 58, 41, 0.05); border: 1px solid rgba(91, 58, 41, 0.08); text-align: left;">
                    
                    <!-- Header -->
                    <div style="background-color: #ffffff; text-align: center; padding: 40px 30px 20px; border-bottom: 1px dashed #F5ECE0;">
                        <img src="{{ asset('images/logo-arimbi.png') }}" alt="Arimbi Queen Logo" style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 0; outline: none; text-decoration: none; margin-bottom: 12px; display: inline-block;">
                        <h1 style="font-family: 'Playfair Display', Georgia, serif; font-size: 24px; font-weight: 700; color: #5B3A29; margin: 0 0 4px; letter-spacing: 2px; text-transform: uppercase;">Arimbi Queen</h1>
                        <p style="font-size: 11px; color: #B78A58; margin: 0; letter-spacing: 3px; text-transform: uppercase; font-weight: 600;">Anggun • Sopan • Percaya Diri</p>
                    </div>

                    <!-- Content -->
                    <div style="padding: 40px 35px;">
                        <div style="margin-bottom: 25px;">
                            <h2 style="font-size: 18px; font-weight: 700; color: #5B3A29; margin: 0; display: inline-block; vertical-align: middle;">Invoice Pembayaran #{{ $order->order_number }}</h2>
                            <span style="display: inline-block; background-color: #E8F5E9; color: #2E7D32; font-size: 12px; font-weight: bold; padding: 6px 14px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px; margin-left: 10px; vertical-align: middle;">Lunas</span>
                        </div>

                        <p style="margin-top: 0; margin-bottom: 25px; font-size: 14px; color: #7A655F; line-height: 1.5;">
                            Terima kasih atas pesanan Anda! Pembayaran Anda telah kami terima dan pesanan akan segera diproses untuk pengiriman. Berikut rincian transaksi Anda:
                        </p>

                        <!-- Transaksi Details -->
                        <table style="width: 100%; margin-bottom: 30px;" cellspacing="0" cellpadding="0">
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 6px 0; width: 35%;">Tanggal Pembayaran</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 6px 0;">{{ $order->updated_at ? $order->updated_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 6px 0;">Nama Penerima</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 6px 0;">{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 6px 0;">No. Telepon / WA</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 6px 0;">{{ $order->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 6px 0; vertical-align: top;">Alamat Pengiriman</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 6px 0; line-height: 1.4;">{{ $order->customer_address }}, {{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }} ({{ $order->customer_postal_code }})</td>
                            </tr>
                        </table>

                        <!-- Item Table -->
                        <table style="width: 100%; margin-bottom: 30px;" cellspacing="0" cellpadding="0">
                            <thead>
                                <tr>
                                    <th style="background-color: #FAF6F0; color: #5B3A29; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px; text-align: left;">Produk</th>
                                    <th style="background-color: #FAF6F0; color: #5B3A29; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px; text-align: center; width: 15%;">Jumlah</th>
                                    <th style="background-color: #FAF6F0; color: #5B3A29; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; padding: 12px; text-align: right; width: 25%;">Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td style="padding: 16px 12px; border-bottom: 1px solid #FAF6F0; font-size: 14px;">
                                        <div style="font-weight: bold; color: #2D2522; margin-bottom: 4px;">{{ $item->product ? $item->product->name : 'Produk Arimbi' }}</div>
                                        <div style="font-size: 12px; color: #8E7A74;">Size: {{ $item->size_name ?? '-' }}</div>
                                    </td>
                                    <td style="padding: 16px 12px; border-bottom: 1px solid #FAF6F0; font-size: 14px; text-align: center; font-weight: bold;">{{ $item->quantity }}</td>
                                    <td style="padding: 16px 12px; border-bottom: 1px solid #FAF6F0; font-size: 14px; text-align: right; font-weight: bold; color: #5B3A29;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
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
                        <table style="width: 100%; margin-top: 20px; margin-bottom: 10px;" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding: 8px 12px; font-size: 14px; color: #7A655F; text-align: right; width: 60%;">Subtotal Produk</td>
                                <td style="padding: 8px 12px; font-size: 14px; text-align: right; font-weight: bold; color: #2D2522;">Rp {{ number_format($subtotalProducts, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td style="padding: 8px 12px; font-size: 14px; color: #7A655F; text-align: right;">Ongkos Kirim ({{ strtoupper($order->courier) }})</td>
                                <td style="padding: 8px 12px; font-size: 14px; text-align: right; font-weight: bold; color: #2D2522;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            @if($order->points_discount > 0)
                            <tr>
                                <td style="padding: 8px 12px; font-size: 14px; color: #2E7D32; text-align: right;">Potongan Poin ({{ number_format($order->points_used, 0, ',', '.') }} Poin)</td>
                                <td style="padding: 8px 12px; font-size: 14px; text-align: right; font-weight: bold; color: #2E7D32;">-Rp {{ number_format($order->points_discount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="font-size: 16px; font-weight: bold; color: #5B3A29; border-top: 2px solid #F5ECE0; padding: 15px 12px 8px; text-align: right;">Total Dibayar</td>
                                <td style="font-size: 20px; font-weight: 800; color: #5B3A29; border-top: 2px solid #F5ECE0; padding: 15px 12px 8px; text-align: right;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div style="background-color: #FDFBF8; text-align: center; padding: 30px; font-size: 12px; color: #8E7A74; border-top: 1px solid #F5ECE0;">
                        <p style="margin: 0 0 10px;">Ini adalah bukti pembayaran sah dari sistem <strong>Arimbi Queen</strong>.</p>
                        <p style="margin: 0 0 15px;">Jika Anda memiliki pertanyaan tentang pesanan ini, hubungi kami di <a href="https://wa.me/628123456789" target="_blank" style="color: #5B3A29; text-decoration: none; font-weight: bold;">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} <strong>Arimbi Queen</strong>. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
