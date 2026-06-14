<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Label - {{ $order->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        @media print {
            body {
                background-color: white;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
            .print-area {
                border: none !important;
                box-shadow: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-10 text-gray-900">

    <!-- Action Buttons Bar (Hidden when printing) -->
    <div class="max-w-2xl mx-auto mb-6 flex justify-between items-center px-4 sm:px-0 no-print">
        <button onclick="window.close()" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border shadow-sm transition-colors text-sm font-medium">
            <i class="fa-solid fa-xmark"></i> Tutup Halaman
        </button>
        <button onclick="window.print()" class="flex items-center gap-2 bg-[#5B3A29] hover:bg-[#4a2e20] text-white px-5 py-2.5 rounded-lg shadow-md transition-colors text-sm font-bold">
            <i class="fa-solid fa-print"></i> Mulai Cetak
        </button>
    </div>

    <!-- Print Area / Label Sheet -->
    <div class="max-w-2xl mx-auto bg-white border border-gray-300 rounded-xl shadow-lg p-6 print-area">
        
        <!-- Header -->
        <div class="flex justify-between items-center border-b-2 border-dashed border-gray-400 pb-4 mb-6">
            <div>
                <h1 class="text-xl font-extrabold text-[#5B3A29] uppercase tracking-wider">Arimbi Queen</h1>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Label Pengiriman</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400 font-bold">NO. INVOICE</p>
                <p class="text-sm font-black text-gray-900">{{ $order->order_number }}</p>
                <p class="text-[10px] text-gray-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Shipping details columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
            <!-- Receiver -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-red-600 d-block mb-2"><i class="fa-solid fa-location-dot"></i> PENERIMA (DEPAN):</span>
                <p class="font-extrabold text-gray-900 text-base mb-1">{{ $order->customer_name }}</p>
                <p class="font-bold text-gray-800 text-sm mb-2"><i class="fa-solid fa-phone text-xs"></i> {{ $order->customer_phone }}</p>
                <p class="text-xs text-gray-700 leading-relaxed font-medium">
                    {{ $order->customer_address }}<br>
                    <span class="font-bold text-gray-900">{{ $order->district_name }}, {{ $order->city_name }}, {{ $order->province_name }} (KODE POS: {{ $order->customer_postal_code }})</span>
                </p>
            </div>

            <!-- Sender -->
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 flex flex-col justify-between">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-gray-500 d-block mb-2"><i class="fa-solid fa-store"></i> PENGIRIM:</span>
                    <p class="font-extrabold text-gray-900 text-sm mb-1">Arimbi Queen Store</p>
                    <p class="text-xs text-gray-700 font-medium"><i class="fa-solid fa-phone text-xs"></i> 0812-3456-7890</p>
                    <p class="text-xs text-gray-500 mt-1">Surabaya, Jawa Timur</p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <span class="text-[9px] text-gray-400 font-bold uppercase block">EKSPEDISI</span>
                        <span class="text-sm font-black uppercase text-accent tracking-wider">{{ $order->courier }}</span>
                    </div>
                    @if($order->tracking_number)
                    <div class="text-right">
                        <span class="text-[9px] text-gray-400 font-bold uppercase block">NO. RESI</span>
                        <span class="text-sm font-mono font-bold text-gray-900">{{ $order->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="border border-gray-200 rounded-lg overflow-hidden mb-6">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="py-2.5 px-4 text-[10px] tracking-wider uppercase text-gray-500 font-extrabold">Nama Barang / Deskripsi</th>
                        <th class="py-2.5 px-4 text-[10px] tracking-wider uppercase text-gray-500 font-extrabold text-center">Variasi</th>
                        <th class="py-2.5 px-4 text-[10px] tracking-wider uppercase text-gray-500 font-extrabold text-center">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-xs">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="py-3 px-4 font-bold text-gray-900">
                            {{ $item->product ? $item->product->name : 'Produk' }}
                        </td>
                        <td class="py-3 px-4 text-center text-gray-700 font-medium">
                            @if($item->size_name || $item->color_name)
                                {{ $item->size_name ?? '-' }} / {{ $item->color_name ?? '-' }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="py-3 px-4 text-center font-extrabold text-gray-900">
                            {{ $item->quantity }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Notes / Remarks -->
        @if($order->notes)
        <div class="bg-yellow-50/50 border border-yellow-200 p-4 rounded-lg">
            <span class="text-[9px] font-extrabold uppercase tracking-wider text-yellow-700 d-block mb-1"><i class="fa-solid fa-sticky-note"></i> Catatan Pembeli:</span>
            <p class="text-xs text-yellow-900 leading-relaxed font-medium italic">"{{ $order->notes }}"</p>
        </div>
        @endif

        <div class="mt-8 text-center text-[10px] text-gray-400 border-t border-gray-200 pt-4">
            <p>Terima kasih telah berbelanja di Arimbi Queen. Hubungi kami jika ada kendala pengiriman.</p>
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Auto open print dialog
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
