<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Refund Baru — {{ $order->order_number }}</title>
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
            background-color: #FFEBEE;
            color: #C62828;
            font-size: 12px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 30px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }
        .info-card {
            background-color: #FFF8F8;
            border-left: 4px solid #C62828;
            border-radius: 0 12px 12px 0;
            padding: 20px;
            margin: 25px 0;
        }
        .info-label {
            font-size: 11px;
            font-weight: bold;
            color: #A38C84;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }
        .info-value {
            font-size: 14px;
            font-weight: bold;
            color: #2D2522;
            line-height: 1.5;
        }
        .bank-card {
            background-color: #F0F9FF;
            border: 1px solid #B3E5FC;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
        }
        .bank-card h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 14px;
            color: #0288D1;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bank-card p {
            margin: 6px 0;
            font-size: 14px;
            color: #2D2522;
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
                            <h2 class="refund-title">Permintaan Refund Baru</h2>
                            <span class="status-badge">⚠️ Perlu Tindakan</span>
                        </div>

                        <p style="margin-top: 0; font-size: 14px; color: #7A655F; line-height: 1.6;">
                            Halo, **Admin**! Ada pengajuan pengembalian dana (*refund*) baru yang diajukan oleh pelanggan berikut. Harap segera ditindaklanjuti.
                        </p>

                        <!-- Transaksi Details -->
                        <table class="details-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Nomor Pesanan</th>
                                <td>#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Nama Pelanggan</th>
                                <td>{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <th>Total Dana Refund</th>
                                <td style="color: #C62828;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>

                        <!-- Alasan Refund -->
                        <div class="info-card">
                            <div class="info-label">Alasan Pengajuan Refund</div>
                            <div class="info-value">{{ $order->cancel_reason ?? 'Tidak ada alasan yang diberikan.' }}</div>
                        </div>

                        <!-- Info Rekening -->
                        <div class="bank-card">
                            <h3>💳 Rekening Tujuan Pengiriman Dana</h3>
                            <p><strong>Bank Penerima:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
                            <p><strong>Nomor Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
                            <p><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
                        </div>

                        <p style="font-size: 13px; color: #8E7A74; line-height: 1.5; margin-bottom: 25px;">
                            *Silakan lakukan transfer dana sebesar **Rp {{ number_format($order->total_price, 0, ',', '.') }}** ke rekening tujuan di atas, kemudian masuk ke panel admin untuk mengunggah bukti transfer.*
                        </p>

                        <!-- CTA Button -->
                        <div class="button-wrapper">
                            <a href="{{ url('/dashboard/orders/' . $order->id) }}" class="btn" target="_blank">Buka Detail Pesanan</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0;">Email ini dikirim otomatis oleh sistem notifikasi otomatis **Arimbi Queen**.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
