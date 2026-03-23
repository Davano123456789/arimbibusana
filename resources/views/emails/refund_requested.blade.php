<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Permintaan Refund Baru - {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        h1 { margin-top: 0; color: #5B3A29; font-size: 24px; }
        .badge { display: inline-block; background: #dc2626; color: white; padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-bottom: 10px; }
        .info-box { background: #fef2f2; border-left: 4px solid #dc2626; border-radius: 0 8px 8px 0; padding: 16px 20px; margin: 20px 0; }
        .info-box .label { font-size: 12px; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; }
        .info-box .value { font-size: 15px; font-weight: bold; color: #1f2937; margin-top: 3px; }
        .details { margin-bottom: 25px; }
        .details th { text-align: left; color: #6b7280; font-size: 13px; text-transform: uppercase; padding-right: 20px; padding-bottom: 8px; }
        .details td { font-weight: bold; padding-bottom: 8px; }
        .bank-box { background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 16px 20px; margin: 15px 0; }
        .bank-box h3 { margin: 0 0 10px; color: #0369a1; font-size: 14px; }
        .bank-box p { margin: 4px 0; font-size: 14px; }
        .btn { display: inline-block; background: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; font-size: 13px; color: #9ca3af; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arimbi Queen</h1>
            <div class="badge">⚠️ Permintaan Refund Baru</div>
            <p style="margin: 5px 0 0; color: #6b7280;">Ada pelanggan yang mengajukan pengembalian dana.</p>
        </div>

        <p>Halo, <strong>Admin</strong>!</p>
        <p>Pelanggan berikut telah mengajukan permintaan pengembalian dana untuk pesanan <strong>{{ $order->order_number }}</strong>. Mohon segera ditindaklanjuti.</p>

        <div class="details">
            <table>
                <tr>
                    <th>Nomor Pesanan</th>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Nama Pelanggan</th>
                    <td>{{ $order->customer_name }}</td>
                </tr>
                <tr>
                    <th>Total Pesanan</th>
                    <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="info-box">
            <div class="label">Alasan Pengajuan Refund</div>
            <div class="value">{{ $order->cancel_reason ?? 'Tidak ada alasan yang diberikan.' }}</div>
        </div>

        <div class="bank-box">
            <h3>💳 Rekening Tujuan Transfer Refund</h3>
            <p><strong>Bank:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
            <p><strong>No. Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
            <p><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
        </div>

        <p style="font-size: 14px; color: #6b7280;">Silakan transfer dana sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke rekening di atas, lalu unggah bukti transfernya di dashboard admin.</p>

        <center>
            <a href="{{ url('/dashboard/orders/' . $order->id) }}" class="btn">Buka Detail Pesanan di Dashboard</a>
        </center>

        <div class="footer">
            Email ini dikirim otomatis oleh sistem Arimbi Queen saat ada permintaan refund masuk.
        </div>
    </div>
</body>
</html>
