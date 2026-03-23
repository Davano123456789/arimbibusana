<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Paket Dikirim - {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        h1 { margin-top: 0; color: #5B3A29; font-size: 24px; }
        .badge { display: inline-block; background: #16a34a; color: white; padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-bottom: 10px; }
        .resi-box { background: #f0fdf4; border: 2px dashed #16a34a; border-radius: 8px; padding: 20px; text-align: center; margin: 25px 0; }
        .resi-box .label { font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .resi-box .number { font-size: 28px; font-weight: bold; color: #15803d; letter-spacing: 4px; margin: 8px 0; }
        .resi-box .courier { font-size: 13px; color: #4b5563; }
        .details { margin-bottom: 25px; }
        .details th { text-align: left; color: #6b7280; font-size: 13px; text-transform: uppercase; padding-right: 20px; padding-bottom: 5px; }
        .details td { font-weight: bold; padding-bottom: 8px; }
        .steps { background: #f9fafb; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .steps h3 { margin-top: 0; color: #5B3A29; font-size: 15px; }
        .steps ol { padding-left: 20px; margin: 0; }
        .steps li { padding: 4px 0; font-size: 14px; color: #374151; }
        .btn { display: inline-block; background: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; font-size: 13px; color: #9ca3af; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arimbi Queen</h1>
            <div class="badge">🚚 Paket Dalam Perjalanan</div>
            <p style="margin: 5px 0 0; color: #6b7280;">Hore! Pesanan Anda sudah kami kirimkan.</p>
        </div>

        <p>Halo, <strong>{{ $order->customer_name }}</strong>!</p>
        <p>Kabar baik! Pesanan <strong>{{ $order->order_number }}</strong> Anda sudah dalam perjalanan menuju alamat Anda. Berikut nomor resi pengiriman Anda:</p>

        <div class="resi-box">
            <div class="label">Nomor Resi Pengiriman</div>
            <div class="number">{{ $order->tracking_number }}</div>
            <div class="courier">Kurir: <strong>{{ strtoupper($order->courier) }}</strong></div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Nomor Pesanan</th>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Alamat Tujuan</th>
                    <td>{{ $order->customer_address }}, {{ $order->city_name }}, {{ $order->province_name }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dikirim</th>
                    <td>{{ $order->shipped_at ? \Carbon\Carbon::parse($order->shipped_at)->format('d M Y, H:i') : now()->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <div class="steps">
            <h3>📦 Langkah Selanjutnya:</h3>
            <ol>
                <li>Salin nomor resi di atas.</li>
                <li>Kunjungi website kurir <strong>{{ strtoupper($order->courier) }}</strong> untuk melacak paket secara real-time.</li>
                <li>Setelah paket sampai, jangan lupa tekan tombol <strong>"Pesanan Diterima"</strong> di akun Anda.</li>
            </ol>
        </div>

        <center>
            <a href="{{ url('/pesanan') }}" class="btn">Lihat Status Pesanan</a>
        </center>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem Arimbi Queen.<br>
            Jika ada pertanyaan, hubungi kami melalui WhatsApp atau Instagram kami.
        </div>
    </div>
</body>
</html>
