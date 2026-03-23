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
    </style>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endsection

@section('content')
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

                        <!-- Provinsi -->
                        <div>
                            <label for="province" class="block text-sm font-bold text-gray-700 mb-2">Provinsi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-map text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="province" name="province_id" 
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Kota / Kabupaten -->
                        <div>
                            <label for="city" class="block text-sm font-bold text-gray-700 mb-2">Kota / Kabupaten</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-city text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="city" name="city_id" 
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer" disabled required>
                                    <option value="">Pilih Kota</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Kurir Pengiriman -->
                        <div>
                            <label for="courier" class="block text-sm font-bold text-gray-700 mb-2">Kurir Pengiriman</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-truck text-gray-400 group-focus-within:text-accent transition-colors"></i>
                                </div>
                                <select id="courier" name="courier" 
                                    class="w-full pl-11 pr-10 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200 appearance-none cursor-pointer" required>
                                    <option value="jnt" selected>J&T Express</option>
                                    <option value="jne">JNE Express</option>
                                    <option value="sicepat">SiCepat</option>
                                    <option value="pos">POS Indonesia</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-chevron-down text-gray-400 group-focus-within:text-accent transition-colors text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Shipping Metadata -->
                        <input type="hidden" id="province_name" name="province_name">
                        <input type="hidden" id="city_name" name="city_name">
                        <input type="hidden" id="shipping_cost_input" name="shipping_cost" value="0">
                    </div>
                </section>

                <!-- Payment Method -->
                <section>
                    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                        <span class="w-8 h-8 rounded-full bg-cream-dark text-white flex items-center justify-center text-sm">2</span>
                        Konfirmasi Pesanan
                    </h2>

                    <div class="bg-blue-50 border border-blue-100 p-6 rounded-2xl flex gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-circle-info text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-blue-900 mb-1">Metode Pembayaran</h4>
                            <p class="text-sm text-blue-700 leading-relaxed text-light">
                                Setelah klik "Buat Pesanan", Anda akan diarahkan ke jendela pembayaran aman dari <strong>Midtrans</strong> untuk memilih metode Transfer Bank, E-Wallet, atau Kartu Kredit.
                            </p>
                        </div>
                    </div>
                </section>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="w-full lg:w-96 flex-shrink-0">
                <div class="bg-gray-50 p-6 rounded-2xl sticky top-24 border border-gray-200">
                    <h3 class="font-bold text-xl text-gray-900 mb-6 font-serif">Ringkasan Pesanan</h3>
                    
                    <!-- Items Preview -->
                    <div class="space-y-4 mb-6 pb-6 border-b border-gray-200 h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cartItems as $item)
                        <div class="flex gap-3">
                            <div class="w-16 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->product->images->count() > 0)
                                    <img src="{{ asset('storage/' . $item->product->images->sortByDesc('is_cover')->first()->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/no-image.jpg') }}" alt="No Image" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-medium text-gray-900 text-sm truncate">{{ $item->product->name }}</h4>
                                <p class="text-[10px] text-gray-500 mt-0.5">Size: {{ $item->size->size }} | Qty: {{ $item->quantity }}</p>
                                <p class="font-semibold text-accent text-sm mt-1">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Cost Breakdown -->
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal ({{ $cartItems->sum('quantity') }} Barang)</span>
                            <span id="subtotal" data-value="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman (<span id="selected_courier_label">J&T</span>)</span>
                            <span id="shipping_cost" class="text-gray-400 font-medium italic">Pilih alamat...</span>
                        </div>
                        <div class="flex justify-between text-gray-500 text-[13px] mt-1">
                            <span>Estimasi Waktu Tiba</span>
                            <span id="shipping_etd" class="font-medium italic">-</span>
                        </div>
                        <div class="border-t border-dashed border-gray-300 my-2"></div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-900 text-lg">Total</span>
                            <span id="total_payment" class="font-bold text-2xl text-accent" data-value="{{ $total }}">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const shippingCostDisplay = document.getElementById('shipping_cost');
            const totalPaymentDisplay = document.getElementById('total_payment');
            const subtotal = parseInt(document.getElementById('subtotal').dataset.value);
            
            // Total weight calculation (default 200g per item for shipping accuracy)
            const totalWeight = {{ $cartItems->sum('quantity') }} * 200;

            // 1. Fetch Provinces
            async function fetchProvinces() {
                try {
                    const response = await fetch('/shipping/provinces');
                    const provinces = await response.json();
                    
                    if (Array.isArray(provinces)) {
                        provinces.forEach(province => {
                            const option = document.createElement('option');
                            // Handle both RajaOngkir and Komerce formats
                            option.value = province.province_id || province.id || province.province_id;
                            option.textContent = province.province || province.name || province.label || 'Unknown';
                            provinceSelect.appendChild(option);
                        });
                    } else {
                        console.error('Provinces data is not an array:', provinces);
                        provinceSelect.innerHTML = '<option value="">Gagal mengambil data</option>';
                    }
                } catch (error) {
                    console.error('Error fetching provinces:', error);
                }
            }

            // 2. Fetch Cities
            provinceSelect.addEventListener('change', async function() {
                const provinceId = this.value;
                citySelect.innerHTML = '<option value="">Pilih Kota</option>';
                citySelect.disabled = true;
                resetShipping();

                if (!provinceId) return;

                try {
                    const response = await fetch(`/shipping/cities/${provinceId}`);
                    const cities = await response.json();
                    
                    if (Array.isArray(cities)) {
                        cities.forEach(city => {
                            const option = document.createElement('option');
                            // Handle both formats: city_id/city_name (RajaOngkir) vs id/name/label (Komerce)
                            option.value = city.city_id || city.id;
                            const cityName = city.city_name || city.name || city.label || 'Unknown';
                            const cityType = city.type ? city.type + ' ' : '';
                            option.textContent = `${cityType}${cityName}`;
                            citySelect.appendChild(option);
                        });
                        citySelect.disabled = false;
                    } else {
                        console.error('Cities data is not an array:', cities);
                        citySelect.innerHTML = '<option value="">Gagal mengambil data</option>';
                    }
                } catch (error) {
                    console.error('Error fetching cities:', error);
                }
            });

            // 3. Calculate Cost
            async function calculateShippingCost() {
                const cityId = citySelect.value;
                const courier = document.getElementById('courier').value;
                const courierName = document.getElementById('courier').options[document.getElementById('courier').selectedIndex].text;
                
                // Save metadata for the order
                if (cityId) {
                    document.getElementById('city_name').value = citySelect.options[citySelect.selectedIndex].text;
                    document.getElementById('province_name').value = provinceSelect.options[provinceSelect.selectedIndex].text;
                }

                document.getElementById('selected_courier_label').textContent = courierName.split(' ')[0]; // Show first word only (e.g. "J&T")

                if (!cityId) {
                    resetShipping();
                    return;
                }

                shippingCostDisplay.textContent = 'Menghitung...';
                shippingCostDisplay.classList.add('animate-pulse');

                try {
                    const response = await fetch('/shipping/cost', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            destination: cityId,
                            weight: totalWeight,
                            courier: courier
                        })
                    });
                    
                    const data = await response.json();
                    if (data.length > 0) {
                        let cost = Infinity;
                        let etd = '';

                        // Support both Komerce and standard RajaOngkir format
                        if (data[0].costs) {
                            // Standard RajaOngkir nesting
                            data[0].costs.forEach(service => {
                                if (service.cost && service.cost[0] && service.cost[0].value < cost) {
                                    cost = service.cost[0].value;
                                    etd = service.cost[0].etd || '';
                                }
                            });
                        } else {
                            // Komerce flat list
                            data.forEach(service => {
                                if (service.cost < cost && service.cost > 0) {
                                    cost = service.cost;
                                    etd = service.etd || service.estimasi || '';
                                }
                            });
                        }

                        if (cost === Infinity) {
                            shippingCostDisplay.textContent = 'Tidak tersedia';
                            resetShipping();
                            return;
                        }

                        document.getElementById('shipping_cost_input').value = cost;
                        
                        const formattedCost = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(cost);
                        
                        shippingCostDisplay.textContent = formattedCost;
                        shippingCostDisplay.classList.remove('animate-pulse', 'italic', 'text-gray-400');
                        shippingCostDisplay.classList.add('text-gray-900', 'font-bold');

                        let parsedEtd = etd;
                        if (parsedEtd) {
                            parsedEtd = parsedEtd.replace(/days?|hari/gi, '').trim() + ' Hari';
                            document.getElementById('shipping_etd').textContent = parsedEtd;
                            document.getElementById('shipping_etd').classList.remove('italic');
                        } else {
                            document.getElementById('shipping_etd').textContent = '-';
                        }

                        const totalPayment = subtotal + cost;
                        const formattedTotal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(totalPayment);
                        totalPaymentDisplay.textContent = formattedTotal;
                    } else {
                        shippingCostDisplay.textContent = 'Tidak tersedia';
                        resetShipping();
                    }
                } catch (error) {
                    console.error('Error calculating cost:', error);
                    shippingCostDisplay.textContent = 'Gagal';
                }
            }

            citySelect.addEventListener('change', calculateShippingCost);
            document.getElementById('courier').addEventListener('change', calculateShippingCost);

            function resetShipping() {
                shippingCostDisplay.textContent = 'Pilih alamat...';
                shippingCostDisplay.className = 'text-gray-400 font-medium italic';
                document.getElementById('shipping_etd').textContent = '-';
                document.getElementById('shipping_etd').classList.add('italic');
                totalPaymentDisplay.textContent = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(subtotal);
                document.getElementById('shipping_cost_input').value = 0;
            }

            fetchProvinces();
        });

        async function confirmOrder() {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            const address = document.getElementById('address').value;
            const provinceId = document.getElementById('province').value;
            const provinceName = document.getElementById('province_name').value;
            const cityId = document.getElementById('city').value;
            const cityName = document.getElementById('city_name').value;
            const courier = document.getElementById('courier').value;
            const shippingCost = document.getElementById('shipping_cost_input').value;

            if (!name || !phone || !address || !cityId) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Mohon lengkapi informasi pengiriman (termasuk Provinsi & Kota) Anda terlebih dahulu.',
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
                            province_id: provinceId,
                            province_name: provinceName,
                            city_id: cityId,
                            city_name: cityName,
                            courier: courier,
                            shipping_cost: shippingCost,
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
                            },
                            onPending: function(result) {
                                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
                            },
                            onError: function(result) {
                                window.location.href = "{{ url('/pembayaran/finish') }}?order_id=" + result.order_id;
                            },
                            onClose: function() {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pembayaran Dibatalkan',
                                    text: 'Anda menutup jendela pembayaran sebelum selesai.',
                                    confirmButtonColor: '#5B3A29'
                                });
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