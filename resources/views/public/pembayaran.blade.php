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

        h1,
        h2,
        h3,
        h4 {
            font-family: 'Playfair Display', serif;
        }

        .text-accent {
            color: var(--accent);
        }

        .bg-cream-dark {
            background-color: var(--cream-dark);
        }

        .border-accent {
            border-color: var(--accent);
        }

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
        .payment-radio:checked+.payment-card {
            border-color: var(--accent);
            background-color: #FDF8F3;
            box-shadow: 0 4px 6px -1px rgba(91, 58, 41, 0.1), 0 2px 4px -1px rgba(91, 58, 41, 0.06);
        }

        .payment-radio:checked+.payment-card .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--cream-dark);
            border-radius: 10px;
        }

        .ts-control {
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            border-color: #e5e7eb !important;
            transition: all 0.3s ease !important;
            background-color: #f9fafb !important;
            position: relative;
            z-index: 1;
        }

        .ts-control:focus {
            box-shadow: 0 0 0 4px rgba(91, 58, 41, 0.1) !important;
            border-color: #b78a58 !important;
            background-color: #ffffff !important;
        }

        .ts-dropdown {
            border-radius: 0.75rem !important;
            margin-top: 0.5rem !important;
            overflow: hidden !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            z-index: 100 !important;
            background-color: #ffffff !important;
            border: 1px solid #e5e7eb !important;
        }

        .ts-dropdown .active {
            background-color: #FDF8F3 !important;
            color: var(--accent) !important;
        }

        .ts-wrapper.disabled .ts-control {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            background-color: #f3f4f6 !important;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
@php
    $loyaltyStatus = \App\Models\Setting::getValue('loyalty_status', '0');
    $loyaltyPointValue = (int)\App\Models\Setting::getValue('loyalty_point_value', '100');
    $userPoints = Auth::check() ? Auth::user()->points : 0;
    $potentialDiscount = $userPoints * $loyaltyPointValue;
@endphp
    <div class="max-w-6xl mx-auto px-6 py-12">
        <!-- Breadcrumbs -->
        <nav class="flex text-sm text-gray-400 mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li><a href="{{ url('/') }}" class="hover:text-accent">Beranda</a></li>
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
                        <span
                            class="w-8 h-8 rounded-full bg-cream-dark text-white flex items-center justify-center text-sm">1</span>
                        Informasi Pengiriman
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-user text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                    placeholder="Masukkan nama lengkap penerima" required>
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp /
                                Telepon</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-brands fa-whatsapp text-gray-400 group-focus-within:text-accent transition-colors text-lg"></i>
                                </div>
                                <input type="tel" id="phone" name="phone"
                                    value="{{ old('phone', Auth::check() ? Auth::user()->phone : '') }}"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                    placeholder="Contoh: 08123456789" required>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                            <div class="relative group">
                                <div class="absolute top-3.5 left-4 flex items-start pointer-events-none">
                                    <i
                                        class="fa-solid fa-location-dot text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <textarea id="address" name="address" rows="3"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 resize-none"
                                    placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, patokan..." required>{{ old('address', Auth::check() ? Auth::user()->address : '') }}</textarea>
                            </div>
                        </div>

                        <!-- Provinsi -->
                        <div>
                            <label for="province" class="block text-sm font-bold text-gray-700 mb-2">Provinsi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-map text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="province" name="province_id"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer"
                                    required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                            <input type="hidden" id="province_name" name="province_name" value="{{ old('province_name', Auth::check() ? Auth::user()->province_name : '') }}">
                        </div>

                        <!-- Kota / Kabupaten -->
                        <div>
                            <label for="city_id" class="block text-sm font-bold text-gray-700 mb-2">Kota / Kabupaten</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-city text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="city_id" name="city_id"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled required>
                                    <option value="">Pilih Kota</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                            <input type="hidden" id="city_name" name="city_name" value="{{ old('city_name', Auth::check() ? Auth::user()->city_name : '') }}">
                        </div>

                        <!-- Kecamatan -->
                        <div>
                            <label for="district_id" class="block text-sm font-bold text-gray-700 mb-2">Kecamatan</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-location-dot text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="district_id" name="district_id"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                            <input type="hidden" id="district_name" name="district_name" value="{{ old('district_name', Auth::check() ? Auth::user()->district_name : '') }}">
                        </div>

                        <!-- Kode Pos -->
                        <div>
                            <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">Kode Pos</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-envelope text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <input type="text" id="postal_code" name="postal_code" maxlength="5"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    value="{{ old('postal_code', Auth::check() ? Auth::user()->postal_code : '') }}"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                    placeholder="Contoh: 60111" required>
                            </div>
                            <p id="postal_code_error" class="text-[10px] text-red-500 mt-1 font-bold italic hidden"></p>
                        </div>

                        <!-- Kurir Pengiriman -->
                        <div>
                            <label for="courier" class="block text-sm font-bold text-gray-700 mb-2">Kurir Pengiriman</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-truck text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="courier" name="courier"
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer"
                                    required>
                                    <option value="jne" selected>JNE</option>
                                    <option value="jnt">J&T</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i
                                        class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Shipping Metadata -->
                        <input type="hidden" id="shipping_cost_input" name="shipping_cost" value="0">
                        <input type="hidden" id="shipping_etd_input" name="shipping_etd" value="-">
                    </div>
                </section>

                <!-- Payment Method -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span
                            class="w-8 h-8 rounded-full bg-cream-dark text-white flex items-center justify-center text-sm">2</span>
                        Konfirmasi Pesanan
                    </h2>

                    <div class="bg-amber-50 border border-amber-100 p-6 rounded-2xl flex gap-4">
                        <div
                            class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-qrcode text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-amber-900 mb-1">Metode Pembayaran QRIS</h4>
                            <p class="text-sm text-amber-700 leading-relaxed text-light">
                                Setelah klik "Buat Pesanan", Anda akan melihat kode **QRIS** resmi toko kami. 
                                Silakan scan QRIS menggunakan aplikasi perbankan atau e-wallet Anda, selesaikan pembayaran, lalu unggah screenshot bukti transfer untuk konfirmasi.
                            </p>
                        </div>
                    </div>
                </section>
            </div>            <!-- Right Column: Order Summary -->
            <div class="w-full lg:w-96 flex-shrink-0">
                <div class="bg-gray-50 p-6 rounded-2xl sticky top-24 border border-gray-200">
                    <h3 class="font-bold text-xl text-gray-900 mb-6 font-serif">Ringkasan Pesanan</h3>

                    <!-- Items Preview -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200 h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                            <div class="flex gap-3">
                                <div class="w-16 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $item->product->images->sortByDesc('is_cover')->first()->image) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="{{ asset('images/no-image.jpg') }}" alt="No Image"
                                            class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 text-sm truncate">{{ $item->product->name }}</h4>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Size: {{ $item->size->size }} | Qty:
                                        {{ $item->quantity }}</p>
                                    <p class="font-semibold text-accent text-sm mt-1">Rp
                                        {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($loyaltyStatus == '1' && $userPoints > 0)
                        <!-- Loyalty Points Box -->
                        <div class="bg-amber-50/50 border border-amber-200/60 p-4 rounded-xl mb-6">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-coins text-amber-500"></i>
                                <span class="font-bold text-xs text-amber-800 uppercase tracking-wider">Poin Loyalitas</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-xs text-gray-600">
                                    Punya <span class="font-bold text-amber-700">{{ number_format($userPoints, 0, ',', '.') }} Poin</span>
                                    <br>
                                    (Setara <span class="font-bold">Rp {{ number_format($userPoints * $loyaltyPointValue, 0, ',', '.') }}</span>)
                                </div>
                                <label for="use_points_checkbox" class="flex items-center gap-2 cursor-pointer bg-white px-3 py-1.5 rounded-lg border border-amber-200 shadow-sm hover:bg-amber-50/20 transition-all select-none">
                                    <input type="checkbox" name="use_points" id="use_points_checkbox" value="1" class="w-4 h-4 text-amber-600 border-amber-300 rounded focus:ring-amber-500 cursor-pointer">
                                    <span class="text-xs font-bold text-amber-900">Gunakan</span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Cost Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal ({{ $cartItems->sum('quantity') }} Barang)</span>
                            <span id="subtotal" data-value="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman (<span id="selected_courier_label">J&T</span>)</span>
                            <span id="shipping-cost-display" class="text-gray-400 font-medium italic">Pilih alamat...</span>
                        </div>
                        
                        <!-- Dynamic Point Discount Row -->
                        <div id="points-discount-row" class="flex justify-between text-green-600 hidden">
                            <span>Potongan Poin (<span id="points-used-label">0</span> Poin)</span>
                            <span>-Rp <span id="points-discount-display">0</span></span>
                        </div>

                        <div class="flex justify-between text-gray-500 text-[13px] mt-1">
                            <span>Estimasi Waktu Tiba</span>
                            <span id="shipping_etd" class="font-medium italic">-</span>
                        </div>
                        <div class="border-t border-dashed border-gray-300 my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900 text-lg">Total</span>
                            <span id="total_payment" class="font-bold text-2xl text-accent" data-value="{{ $total }}">Rp
                                {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" onclick="confirmOrder()"
                        class="w-full btn-cream-dark py-4 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition-all">
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
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city_id');
            const districtSelect = document.getElementById('district_id');
            const shippingCostDisplay = document.getElementById('shipping-cost-display');
            const totalPaymentDisplay = document.getElementById('total_payment');
            const subtotal = parseInt(document.getElementById('subtotal').dataset.value);

            // Initial Cascading Values
            const initialProvinceId = "{{ old('province_id', Auth::check() ? Auth::user()->province_id : '') }}";
            const initialCityId = "{{ old('city_id', Auth::check() ? Auth::user()->city_id : '') }}";
            const initialDistrictId = "{{ old('district_id', Auth::check() ? Auth::user()->district_id : '') }}";

            // Initialize Tom Select
            const tsProvince = new TomSelect('#province', {
                create: false,
                placeholder: 'Pilih Provinsi...',
                maxOptions: 100,
            });

            const tsCity = new TomSelect('#city_id', {
                create: false,
                placeholder: 'Pilih Kota...',
                maxOptions: 1000,
            });

            const tsDistrict = new TomSelect('#district_id', {
                create: false,
                placeholder: 'Pilih Kecamatan...',
                maxOptions: 1000,
            });

            // Total weight calculation (default 250g per item for shipping accuracy)
            const totalWeight = {{ $cartItems->sum('quantity') }} * 250;

            // Initialize initial state
            tsCity.disable();
            tsDistrict.disable();

            // 1. Fetch Provinces
            async function fetchProvinces() {
                tsProvince.lock();
                try {
                    const response = await fetch('/shipping/provinces');
                    const provinces = await response.json();

                    if (Array.isArray(provinces)) {
                        tsProvince.clearOptions();
                        provinces.forEach(province => {
                            tsProvince.addOption({value: province.id, text: province.name});
                        });
                        tsProvince.refreshOptions(false);

                        // Set initial value if exists
                        if (initialProvinceId) {
                            tsProvince.setValue(initialProvinceId);
                        }
                    }
                } catch (error) {
                    console.error('Error fetching provinces:', error);
                } finally {
                    tsProvince.unlock();
                }
            }

            // Initial trigger
            fetchProvinces();

            // 2. Fetch Cities
            tsProvince.on('change', async function (provinceId) {
                tsCity.clear();
                tsCity.clearOptions();
                tsCity.disable();
                
                tsDistrict.clear();
                tsDistrict.clearOptions();
                tsDistrict.disable();

                shippingCostDisplay.textContent = 'Rp 0';
                resetShipping();

                if (!provinceId) return;

                // Save name
                document.getElementById('province_name').value = tsProvince.getItem(provinceId).textContent;

                try {
                    const response = await fetch(`/shipping/cities/${provinceId}`);
                    const cities = await response.json();

                    if (Array.isArray(cities)) {
                        cities.forEach(city => {
                            tsCity.addOption({value: city.id, text: city.name});
                        });
                        tsCity.enable();
                        tsCity.refreshOptions(false);

                        // Set initial value if exists
                        if (initialCityId && provinceId === initialProvinceId) {
                            tsCity.setValue(initialCityId);
                        }
                    }
                } catch (error) {
                    console.error('Error fetching cities:', error);
                }
            });

            // 2b. Fetch Districts (Kecamatan)
            tsCity.on('change', async function (cityId) {
                tsDistrict.clear();
                tsDistrict.clearOptions();
                tsDistrict.disable();
                resetShipping();

                if (!cityId) return;

                // Save name
                document.getElementById('city_name').value = tsCity.getItem(cityId).textContent;

                try {
                    const response = await fetch(`/shipping/districts/${cityId}`);
                    const districts = await response.json();

                    if (Array.isArray(districts)) {
                        districts.forEach(district => {
                            tsDistrict.addOption({value: district.id, text: district.name});
                        });
                        tsDistrict.enable();
                        tsDistrict.refreshOptions(false);

                        // Set initial value if exists
                        if (initialDistrictId && cityId === initialCityId) {
                            tsDistrict.setValue(initialDistrictId);
                        }
                    }
                } catch (error) {
                    console.error('Error fetching districts:', error);
                }
            });

            // Handle metadata
            tsDistrict.on('change', function(districtId) {
                if (!districtId) return;

                // Save metadata
                document.getElementById('district_name').value = tsDistrict.getItem(districtId).textContent;

                calculateShippingCost();
            });
            async function calculateShippingCost() {
                const postalCodeInput = document.getElementById('postal_code');
                const postalCodeError = document.getElementById('postal_code_error');
                const postalCode = postalCodeInput.value;
                const courier = document.getElementById('courier').value;
                const courierName = document.getElementById('courier').options[document.getElementById('courier').selectedIndex].text;

                // Clear previous errors
                postalCodeError.classList.add('hidden');
                postalCodeError.textContent = '';
                postalCodeInput.classList.remove('border-red-500', 'ring-4', 'ring-red-500/10');

                // Save metadata for the order
                const cityId = tsCity.getValue();
                if (cityId) {
                    document.getElementById('city_name').value = tsCity.getItem(cityId).textContent;
                    document.getElementById('province_name').value = tsProvince.getItem(tsProvince.getValue()).textContent;
                }

                document.getElementById('selected_courier_label').textContent = courierName.split(' ')[0]; // Placeholder initial label

                if (!postalCode) {
                    resetShipping();
                    return;
                }

                if (postalCode.startsWith('0')) {
                    postalCodeError.textContent = 'Kode pos Indonesia tidak boleh diawali dengan angka 0.';
                    postalCodeError.classList.remove('hidden');
                    postalCodeInput.classList.add('border-red-500', 'ring-4', 'ring-red-500/10');
                    resetShipping('Kode pos salah');
                    return;
                }

                if (postalCode.length < 5) {
                    postalCodeError.textContent = 'Kode pos harus terdiri dari 5 digit angka.';
                    postalCodeError.classList.remove('hidden');
                    postalCodeInput.classList.add('border-red-500', 'ring-4', 'ring-red-500/10');
                    resetShipping('Kode pos kurang');
                    return;
                }

                shippingCostDisplay.textContent = 'Menghitung...';
                shippingCostDisplay.classList.add('animate-pulse');

                const provinceVal = tsProvince.getValue();
                const cityVal = tsCity.getValue();
                const districtVal = tsDistrict.getValue();
                const provinceName = provinceVal ? tsProvince.getItem(provinceVal).textContent : '';
                const cityName = cityVal ? tsCity.getItem(cityVal).textContent : '';
                const districtName = districtVal ? tsDistrict.getItem(districtVal).textContent : '';

                try {
                    const response = await fetch('/shipping/cost', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            destination_postal_code: postalCode,
                            weight: totalWeight,
                            courier: courier,
                            province: provinceName,
                            city: cityName,
                            district: districtName
                        })
                    });

                    const data = await response.json();
                    if (response.ok && Array.isArray(data) && data.length > 0) {
                        let cost = Infinity;
                        let etd = '';

                        // Biteship format (already mapped in controller)
                        data.forEach(service => {
                            if (service.cost < cost && service.cost > 0) {
                                cost = service.cost;
                                etd = service.etd;
                            }
                        });

                        if (cost === Infinity) {
                            resetShipping('Tidak tersedia');
                            return;
                        }

                        // Update hidden inputs for form submission
                        document.getElementById('shipping_cost_input').value = cost;
                        document.getElementById('shipping_etd_input').value = etd;

                        const formattedCost = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(cost);

                        shippingCostDisplay.textContent = formattedCost;
                        shippingCostDisplay.className = 'text-gray-900 font-bold';
                        shippingCostDisplay.classList.remove('animate-pulse');
                        
                        // Show service name in label (e.g. "J&T (1-3 Hari)")
                        document.getElementById('selected_courier_label').textContent = courierName.split(' ')[0] + ' (' + etd + ')';

                        let parsedEtd = etd;
                        if (parsedEtd) {
                            let etdLower = parsedEtd.toLowerCase();
                            if (etdLower.includes('sameday')) {
                                parsedEtd = 'Sameday';
                            } else if (etdLower.includes('nextday')) {
                                parsedEtd = 'Nextday (1-2 Hari)';
                            } else {
                                parsedEtd = parsedEtd.replace(/days?|hari/gi, '').trim() + ' Hari';
                            }
                            document.getElementById('shipping_etd').textContent = parsedEtd;
                            document.getElementById('shipping_etd').classList.remove('italic');
                        } else {
                            document.getElementById('shipping_etd').textContent = '-';
                        }

                        updateSummary();
                    } else {
                        const errorMsg = data.error || 'Gagal menghitung ongkos kirim. Silakan periksa kembali kode pos Anda.';
                        postalCodeError.textContent = errorMsg;
                        postalCodeError.classList.remove('hidden');
                        postalCodeInput.classList.add('border-red-500', 'ring-4', 'ring-red-500/10');
                        resetShipping('Tidak tersedia');
                    }
                } catch (error) {
                    console.error('Error calculating cost:', error);
                    postalCodeError.textContent = 'Terjadi kesalahan koneksi. Gagal menghitung ongkos kirim.';
                    postalCodeError.classList.remove('hidden');
                    postalCodeInput.classList.add('border-red-500', 'ring-4', 'ring-red-500/10');
                    resetShipping('Gagal');
                }
            }

            document.getElementById('postal_code').addEventListener('input', calculateShippingCost);
            citySelect.addEventListener('change', calculateShippingCost);
            districtSelect.addEventListener('change', calculateShippingCost);
            document.getElementById('courier').addEventListener('change', calculateShippingCost);

            // Loyalty points client variables
            const usePointsCheckbox = document.getElementById('use_points_checkbox');
            const pointsDiscountRow = document.getElementById('points-discount-row');
            const pointsDiscountDisplay = document.getElementById('points-discount-display');
            const pointsUsedLabel = document.getElementById('points-used-label');
            
            const userPoints = {{ $userPoints ?? 0 }};
            const pointValue = {{ $loyaltyPointValue ?? 100 }};
            let pointsDiscount = 0;

            function updateSummary() {
                const shippingCost = parseInt(document.getElementById('shipping_cost_input').value) || 0;
                let pointsUsed = 0;
                
                if (usePointsCheckbox && usePointsCheckbox.checked && userPoints > 0) {
                    const maxDiscount = Math.max(0, subtotal + shippingCost - 1);
                    const potentialDiscount = userPoints * pointValue;
                    
                    if (potentialDiscount > maxDiscount) {
                        pointsUsed = Math.floor(maxDiscount / pointValue);
                    } else {
                        pointsUsed = userPoints;
                    }
                    
                    pointsDiscount = pointsUsed * pointValue;
                    
                    if (pointsDiscountRow) {
                        pointsDiscountRow.classList.remove('hidden');
                        pointsUsedLabel.textContent = new Intl.NumberFormat('id-ID').format(pointsUsed);
                        pointsDiscountDisplay.textContent = '-Rp ' + new Intl.NumberFormat('id-ID').format(pointsDiscount);
                    }
                } else {
                    pointsDiscount = 0;
                    if (pointsDiscountRow) {
                        pointsDiscountRow.classList.add('hidden');
                    }
                }

                const totalPayment = Math.max(0, subtotal + shippingCost - pointsDiscount);
                const formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPayment);
                totalPaymentDisplay.textContent = formattedTotal;
            }

            if (usePointsCheckbox) {
                usePointsCheckbox.addEventListener('change', updateSummary);
            }

            function resetShipping(statusText = 'Pilih alamat...') {
                shippingCostDisplay.textContent = statusText;
                shippingCostDisplay.className = 'text-gray-400 font-medium italic';
                document.getElementById('shipping_etd').textContent = '-';
                document.getElementById('shipping_etd').classList.add('italic');
                document.getElementById('shipping_cost_input').value = 0;
                updateSummary();
            }

            fetchProvinces();
        });

        async function confirmOrder() {
            // Get values directly from elements
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const postalCode = document.getElementById('postal_code').value;
            
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city_id');
            const districtSelect = document.getElementById('district_id');
            const courierSelect = document.getElementById('courier');
            const usePointsCheckbox = document.getElementById('use_points_checkbox');

            const provinceId = provinceSelect.value;
            const cityId = citySelect.value;
            const districtId = districtSelect.value;
            const courier = courierSelect.value;
            const usePoints = usePointsCheckbox && usePointsCheckbox.checked ? 1 : 0;

            // Ensure we have the names too
            const provinceName = provinceId ? provinceSelect.options[provinceSelect.selectedIndex].text : '';
            const cityName = cityId ? citySelect.options[citySelect.selectedIndex].text : '';
            const districtName = districtId ? districtSelect.options[districtSelect.selectedIndex].text : '';

            const shippingCost = document.getElementById('shipping_cost_input').value;
            const shippingEtd = document.getElementById('shipping_etd_input').value;

            // Validation check
            if (!name || !phone || !address || !postalCode || !cityId || !districtId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi semua informasi pengiriman (Provinsi, Kota, Kecamatan, dan Kode Pos).',
                    confirmButtonColor: '#5B3A29'
                });
                return;
            }

            const result = await Swal.fire({
                title: 'Konfirmasi Pesanan?',
                text: "Pastikan data pesanan Anda sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#5B3A29',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Pesan Sekarang!',
                cancelButtonText: 'Batal'
            });

            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses Pesanan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                try {
                    const response = await fetch('/pembayaran', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name,
                            phone,
                            address,
                            postal_code: postalCode,
                            province_id: provinceId,
                            province_name: provinceName,
                            city_id: cityId,
                            city_name: cityName,
                            district_id: districtId,
                            district_name: districtName,
                            courier: courier,
                            shipping_cost: shippingCost,
                            shipping_etd: shippingEtd,
                            use_points: usePoints,
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Pesanan Berhasil Dibuat!',
                            text: 'Anda akan dialihkan ke halaman pembayaran.',
                            timer: 2000,
                            showConfirmButton: false,
                            willClose: () => {
                                window.location.href = "{{ url('/invoice') }}/" + data.order_number;
                            }
                        });
                    } else {
                        throw new Error(data.message || 'Gagal menyimpan pesanan');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: error.message,
                        confirmButtonColor: '#5B3A29'
                    });
                }
            }
        }
    </script>
@endsection