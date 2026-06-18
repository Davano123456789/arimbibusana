<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Dikirim — {{ $order->order_number }}</title>
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
        .shipped-title-row {
            margin-bottom: 25px;
            text-align: center;
        }
        .shipped-title {
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
        .resi-card {
            background-color: #FAF6F0;
            border: 2px dashed #B78A58;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin: 30px 0;
        }
        .resi-label {
            font-size: 11px;
            font-weight: bold;
            color: #8E7A74;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }
        .resi-number {
            font-size: 24px;
            font-weight: 800;
            color: #5B3A29;
            letter-spacing: 2px;
            margin: 8px 0;
        }
        .resi-courier {
            font-size: 13px;
            color: #7A655F;
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
            width: 30%;
        }
        .details-table td {
            font-size: 14px;
            font-weight: 700;
            color: #2D2522;
            padding: 8px 0;
        }
        .steps-box {
            background-color: #FDFBF8;
            border: 1px solid #FAF6F0;
            border-radius: 12px;
            padding: 20px 25px;
            margin: 25px 0;
        }
        .steps-box h3 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 14px;
            color: #5B3A29;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .steps-box ol {
            padding-left: 20px;
            margin: 0;
            font-size: 13px;
            color: #7A655F;
        }
        .steps-box li {
            margin-bottom: 8px;
            line-height: 1.5;
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
                        <div class="shipped-title-row">
                            <h2 class="shipped-title">Paket Dalam Perjalanan</h2>
                            <span class="status-badge">🚚 Dikirim</span>
                        </div>

                        <p style="margin-top: 0; font-size: 14px; color: #7A655F; line-height: 1.6; text-align: center;">
                            Kabar gembira, **{{ $order->customer_name }}**! Pesanan Anda **#{{ $order->order_number }}** telah diserahkan kepada kurir pengiriman dan saat ini sedang dalam perjalanan menuju lokasi Anda.
                        </p>

                        <!-- Tracking Box -->
                        <div class="resi-card">
                            <div class="resi-label">Nomor Resi Pengiriman</div>
                            <div class="resi-number">{{ $order->tracking_number }}</div>
                            <div class="resi-courier">Kurir: <strong>{{ strtoupper($order->courier) }}</strong></div>
                        </div>

                        <!-- Transaksi Details -->
                        <table class="details-table" cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Nomor Pesanan</th>
                                <td>#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th>Alamat Tujuan</th>
                                <td>{{ $order->customer_address }}, {{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }} ({{ $order->customer_postal_code }})</td>
                            </tr>
                            <tr>
                                <th>Tanggal Dikirim</th>
                                <td>{{ $order->shipped_at ? \Carbon\Carbon::parse($order->shipped_at)->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</td>
                            </tr>
                        </table>

                        <!-- Instructions -->
                        <div class="steps-box">
                            <h3>Langkah Selanjutnya</h3>
                            <ol>
                                <li>Salin nomor resi pengiriman di atas.</li>
                                <li>Lacak posisi paket secara berkala melalui website resmi kurir **{{ strtoupper($order->courier) }}**.</li>
                                <li>Setelah paket Anda terima dengan baik, mohon masuk ke akun Anda dan klik tombol **"Pesanan Diterima"**.</li>
                            </ol>
                        </div>

                        <!-- CTA Button -->
                        <div class="button-wrapper">
                            <a href="{{ url('/pesanan') }}" class="btn" target="_blank">Lihat Status Pesanan</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0 0 10px;">Email ini dikirim secara otomatis oleh sistem **Arimbi Queen**.</p>
                        <p style="margin: 0 0 15px;">Jika Anda memiliki kendala pengiriman, hubungi kami di <a class="social-link" href="https://wa.me/628123456789" target="_blank">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} **Arimbi Queen**. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
