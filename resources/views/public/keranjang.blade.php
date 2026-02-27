@extends('layouts.masterPublic')

@section('title', 'Keranjang Belanja — Arimbi Queen')
@section('description', 'Keranjang belanja Anda di Arimbi Queen.')

@section('head')
    <style>
        :root {
            --cream: #F5ECE0;
            --dark-cream: #E8D9C5;
            --cream-dark: #B78A58;
            --accent: #5B3A29;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        .text-accent { color: var(--accent); }
        .bg-cream-dark { background-color: var(--cream-dark); }
        .border-accent { border-color: var(--accent); }

        .btn-cream-dark {
            background-color: var(--cream-dark);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .btn-cream-dark:hover {
            filter: brightness(0.9);
            transform: translateY(-2px);
        }

        /* Quantity Input Hide Arrows */
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
    </style>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ url('/') }}" class="hover:text-accent">Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-900 font-medium">Keranjang Belanja</li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 font-serif">Keranjang Belanja</h1>

        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Cart Items List -->
            <div class="flex-1">
                <!-- Cart Header (Desktop) -->
                <div class="hidden md:grid grid-cols-12 gap-4 border-b border-gray-200 pb-4 mb-6 text-sm font-bold text-gray-500 uppercase tracking-wider">
                    <div class="col-span-6">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-2 text-right">Total</div>
                </div>

                <!-- Cart Item 1 -->
                <div class="cart-item grid grid-cols-1 md:grid-cols-12 gap-6 items-center border-b border-gray-100 py-6">
                    <!-- Product Info -->
                    <div class="col-span-1 md:col-span-6 flex gap-4">
                        <div class="w-24 h-32 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                            <img src="{{ asset('images/produk1.jpg') }}" alt="Koleksi Tunik Premium" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-bold text-gray-900 text-lg mb-1 font-serif">Koleksi Tunik Premium</h4>
                            <p class="text-sm text-gray-500 mb-2">Ukuran: <span class="font-medium text-gray-900">M</span></p>
                            <button class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors w-fit">
                                <i class="fa-regular fa-trash-can"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Price (Desktop) -->
                    <div class="hidden md:block col-span-2 text-center text-gray-900 font-medium">
                        Rp 245.000
                    </div>

                    <!-- Quantity -->
                    <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-center">
                        <span class="md:hidden text-sm font-medium text-gray-500">Jumlah:</span>
                        <div class="flex items-center border border-gray-300 rounded-lg bg-white h-10 w-fit">
                            <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-minus"><i class="fa-solid fa-minus text-xs"></i></button>
                            <input type="number" value="1" min="1" class="w-10 text-center border-none focus:ring-0 text-gray-900 font-bold p-0 text-sm appearance-none bg-transparent qty-input" readonly />
                            <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-plus"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-end">
                         <span class="md:hidden text-sm font-medium text-gray-500">Total:</span>
                        <span class="font-bold text-accent">Rp 245.000</span>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="cart-item grid grid-cols-1 md:grid-cols-12 gap-6 items-center border-b border-gray-100 py-6">
                    <div class="col-span-1 md:col-span-6 flex gap-4">
                        <div class="w-24 h-32 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                            <img src="{{ asset('images/busana5.jpg') }}" alt="Gamis Polos Exclusive" class="w-full h-full object-cover">
                        </div>
                        <div class="flex flex-col justify-center">
                            <h4 class="font-bold text-gray-900 text-lg mb-1 font-serif">Gamis Polos Exclusive</h4>
                            <p class="text-sm text-gray-500 mb-2">Ukuran: <span class="font-medium text-gray-900">L</span></p>
                            <button class="text-xs text-red-500 hover:text-red-700 flex items-center gap-1 transition-colors w-fit">
                                <i class="fa-regular fa-trash-can"></i> Hapus
                            </button>
                        </div>
                    </div>
                    <div class="hidden md:block col-span-2 text-center text-gray-900 font-medium">
                        Rp 285.000
                    </div>
                    <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-center">
                        <span class="md:hidden text-sm font-medium text-gray-500">Jumlah:</span>
                        <div class="flex items-center border border-gray-300 rounded-lg bg-white h-10 w-fit">
                            <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-minus"><i class="fa-solid fa-minus text-xs"></i></button>
                            <input type="number" value="1" min="1" class="w-10 text-center border-none focus:ring-0 text-gray-900 font-bold p-0 text-sm appearance-none bg-transparent qty-input" readonly />
                            <button class="w-8 h-full flex items-center justify-center text-gray-500 hover:text-accent transition-colors btn-plus"><i class="fa-solid fa-plus text-xs"></i></button>
                        </div>
                    </div>
                    <div class="col-span-1 md:col-span-2 flex items-center justify-between md:justify-end">
                        <span class="md:hidden text-sm font-medium text-gray-500">Total:</span>
                        <span class="font-bold text-accent">Rp 285.000</span>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ url('/produk') }}" class="text-sm font-medium text-gray-500 hover:text-accent flex items-center gap-2 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-96">
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 sticky top-24">
                    <h3 class="font-serif text-xl font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-gray-900">Rp 530.000</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Diskon</span>
                            <span class="font-medium text-green-600">- Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Estimasi Pengiriman</span>
                            <span class="text-xs text-gray-400 italic">Dihitung saat checkout</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-8">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="font-bold text-2xl text-accent">Rp 530.000</span>
                    </div>

                    <a href="{{ url('/pembayaran') }}" 
                       class="w-full btn-cream-dark py-4 rounded-xl font-bold flex items-center justify-center gap-3 shadow-lg hover:shadow-xl transition-all active:scale-95 block text-center">
                        <i class="fa-solid fa-credit-card fa-lg"></i> Checkout
                    </a>
                    
                    <p class="text-[10px] text-gray-400 text-center mt-4 leading-relaxed">
                        <i class="fa-solid fa-lock mr-1"></i> Pembayaran aman & terpercaya
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Quantity Logic (Mock)
    document.querySelectorAll('.btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            let val = parseInt(input.value);
            if (val > 1) {
                input.value = val - 1;
                // Update logic would go here (AJAX or just UI update)
            }
        });
    });

    document.querySelectorAll('.btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            let val = parseInt(input.value);
            input.value = val + 1;
            // Update logic would go here
        });
    });
</script>
@endsection