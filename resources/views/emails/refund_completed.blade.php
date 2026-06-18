<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Selesai — {{ $order->order_number }}</title>
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
                        <div style="margin-bottom: 25px; text-align: center;">
                            <h2 style="font-size: 18px; font-weight: 700; color: #5B3A29; margin: 0; display: inline-block; vertical-align: middle;">Refund Selesai Diproses</h2>
                            <br>
                            <span style="display: inline-block; background-color: #E8F5E9; color: #2E7D32; font-size: 12px; font-weight: bold; padding: 6px 14px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 8px; vertical-align: middle;">✅ Selesai</span>
                        </div>

                        <p style="margin-top: 0; font-size: 14px; color: #7A655F; line-height: 1.6; text-align: center;">
                            Halo, <strong>{{ $order->customer_name }}</strong>! Kami ingin mengabarkan bahwa permintaan pengembalian dana (<em>refund</em>) Anda untuk pesanan <strong>#{{ $order->order_number }}</strong> telah berhasil selesai diproses.
                        </p>

                        <!-- Amount Card -->
                        <div style="background-color: #FAF6F0; border: 2px solid #B78A58; border-radius: 12px; padding: 24px; text-align: center; margin: 30px 0;">
                            <div style="font-size: 11px; font-weight: bold; color: #8E7A74; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px;">Jumlah Dana yang Dikembalikan</div>
                            <div style="font-size: 28px; font-weight: 800; color: #5B3A29; margin: 8px 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>

                        <!-- Transaksi Details -->
                        <table style="width: 100%; margin-bottom: 30px;" cellspacing="0" cellpadding="0">
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 8px 0; width: 35%;">Nomor Pesanan</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 8px 0;">#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 8px 0;">Tanggal Diproses</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 8px 0;">{{ now()->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        <!-- Bank Details -->
                        <div style="background-color: #FDFBF8; border: 1px solid #FAF6F0; border-radius: 12px; padding: 20px; margin: 25px 0;">
                            <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 13px; color: #5B3A29; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">🏦 Rekening Tujuan Transfer</h3>
                            <p style="margin: 6px 0; font-size: 14px; color: #7A655F;"><strong>Bank:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
                            <p style="margin: 6px 0; font-size: 14px; color: #7A655F;"><strong>Nomor Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
                        </div>

                        <p style="font-size: 13px; color: #8E7A74; line-height: 1.6; margin-bottom: 25px; text-align: center;">
                            Dana telah kami transfer ke rekening tertera. Mohon periksa saldo rekening Anda secara berkala. Apabila dana belum masuk dalam 1x24 jam, Anda dapat membalas email ini atau menghubungi CS kami.
                        </p>

                        <!-- CTA Button -->
                        <div style="text-align: center; margin: 35px 0;">
                            <a href="{{ url('/pesanan') }}" target="_blank" style="display: inline-block; background-color: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; letter-spacing: 0.5px; border: 0;">Lihat Riwayat Pesanan</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div style="background-color: #FDFBF8; text-align: center; padding: 30px; font-size: 12px; color: #8E7A74; border-top: 1px solid #F5ECE0;">
                        <p style="margin: 0 0 10px;">Terima kasih atas kesabaran Anda. Semoga kami dapat melayani Anda kembali di lain kesempatan. 💖</p>
                        <p style="margin: 0 0 15px;">Butuh bantuan? Hubungi CS kami di <a href="https://wa.me/628123456789" target="_blank" style="color: #5B3A29; text-decoration: none; font-weight: bold;">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} <strong>Arimbi Queen</strong>. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
