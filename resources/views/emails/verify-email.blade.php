<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email Anda — Arimbi Queen</title>
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
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
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
            line-height: 1.6;
            font-size: 15px;
        }
        .greeting {
            font-size: 18px;
            font-weight: 700;
            color: #5B3A29;
            margin-top: 0;
            margin-bottom: 15px;
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
        .alert-box {
            background-color: #FAF6F0;
            border-left: 3px solid #B78A58;
            padding: 15px;
            border-radius: 0 8px 8px 0;
            margin: 25px 0;
            font-size: 13px;
            color: #7A655F;
        }
        .divider {
            height: 1px;
            background-color: #F5ECE0;
            margin: 30px 0;
        }
        .trouble {
            font-size: 12px;
            color: #8E7A74;
            word-break: break-all;
        }
        .trouble a {
            color: #B78A58;
            text-decoration: underline;
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
                        <p class="greeting">Halo, {{ $name }}!</p>
                        <p>Terima kasih telah melakukan pendaftaran di **Arimbi Queen**. Kami sangat senang menyambut Anda sebagai bagian dari komunitas kami yang menghargai busana anggun dan sopan.</p>
                        <p>Untuk menyelesaikan pendaftaran Anda dan mulai berbelanja, silakan klik tombol di bawah ini untuk memverifikasi alamat email Anda:</p>
                        
                        <div class="button-wrapper">
                            <a href="{{ $url }}" class="btn" target="_blank">Verifikasi Email Saya</a>
                        </div>

                        <div class="alert-box">
                            <strong>Penting:</strong> Tautan verifikasi email ini hanya berlaku selama <strong>60 menit</strong> sejak email ini dikirimkan.
                        </div>

                        <p>Jika Anda merasa tidak melakukan pendaftaran di website kami, cukup abaikan email ini dan akun Anda akan tetap aman.</p>

                        <div class="divider"></div>

                        <p class="trouble">
                            Jika Anda mengalami kendala dengan tombol di atas, salin dan tempel URL berikut ke browser Anda:<br>
                            <a href="{{ $url }}" target="_blank">{{ $url }}</a>
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class="footer">
                        <p style="margin: 0 0 10px;">Butuh bantuan? Hubungi kami melalui WhatsApp di <a class="social-link" href="https://wa.me/628123456789" target="_blank">+62 812-3456-789</a></p>
                        <p style="margin: 0;">&copy; {{ date('Y') }} **Arimbi Queen**. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
