<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pesanan {{ $order->order_number }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #5B3A29; font-size: 24px; }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .details { margin-bottom: 30px; }
        .details th { text-align: left; color: #6b7280; font-size: 13px; text-transform: uppercase; padding-right: 20px; padding-bottom: 5px; }
        .details td { font-weight: bold; }
        .item-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .item-table th, .item-table td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        .item-table th { background: #f9fafb; color: #4b5563; font-size: 13px; text-transform: uppercase; }
        .totals { width: 100%; }
        .totals td { padding: 8px 12px; text-align: right; }
        .totals .final { font-weight: bold; font-size: 18px; color: #5B3A29; border-top: 2px solid #e5e7eb; padding-top: 15px; }
        .footer { text-align: center; font-size: 13px; color: #9ca3af; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Arimbi Queen</h1>
            <p style="margin: 0; color: #6b7280;">Hatur nuhun atas pesanan Anda!</p>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Invoice No</th>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <td>{{ $order->updated_at ? $order->updated_at->format('d M Y, H:i') : now()->format('d M Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Pelanggan</th>
                    <td>{{ $order->customer_name }} ({{ $order->customer_phone }})</td>
                </tr>
                <tr>
                    <th>Alamat Pengiriman</th>
                    <td>{{ $order->customer_address }}, {{ $order->city_name }}, {{ $order->province_name }}</td>
                </tr>
            </table>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product ? $item->product->name : 'Produk' }}<br>
                        <span style="font-size: 12px; color: #6b7280;">Size: {{ $item->size_name ?? '-' }}</span>
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals">
            <tr>
                <td style="width: 50%;"></td>
                <td style="color: #6b7280;">Subtotal</td>
                <td style="font-weight: bold;">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td style="color: #6b7280;">Ongkos Kirim ({{ strtoupper($order->courier) }})</td>
                <td style="font-weight: bold;">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td></td>
                <td class="final">Total Dibayar</td>
                <td class="final">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="footer">
            Ini adalah invoice / bukti pembayaran sah otomatis yang diterbitkan oleh sistem Arimbi Queen.<br>
            Silakan simpan email ini sebagai referensi pesanan Anda.
        </div>
    </div>
</body>
</html>
