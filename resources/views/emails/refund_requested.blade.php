<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Refund Baru — {{ $order->order_number }}</title>
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
                            <h2 style="font-size: 18px; font-weight: 700; color: #5B3A29; margin: 0; display: inline-block; vertical-align: middle;">Permintaan Refund Baru</h2>
                            <br>
                            <span style="display: inline-block; background-color: #FFEBEE; color: #C62828; font-size: 12px; font-weight: bold; padding: 6px 14px; border-radius: 30px; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 8px; vertical-align: middle;">⚠️ Perlu Tindakan</span>
                        </div>

                        <p style="margin-top: 0; font-size: 14px; color: #7A655F; line-height: 1.6;">
                            Halo, <strong>Admin</strong>! Ada pengajuan pengembalian dana (<em>refund</em>) baru yang diajukan oleh pelanggan berikut. Harap segera ditindaklanjuti.
                        </p>

                        <!-- Transaksi Details -->
                        <table style="width: 100%; margin-bottom: 30px;" cellspacing="0" cellpadding="0">
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 8px 0; width: 35%;">Nomor Pesanan</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 8px 0;">#{{ $order->order_number }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 8px 0;">Nama Pelanggan</th>
                                <td style="font-size: 14px; font-weight: 700; color: #2D2522; padding: 8px 0;">{{ $order->customer_name }}</td>
                            </tr>
                            <tr>
                                <th style="text-align: left; font-size: 12px; text-transform: uppercase; color: #8E7A74; letter-spacing: 0.5px; padding: 8px 0;">Total Dana Refund</th>
                                <td style="font-size: 14px; font-weight: 700; color: #C62828; padding: 8px 0;">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            </tr>
                        </table>

                        <!-- Alasan Refund -->
                        <div style="background-color: #FFF8F8; border-left: 4px solid #C62828; border-radius: 0 12px 12px 0; padding: 20px; margin: 25px 0;">
                            <div style="font-size: 11px; font-weight: bold; color: #A38C84; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Alasan Pengajuan Refund</div>
                            <div style="font-size: 14px; font-weight: bold; color: #2D2522; line-height: 1.5;">{{ $order->cancel_reason ?? 'Tidak ada alasan yang diberikan.' }}</div>
                        </div>

                        <!-- Info Rekening -->
                        <div style="background-color: #F0F9FF; border: 1px solid #B3E5FC; border-radius: 12px; padding: 20px; margin: 25px 0;">
                            <h3 style="margin-top: 0; margin-bottom: 12px; font-size: 14px; color: #0288D1; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px;">💳 Rekening Tujuan Pengiriman Dana</h3>
                            <p style="margin: 6px 0; font-size: 14px; color: #2D2522;"><strong>Bank Penerima:</strong> {{ strtoupper($order->refund_bank ?? '-') }}</p>
                            <p style="margin: 6px 0; font-size: 14px; color: #2D2522;"><strong>Nomor Rekening:</strong> {{ $order->refund_account_number ?? '-' }}</p>
                            <p style="margin: 6px 0; font-size: 14px; color: #2D2522;"><strong>Atas Nama:</strong> {{ $order->customer_name }}</p>
                        </div>

                        <p style="font-size: 13px; color: #8E7A74; line-height: 1.5; margin-bottom: 25px;">
                            *Silakan lakukan transfer dana sebesar <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong> ke rekening tujuan di atas, kemudian masuk ke panel admin untuk mengunggah bukti transfer.*
                        </p>

                        <!-- CTA Button -->
                        <div style="text-align: center; margin: 35px 0;">
                            <a href="{{ url('/dashboard/orders/' . $order->id) }}" target="_blank" style="display: inline-block; background-color: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; letter-spacing: 0.5px; border: 0;">Buka Detail Pesanan</a>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div style="background-color: #FDFBF8; text-align: center; padding: 30px; font-size: 12px; color: #8E7A74; border-top: 1px solid #F5ECE0;">
                        <p style="margin: 0;">Email ini dikirim otomatis oleh sistem notifikasi otomatis <strong>Arimbi Queen</strong>.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
