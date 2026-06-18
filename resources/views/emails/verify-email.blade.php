<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email Anda — Arimbi Queen</title>
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
                    <div style="padding: 40px 35px; line-height: 1.6; font-size: 15px; color: #2D2522;">
                        <p style="font-size: 18px; font-weight: 700; color: #5B3A29; margin-top: 0; margin-bottom: 15px;">Halo, {{ $name }}!</p>
                        <p style="margin: 0 0 15px;">Terima kasih telah melakukan pendaftaran di <strong>Arimbi Queen</strong>. Kami sangat senang menyambut Anda sebagai bagian dari komunitas kami yang menghargai busana anggun dan sopan.</p>
                        <p style="margin: 0 0 15px;">Untuk menyelesaikan pendaftaran Anda dan mulai berbelanja, silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>
                        
                        <div style="text-align: center; margin: 35px 0;">
                            <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #5B3A29; color: #ffffff !important; text-decoration: none; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 15px; letter-spacing: 0.5px; border: 0;">Verifikasi Email Saya</a>
                        </div>

                        <div style="background-color: #FAF6F0; border-left: 3px solid #B78A58; padding: 15px; border-radius: 0 8px 8px 0; margin: 25px 0; font-size: 13px; color: #7A655F; text-align: left;">
                            <strong>Penting:</strong> Tautan verifikasi email ini hanya berlaku selama <strong>60 menit</strong> sejak email ini dikirimkan.
                        </div>

                        <p style="margin: 0 0 15px;">Jika Anda merasa tidak melakukan pendaftaran di website kami, cukup abaikan email ini dan akun Anda akan tetap aman.</p>

                        <div style="height: 1px; background-color: #F5ECE0; margin: 30px 0;"></div>

                        <p style="font-size: 12px; color: #8E7A74; word-break: break-all; margin: 0; text-align: left;">
                            Jika Anda mengalami kendala dengan tombol di atas, salin dan tempel URL berikut ke browser Anda:<br>
                            <a href="{{ $url }}" target="_blank" style="color: #B78A58; text-decoration: underline;">{{ $url }}</a>
                        </p>
                    </div>

                    <!-- Footer -->
                    <div style="background-color: #FDFBF8; text-align: center; padding: 30px; font-size: 12px; color: #8E7A74; border-top: 1px solid #F5ECE0;">
                        <p style="margin: 0 0 10px;">Butuh bantuan? Hubungi kami melalui WhatsApp di <a href="https://wa.me/628123456789" target="_blank" style="color: #5B3A29; text-decoration: none; font-weight: bold;">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} <strong>Arimbi Queen</strong>. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
