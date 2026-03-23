<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Refund Selesai - {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        h1 { margin-top: 0; color: #5B3A29; font-size: 24px; }
        .badge { display: inline-block; background: #16a34a; color: white; padding: 6px 18px; border-radius: 20px; font-size: 13px; font-weight: bold; margin-bottom: 10px; }
        .amount-box { background: #f0fdf4; border: 2px solid #16a34a; border-radius: 8px; padding: 24px; text-align: center; margin: 25px 0; }
        .amount-box .label { font-size: 13px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .amount-box .amount { font-size: 32px; font-weight: bold; color: #15803d; margin: 8px 0; }
        .details { margin-bottom: 25px; }
        .details th { text-align: left; color: #6b7280; font-size: 13px; text-transform: uppercase; padding-right: 20px; padding-bottom: 8px; }
        .details td { font-weight: bold; padding-bottom: 8px; }
        .bank-box { background: #f9fafb; border-radius: 8px; padding: 16px 20px; margin: 15px 0; border: 1px solid #e5e7eb; }
        .bank-box h3 { margin: 0 0 10px; color: #374151; font-size: 14px; }
        .bank-box p { margin: 4px 0; font-size: 14px; color: #4b5563; }
        .btn { display: inline-block; background: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; font-size: 13px; color: #9ca3af; margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arimbi Queen</h1>
            <div class="badge">✅ Refund Berhasil Diproses</div>
            <p style="margin: 5px 0 0; color: #6b7280;">Dana Anda telah kami kembalikan.</p>
        </div>

        <p>Halo, <strong>{{ $order->customer_name }}</strong>!</p>
        <p>Kami ingin memberitahu bahwa proses pengembalian dana untuk pesanan <strong>{{ $order->order_number }}</strong> telah selesai dilakukan. Dana sudah kami transfer ke rekening yang Anda daftarkan.</p>

        <div class="amount-box">
            <div class="label">Jumlah Dana Dikembalikan</div>
            <div class="amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Nomor Pesanan</th>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Tanggal Diproses</th>
                    <td>{{ now()->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>
        </div>

        <div class="bank-box">
            <h3>🏦 Rekening yang Kami Transfer</h3>
            <p><strong>Bank:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
            <p><strong>No. Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
        </div>

        <p style="font-size: 14px; color: #6b7280;">Jika dana belum masuk dalam <strong>1x24 jam</strong>, silakan hubungi kami dengan menyertakan nomor pesanan <strong>{{ $order->order_number }}</strong> sebagai referensi.</p>

        <center>
            <a href="{{ url('/pesanan') }}" class="btn">Lihat Riwayat Pesanan</a>
        </center>

        <div class="footer">
            Terimakasih telah berbelanja di Arimbi Queen. Semoga kami bisa melayani Anda kembali! 💖<br>
            Email ini dikirim otomatis oleh sistem.
        </div>
    </div>
</body>
</html>
