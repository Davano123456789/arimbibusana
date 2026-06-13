@extends('layouts.masterPublic')

@section('title', 'Profil Saya — Arimbi Queen')

@section('head')
    <!-- TomSelect CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <style>
        .ts-control {
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            border-color: #e5e7eb !important;
            background-color: #f9fafb !important;
            font-size: 0.875rem !important;
        }
        .ts-wrapper.focus .ts-control {
            background-color: #fff !important;
            border-color: #5B3A29 !important;
            box-shadow: 0 0 0 4px rgba(91, 58, 41, 0.1) !important;
        }
    </style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12 min-h-[70vh]">
    <h1 class="text-3xl font-bold text-gray-900 mb-2 font-serif">Profil Saya</h1>
    <p class="text-gray-500 mb-8">Kelola data diri, foto profil, dan alamat pengiriman default Anda.</p>



    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl">
            <div class="flex items-center gap-3 mb-2">
                <i class="fa-solid fa-circle-xmark text-xl"></i>
                <span class="text-sm font-bold">Terjadi Kesalahan:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Left Side: Profile Picture -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-gray-200 p-6 text-center shadow-sm">
                    <div class="relative w-36 h-36 mx-auto mb-4 group">
                        <div class="w-full h-full rounded-full overflow-hidden border-4 border-gray-100 bg-gray-50 flex items-center justify-center">
                            @if($user->avatar)
                                <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            @else
                                <div id="avatar-placeholder" class="w-full h-full bg-gradient-to-tr from-[#B78A58] to-[#5B3A29] flex items-center justify-center text-white text-4xl font-bold uppercase">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <img id="avatar-preview" src="" alt="preview" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <label for="avatar" class="absolute bottom-1 right-1 bg-accent text-white w-9 h-9 rounded-full flex items-center justify-center cursor-pointer shadow-md hover:brightness-110 active:scale-95 transition-all">
                            <i class="fa-solid fa-camera text-sm"></i>
                            <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden">
                        </label>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 mb-1">{{ $user->email }}</p>
                    <span class="inline-block px-3 py-1 bg-amber-50 border border-amber-100 text-amber-800 text-xs font-bold rounded-full uppercase tracking-wider">
                        {{ $user->role }} Member
                    </span>
                    
                    <p class="text-[10px] text-gray-400 mt-4 leading-relaxed">
                        Maksimal ukuran file foto 2MB dengan format JPG, JPEG, atau PNG.
                    </p>
                </div>
            </div>

            <!-- Right Side: Profile Details and Default Address -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Account Info Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-user-gear text-accent"></i> Informasi Akun
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-400 mb-2">Alamat Email</label>
                            <input type="email" value="{{ $user->email }}" 
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-100 text-gray-400 cursor-not-allowed" 
                                disabled>
                        </div>
                    </div>
                </div>

                <!-- Shipping Info Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-accent"></i> Alamat Pengiriman Default
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- WhatsApp Phone Number -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / Telepon</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fa-brands fa-whatsapp text-gray-400 text-lg"></i>
                                </div>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                    placeholder="Contoh: 08123456789">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan...">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Province -->
                        <div>
                            <label for="province" class="block text-sm font-bold text-gray-700 mb-2">Provinsi</label>
                            <select id="province" name="province_id">
                                <option value="">Pilih Provinsi...</option>
                            </select>
                            <input type="hidden" id="province_name" name="province_name" value="{{ old('province_name', $user->province_name) }}">
                        </div>

                        <!-- City -->
                        <div>
                            <label for="city_id" class="block text-sm font-bold text-gray-700 mb-2">Kota / Kabupaten</label>
                            <select id="city_id" name="city_id">
                                <option value="">Pilih Kota...</option>
                            </select>
                            <input type="hidden" id="city_name" name="city_name" value="{{ old('city_name', $user->city_name) }}">
                        </div>

                        <!-- District -->
                        <div>
                            <label for="district_id" class="block text-sm font-bold text-gray-700 mb-2">Kecamatan</label>
                            <select id="district_id" name="district_id">
                                <option value="">Pilih Kecamatan...</option>
                            </select>
                            <input type="hidden" id="district_name" name="district_name" value="{{ old('district_name', $user->district_name) }}">
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label for="postal_code" class="block text-sm font-bold text-gray-700 mb-2">Kode Pos</label>
                            <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}"
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                placeholder="Contoh: 60111">
                        </div>
                    </div>
                </div>

                <!-- Password Info Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                    <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-lock text-accent"></i> Ubah Password <small class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin diubah)</small>
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" id="password" name="password" 
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                placeholder="Minimal 8 karakter">
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" 
                                class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-accent focus:ring-4 focus:ring-accent/10 transition-all duration-200"
                                placeholder="Ulangi password baru">
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="text-right">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3.5 bg-accent text-white rounded-full font-bold hover:brightness-110 active:scale-95 transition-all shadow-lg shadow-accent/20">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- 1. AVATAR PREVIEW ---
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatar-preview');
            const avatarPlaceholder = document.getElementById('avatar-placeholder');

            if (avatarInput) {
                avatarInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            avatarPreview.src = e.target.result;
                            avatarPreview.classList.remove('hidden');
                            if (avatarPlaceholder) avatarPlaceholder.classList.add('hidden');
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // --- 2. CASCADING REGIONAL SELECTION (TOMSELECT) ---
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city_id');
            const districtSelect = document.getElementById('district_id');

            const initialProvinceId = "{{ old('province_id', $user->province_id) }}";
            const initialCityId = "{{ old('city_id', $user->city_id) }}";
            const initialDistrictId = "{{ old('district_id', $user->district_id) }}";

            const tsProvince = new TomSelect('#province', {
                create: false,
                placeholder: 'Pilih Provinsi...',
                maxOptions: 1000,
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

            tsCity.disable();
            tsDistrict.disable();

            // Fetch Provinces
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

            // Trigger fetch initial provinces
            fetchProvinces();

            // Fetch Cities on Province Change
            tsProvince.on('change', async function (provinceId) {
                tsCity.clear();
                tsCity.clearOptions();
                tsCity.disable();
                
                tsDistrict.clear();
                tsDistrict.clearOptions();
                tsDistrict.disable();

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

            // Fetch Districts on City Change
            tsCity.on('change', async function (cityId) {
                tsDistrict.clear();
                tsDistrict.clearOptions();
                tsDistrict.disable();

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

            // Handle District Change & Postal Code autofill
            tsDistrict.on('change', async function(districtId) {
                const postalCodeInput = document.getElementById('postal_code');
                if (!districtId) return;

                // Save name
                document.getElementById('district_name').value = tsDistrict.getItem(districtId).textContent;

                // Only auto-fill postal code if not editing existing (user can change manually)
                const isInitialLoad = (districtId === initialDistrictId && !postalCodeInput.value);
                const isUserChange = (districtId !== initialDistrictId);

                if (isUserChange) {
                    try {
                        const provinceName = tsProvince.getItem(tsProvince.getValue()).textContent;
                        const cityName = tsCity.getItem(tsCity.getValue()).textContent;
                        const districtName = tsDistrict.getItem(districtId).textContent;

                        postalCodeInput.placeholder = 'Mencari kode pos...';
                        postalCodeInput.classList.add('animate-pulse');

                        const response = await fetch('/shipping/postal-code', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                province: provinceName,
                                city: cityName,
                                district: districtName
                            })
                        });

                        const data = await response.json();
                        
                        if (data.postal_code) {
                            postalCodeInput.value = data.postal_code;
                            postalCodeInput.classList.remove('animate-pulse');
                            postalCodeInput.placeholder = 'Contoh: 60111';
                        }
                    } catch (error) {
                        console.error('Error fetching postal code:', error);
                        postalCodeInput.classList.remove('animate-pulse');
                    }
                }
            });
        });
    </script>
@endsection
