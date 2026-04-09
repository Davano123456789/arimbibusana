<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        h1, h2, h3 { font-family: 'Playfair Display', serif; }
        @media print {
            body { background-color: white; }
            .no-print { display: none !important; }
            .print-container { box-shadow: none !important; padding: 0 !important; margin: 0 !important; max-width: 100% !important; border: none !important; }
        }
    </style>
</head>
<body class="py-10 text-gray-800">

    <div class="max-w-4xl mx-auto print-container pt-4 px-4 sm:px-0">
        <!-- Actions -->
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ url('/pesanan') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border shadow-sm transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="flex items-center gap-2 bg-[#5B3A29] hover:bg-[#4a2e20] text-white px-5 py-2 rounded-lg shadow-md transition-colors">
                <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
            </button>
        </div>

        <!-- Invoice Paper -->
        <div class="bg-white rounded-xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 sm:p-12 overflow-hidden relative">
            
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-50 rounded-bl-[100px] -z-10 opacity-50"></div>

            <div class="flex flex-col sm:flex-row justify-between items-start gap-6 border-b border-gray-100 pb-8 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-[#5B3A29] mb-1">Arimbi Queen</h1>
                    <p class="text-sm text-gray-500">Cerminan Wanita Anggun & Sopan</p>
                </div>
                <div class="text-left sm:text-right">
                    <h2 class="text-4xl font-black text-gray-200 tracking-wider mb-2">INVOICE</h2>
                    <p class="text-sm font-semibold text-gray-800">{{ $order->order_number }}</p>
                    <p class="text-sm text-gray-500">Tanggal: {{ $order->updated_at ? $order->updated_at->format('d M Y') : now()->format('d M Y') }}</p>
                    @php
                        $statusData = [
                            'unpaid' => ['label' => 'MENUNGGU PEMBAYARAN', 'class' => 'bg-orange-100 text-orange-700 border-orange-200'],
                            'pending' => ['label' => 'MENUNGGU PEMBAYARAN', 'class' => 'bg-orange-100 text-orange-700 border-orange-200'],
                            'settlement' => ['label' => 'LUNAS', 'class' => 'bg-green-100 text-green-700 border-green-200'],
                            'shipped' => ['label' => 'SEDANG DIKIRIM', 'class' => 'bg-blue-100 text-blue-700 border-blue-200'],
                            'completed' => ['label' => 'SELESAI', 'class' => 'bg-teal-100 text-teal-700 border-teal-200'],
                            'cancel' => ['label' => 'DIBATALKAN', 'class' => 'bg-red-100 text-red-700 border-red-200'],
                            'expire' => ['label' => 'KADALUARSA', 'class' => 'bg-gray-100 text-gray-700 border-gray-200'],
                            'waiting_refund' => ['label' => 'MENUNGGU REFUND', 'class' => 'bg-purple-100 text-purple-700 border-purple-200'],
                        ];
                        $currentStatus = $statusData[$order->status] ?? ['label' => strtoupper($order->status), 'class' => 'bg-gray-100 text-gray-700 border-gray-200'];
                    @endphp
                    <span class="inline-block mt-3 px-3 py-1 font-bold text-xs rounded-full uppercase tracking-widest border {{ $currentStatus['class'] }}">
                        {{ $currentStatus['label'] }}
                    </span>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-10">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">Ditagihkan Kepada:</p>
                    <p class="font-bold text-gray-800 text-lg">{{ $order->customer_name }}</p>
                    <p class="text-sm text-gray-600 mb-1 flex items-center gap-2"><i class="fa-solid fa-phone text-xs text-gray-400 w-4"></i> {{ $order->customer_phone }}</p>
                    @if($order->user)
                    <p class="text-sm text-gray-600 flex items-center gap-2"><i class="fa-solid fa-envelope text-xs text-gray-400 w-4"></i> {{ $order->user->email }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">Alamat Pengiriman:</p>
                    <p class="text-sm text-gray-600 leading-relaxed max-w-sm">
                        {{ $order->customer_address }}<br>
                        {{ $order->city_name }}, {{ $order->province_name }}
                    </p>
                    <p class="text-sm text-gray-600 mt-2 font-medium">Kurir: <span class="uppercase text-gray-900">{{ $order->courier }}</span></p>
                </div>
            </div>

            <!-- Items -->
            <div class="overflow-x-auto mb-8 relative">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="py-3 px-4 text-xs tracking-wider uppercase text-gray-500 font-bold rounded-l-lg border-y border-l border-gray-200">Produk</th>
                            <th class="py-3 px-4 text-xs tracking-wider uppercase text-gray-500 font-bold text-center border-y border-gray-200">Kuantitas</th>
                            <th class="py-3 px-4 text-xs tracking-wider uppercase text-gray-500 font-bold text-right border-y border-gray-200">Harga Satuan</th>
                            <th class="py-3 px-4 text-xs tracking-wider uppercase text-gray-500 font-bold text-right rounded-r-lg border-y border-r border-gray-200">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="py-4 px-4 align-top">
                                <p class="font-bold text-gray-800">{{ $item->product ? $item->product->name : 'Produk' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Ukuran: {{ $item->size_name ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-4 text-center text-gray-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="py-4 px-4 text-right text-gray-600">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-right font-semibold text-gray-800">
                                Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-6 border-t border-gray-200 pt-6">
                <div class="text-sm text-gray-500 max-w-sm">
                    <p class="font-bold text-gray-700 mb-1">Catatan :</p>
                    <p>{{ $order->notes ?: 'Terima kasih telah berbelanja di Arimbi Queen. Pesanan Anda segera kami proses.' }}</p>
                </div>
                
                <div class="w-full sm:w-auto min-w-[250px]">
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal Produk</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->total_price - $order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600 pb-3 border-b border-gray-100">
                            <span>Ongkos Kirim</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-lg mt-2">
                            <span class="font-bold text-gray-900">Total Tagihan</span>
                            <span class="font-black text-[#5B3A29] text-xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-16 text-center border-t border-gray-100 pt-8 no-print">
                <p class="text-xs text-gray-400">Invoice Sah diterbitkan secara elektronik oleh sistem Arimbi Queen.</p>
            </div>
        </div>
    </div>

</body>
</html>
