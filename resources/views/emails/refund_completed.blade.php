<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refund Selesai — {{ $order->order_number }}</title>
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
        .refund-title-row {
            margin-bottom: 25px;
            text-align: center;
        }
        .refund-title {
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
            margin-top: 8px;
        }
        .amount-card {
            background-color: #FAF6F0;
            border: 2px solid #B78A58;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 30px 0;
        }
        .amount-label {
            font-size: 11px;
            font-weight: bold;
            color: #8E7A74;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }
        .amount-value {
            font-size: 28px;
            font-weight: 800;
            color: #5B3A29;
            margin: 8px 0;
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
            padding: 8px 0;
            width: 35%;
        }
        .details-table td {
            font-size: 14px;
            font-weight: 700;
            color: #2D2522;
            padding: 8px 0;
        }
        .bank-card {
            background-color: #FDFBF8;
            border: 1px solid #FAF6F0;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
        }
        .bank-card h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 13px;
            color: #5B3A29;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bank-card p {
            margin: 6px 0;
            font-size: 14px;
            color: #7A655F;
        }
        .button-wrapper {
            text-align: center;
            margin: 35px 0;
        }
        .btn {
            display: inline-block;
            background-color: #5B3A29;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(91, 58, 41, 0.2);
            transition: all 0.3s ease;
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
                        <div class="refund-title-row">
                            <h2 class="refund-title">Refund Selesai Diproses</h2>
                            <span class="status-badge">✅ Selesai</span>
                        </div>

                        <p style="margin-top: 0; font-size: 14px; color: #7A655F; line-height: 1.6; text-align: center;">
                            Halo, **{{ $order->customer_name }}**! Kami ingin mengabarkan bahwa permintaan pengembalian dana (*refund*) Anda untuk pesanan **#{{ $order->order_number }}** telah berhasil selesai diproses.
                        </p>

                        <!-- Amount Card -->
                        <div class="amount-card">
                            <div class="amount-label">Jumlah Dana yang Dikembalikan</div>
                            <div class="amount-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        </div>

                        <!-- Transaksi Details -->
                        <table class="details-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Nomor Pesanan</th>
                                <td>#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Diproses</th>
                                <td>{{ now()->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        <!-- Bank Details -->
                        <div class="bank-card">
                            <h3>🏦 Rekening Tujuan Transfer</h3>
                            <p><strong>Bank:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
                            <p><strong>Nomor Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
                        </div>

                        <p style="font-size: 13px; color: #8E7A74; line-height: 1.6; margin-bottom: 25px; text-align: center;">
                            Dana telah kami transfer ke rekening tertera. Mohon periksa saldo rekening Anda secara berkala. Apabila dana belum masuk dalam 1x24 jam, Anda dapat membalas email ini atau menghubungi CS kami.
                        </p>

                        <!-- CTA Button -->
                        <div class="button-wrapper">
                            <a href="{{ url('/pesanan') }}" class="btn" target="_blank">Lihat Riwayat Pesanan</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0 0 10px;">Terima kasih atas kesabaran Anda. Semoga kami dapat melayani Anda kembali di lain kesempatan. 💖</p>
                        <p style="margin: 0 0 15px;">Butuh bantuan? Hubungi CS kami di <a class="social-link" href="https://wa.me/628123456789" target="_blank">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} **Arimbi Queen**. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
