@extends('layouts.masterPublic')

@section('title', 'Pembayaran — Arimbi Queen')
@section('description', 'Selesaikan pembayaran pesanan Anda di Arimbi Queen.')

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

        /* Custom Radio Button Styling */
        .payment-radio:checked + .payment-card {
            border-color: var(--accent);
            background-color: #FDF8F3;
            box-shadow: 0 4px 6px -1px rgba(91, 58, 41, 0.1), 0 2px 4px -1px rgba(91, 58, 41, 0.06);
        }

        .payment-radio:checked + .payment-card .check-icon {
            opacity: 1;
            transform: scale(1);
        }
    </style>
@endsection

@section('content')
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ url('/beranda') }}" class="hover:text-accent">Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li><a href="{{ url('/keranjang') }}" class="hover:text-accent">Keranjang</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-900 font-medium">Pembayaran</li>
            </ol>
        </nav>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-8 font-serif">Pembayaran</h1>

        <form action="#" method="POST" class="flex flex-col lg:flex-row gap-12">
            @csrf
            <!-- Left Column: Shipping & Payment Info -->
            <div class="flex-1 space-y-10">
                
                <!-- Shipping Information -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-cream-dark text-white flex items-center justify-center text-sm">1</span>
                        Informasi Pengiriman
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-user text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <input type="text" id="name" name="name" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200" 
                                    placeholder="Masukkan nama lengkap penerima" required>
                            </div>
                        </div>
                        
                        <!-- Nomor Telepon -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / Telepon</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-gray-400 group-focus-within:text-accent transition-colors text-lg"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200" 
                                    placeholder="Contoh: 08123456789" required>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                            <div class="relative group">
                                <div class="absolute top-3.5 left-4 flex items-start pointer-events-none">
                                    <i class="fa-solid fa-location-dot text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <textarea id="address" name="address" rows="3" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 resize-none" 
                                    placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, patokan..." required></textarea>
                            </div>
                        </div>

                        <!-- Kota / Kecamatan -->
                        <div>
                            <label for="city" class="block text-sm font-bold text-gray-700 mb-2">Kota / Kecamatan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-city text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <input type="text" id="city" name="city" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200" 
                                    placeholder="Contoh: Jakarta Selatan" required>
                            </div>
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">Kode Pos</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-envelopes-bulk text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <input type="text" id="postal_code" name="postal_code" 
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200" 
                                    placeholder="Contoh: 12345">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Payment Method -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-cream-dark text-white flex items-center justify-center text-sm">2</span>
                        Metode Pembayaran
                    </h2>

                    <div class="space-y-4">
                        <!-- Transfer Bank -->
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment_method" value="transfer" class="peer sr-only payment-radio" checked>
                            <div class="payment-card p-5 rounded-xl border border-gray-200 hover:border-accent/50 transition-all bg-white flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <i class="fa-solid fa-building-columns text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">Transfer Bank</h4>
                                        <p class="text-sm text-gray-500">BCA, Mandiri, BRI, BNI</p>
                                    </div>
                                </div>
                                <div class="check-icon w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center opacity-0 transform scale-75 transition-all">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </div>
                            </div>
                        </label>

                        <!-- E-Wallet -->
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment_method" value="ewallet" class="peer sr-only payment-radio">
                            <div class="payment-card p-5 rounded-xl border border-gray-200 hover:border-accent/50 transition-all bg-white flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
                                        <i class="fa-solid fa-wallet text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">E-Wallet (QRIS)</h4>
                                        <p class="text-sm text-gray-500">GoPay, OVO, Dana, ShopeePay</p>
                                    </div>
                                </div>
                                <div class="check-icon w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center opacity-0 transform scale-75 transition-all">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </div>
                            </div>
                        </label>

                        <!-- COD -->
                        <label class="relative block cursor-pointer group">
                            <input type="radio" name="payment_method" value="cod" class="peer sr-only payment-radio">
                            <div class="payment-card p-5 rounded-xl border border-gray-200 hover:border-accent/50 transition-all bg-white flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                                        <i class="fa-solid fa-money-bill-wave text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900">Bayar di Tempat (COD)</h4>
                                        <p class="text-sm text-gray-500">Bayar tunai saat kurir datang</p>
                                    </div>
                                </div>
                                <div class="check-icon w-6 h-6 rounded-full bg-accent text-white flex items-center justify-center opacity-0 transform scale-75 transition-all">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </div>
                            </div>
                        </label>
                    </div>
                </section>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="w-full lg:w-96 flex-shrink-0">
                <div class="bg-gray-50 p-6 rounded-2xl sticky top-24 border border-gray-200">
                    <h3 class="font-bold text-xl text-gray-900 mb-6 font-serif">Ringkasan Pesanan</h3>
                    
                    <!-- Items Preview -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        <div class="flex gap-3">
                            <div class="w-16 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ asset('images/produk1.jpg') }}" alt="Produk" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">Koleksi Tunik Premium</h4>
                                <p class="text-xs text-gray-500 mt-1">Size: M | Qty: 1</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Rp 245.000</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-16 h-20 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ asset('images/produk2.jpg') }}" alt="Produk" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 text-sm">Gamis Floral Modern</h4>
                                <p class="text-xs text-gray-500 mt-1">Size: L | Qty: 1</p>
                                <p class="font-semibold text-gray-900 text-sm mt-1">Rp 285.000</p>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal (2 Barang)</span>
                            <span>Rp 530.000</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="text-green-600 font-medium">Gratis</span>
                        </div>
                        <div class="border-t border-dashed border-gray-300 my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900 text-lg">Total</span>
                            <span class="font-bold text-2xl text-accent">Rp 530.000</span>
                        </div>
                    </div>

                    <button type="button" onclick="confirmOrder()" class="w-full btn-cream-dark py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
                        Buat Pesanan
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                    
                    <p class="text-xs text-center text-gray-400 mt-4">
                        <i class="fa-solid fa-lock mr-1"></i> Data Anda terenkripsi dengan aman.
                    </p>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmOrder() {
            // Simple validation check
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;

            if (!name || !phone || !address) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi informasi pengiriman Anda terlebih dahulu.',
                    confirmButtonColor: '#5B3A29'
                });
                return;
            }

            Swal.fire({
                title: 'Konfirmasi Pesanan?',
                text: "Pastikan data pesanan Anda sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5B3A29',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pesan Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Pesanan Berhasil!',
                        text: 'Terima kasih telah berbelanja di Arimbi Queen. Kami akan menghubungi Anda via WhatsApp untuk konfirmasi selanjutnya.',
                        icon: 'success',
                        confirmButtonColor: '#5B3A29'
                    }).then(() => {
                        window.location.href = "{{ url('/') }}";
                    });
                }
            });
        }
    </script>
@endsection