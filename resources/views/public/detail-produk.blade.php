@extends('layouts.masterPublic')

@section('title', 'Detail Produk — Arimbi Queen')
@section('description', 'Detail produk premium dari Arimbi Queen.')

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

        .bg-cream {
            background-color: var(--cream);
        }

        .text-accent {
            color: var(--accent);
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

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Size Button State */
        .size-btn.active {
            border-color: var(--accent);
            background-color: var(--accent);
            color: white;
        }

        /* Thumbnail active border */
        .thumb-active {
            border: 2px solid var(--accent);
        }

        /* Product Card Hover Effects */
        .product-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .img-container img {
            transition: transform 0.6s ease;
        }

        .product-card:hover .img-container img {
            transform: scale(1.1);
        }

        /* Smooth Mobile Menu Animation (Matches index.html) */
        #mobileMenu {
            transition: visibility 0.4s;
        }

        #mobileMenu.hidden {
            visibility: hidden;
            display: flex !important;
            pointer-events: none;
        }

        #mobileMenuBackdrop {
            transition: opacity 0.4s ease;
        }

        #mobileMenu.hidden #mobileMenuBackdrop {
            opacity: 0;
        }

        #mobileMenuContent {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(0);
        }

        #mobileMenu.hidden #mobileMenuContent {
            transform: translateX(100%);
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
                <li><a href="{{ url('/produk') }}" class="hover:text-accent">Produk</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-900 font-medium">Koleksi Tunik Premium</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-24">
            <!-- Left: Image Gallery -->
            <div class="space-y-4" data-aos="fade-right">
                <div
                    class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gray-100 shadow-sm border border-gray-50">
                    <img id="mainImage" src="{{ asset('images/produk1.jpg') }}" alt="Product Main"
                        class="w-full h-full object-cover transition-opacity duration-300" />
                </div>
                <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">
                    <button
                        class="thumbnail-btn thumb-active relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent transition-all"
                        data-img="{{ asset('images/produk1.jpg') }}">
                        <img src="{{ asset('images/produk1.jpg') }}" class="w-full h-full object-cover" />
                    </button>
                    <button
                        class="thumbnail-btn relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent transition-all"
                        data-img="{{ asset('images/busana1.jpg') }}">
                        <img src="{{ asset('images/busana1.jpg') }}" class="w-full h-full object-cover" />
                    </button>
                    <button
                        class="thumbnail-btn relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent transition-all"
                        data-img="{{ asset('images/busana2.jpg') }}">
                        <img src="{{ asset('images/busana2.jpg') }}" class="w-full h-full object-cover" />
                    </button>
                    <button
                        class="thumbnail-btn relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent transition-all"
                        data-img="{{ asset('images/busana3.jpg') }}">
                        <img src="{{ asset('images/busana3.jpg') }}" class="w-full h-full object-cover" />
                    </button>
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="flex flex-col" data-aos="fade-left">
                <div class="mb-2">
                    <span
                        class="inline-block px-3 py-1 bg-amber-50 text-accent text-[10px] font-bold uppercase tracking-widest rounded-full">Koleksi
                        Terlaris</span>
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-2 font-serif">Koleksi Tunik Premium Signature</h2>
                <div class="flex items-center gap-4 mb-6 text-gray-400 text-sm">
                    <div class="flex text-amber-400">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <span>(128 Ulasan)</span>
                </div>

                <p class="text-3xl font-bold text-accent mb-8 font-inter">Rp 245.000</p>

                <div class="mb-8">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Deskripsi Produk</h4>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        Tunik premium dengan bahan Silk pilihan yang memberikan efek jatuh dan sangat dingin saat
                        bersentuhan dengan kulit. Desain siluet yang longgar namun tetap memberikan bentuk tubuh yang
                        anggun, sangat cocok untuk acara semiformal maupun aktivitas sehari-hari yang membutuhkan
                        kenyamanan ekstra.
                    </p>
                </div>

                <!-- Size & Quantity Selection -->
                <div class="mb-8 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                    <!-- Size -->
                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Pilih Ukuran</h4>
                            <button id="showSizeGuide"
                                class="text-xs text-accent font-semibold underline decoration-accent/30 underline-offset-4 flex items-center gap-1 hover:text-accent/80 transition-all">
                                <i class="fa-solid fa-ruler-combined"></i> Lihat Size Guide
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <button class="size-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all">S</button>
                            <button class="size-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all">M</button>
                            <button class="size-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all">L</button>
                            <button class="size-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all">XL</button>
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Jumlah</h4>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-xl bg-white">
                                <button id="btnMinus" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-accent transition-colors"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" id="qtyInput" value="1" min="1" class="w-12 text-center border-none focus:ring-0 text-gray-900 font-bold p-0 appearance-none bg-transparent" readonly />
                                <button id="btnPlus" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-accent transition-colors"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <span class="text-xs text-gray-500">Tersedia 45 stok</span>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button id="addToCartBtn"
                        class="flex-1 btn-cream-dark py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-xl hover:brightness-110 transition-all active:scale-95">
                        <i class="fa-solid fa-cart-shopping fa-xl"></i> Masukkan ke Keranjang
                    </button>
                    <button
                        class="like-btn px-6 h-16 flex items-center justify-center gap-2 rounded-2xl border-2 border-gray-100 text-red-500 hover:bg-red-50 transition-all">
                        <i class="fa-regular fa-heart fa-xl"></i>
                        <span class="font-bold text-lg">145</span>
                    </button>
                </div>

                <div class="mt-8 flex items-center gap-6 text-[10px] text-gray-400 uppercase font-bold tracking-widest">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-truck-fast text-accent/50 text-sm"></i>
                        Pengiriman Cepat</div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-shield-check text-accent/50 text-sm"></i>
                        Kualitas Terjamin</div>
                </div>
            </div>
        </div>

        <!-- Reviews & Testimonials -->
        <div class="mt-20 mb-20 border-t border-gray-100 pt-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Review Form (4 cols) -->
                <div class="lg:col-span-4">
                    <div class="sticky top-24">
                        <h3 class="text-2xl font-bold font-serif mb-6">Tulis Ulasan</h3>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <form>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Rating Kamu</label>
                                    <div class="flex gap-2 text-gray-300 text-xl cursor-pointer group-rating">
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors"></i>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text"
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-white focus:border-accent focus:ring-2 focus:ring-accent/10 focus:outline-none transition-all"
                                        placeholder="Nama kamu...">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan</label>
                                    <textarea rows="4"
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-white focus:border-accent focus:ring-2 focus:ring-accent/10 focus:outline-none transition-all resize-none"
                                        placeholder="Ceritakan pengalamanmu..."></textarea>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Testimoni (Opsional)</label>
                                    <div class="relative">
                                        <input type="file" id="reviewImage" accept="image/*" class="hidden" onchange="previewReviewImage(this)">
                                        <label for="reviewImage" 
                                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-accent hover:bg-gray-50 transition-all">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6 text-gray-400" id="uploadPlaceholder">
                                                <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i>
                                                <p class="text-xs text-center"><span class="font-bold">Klik untuk upload</span><br>atau drag and drop</p>
                                            </div>
                                            <img id="imagePreview" class="hidden w-full h-full object-cover rounded-xl" />
                                            <button type="button" id="removeImageBtn" onclick="removeReviewImage(event)" 
                                                class="hidden absolute top-2 right-2 bg-white text-red-500 rounded-full w-6 h-6 flex items-center justify-center shadow-md hover:bg-red-50 transition-colors">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                        </label>
                                    </div>
                                </div>
                                <button
                                    class="w-full btn-cream-dark py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all active:scale-95">Kirim
                                    Ulasan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Reviews List (8 cols) -->
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold font-serif">Ulasan Pembeli (128)</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <span>Urutkan:</span>
                            <select
                                class="border-none bg-transparent font-bold text-gray-900 focus:ring-0 cursor-pointer p-0">
                                <option>Terbaru</option>
                                <option>Rating Tertinggi</option>
                                <option>Rating Terendah</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Review Item 1 -->
                        <div class="flex gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="images/testi1.jpg" alt="User" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900">Sarah Wijaya</h4>
                                        <div class="flex text-amber-400 text-xs mt-1">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">2 hari yang lalu</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">Bahannya bener-bener adem dan jatuhnya
                                    bagus banget di badan. Ukuran M pas banget buat BB 55kg TB 160cm. Bakal order warna lain
                                    sih ini!</p>

                                <!-- Review Images -->
                                <div class="flex gap-2 mt-4">
                                    <div
                                        class="w-16 h-16 rounded-lg bg-gray-100 overflow-hidden cursor-pointer hover:opacity-90 border border-gray-200">
                                        <img src="{{ asset('images/produk1.jpg') }}" class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Item 2 -->
                        <div class="flex gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 rounded-full bg-accent text-white flex items-center justify-center font-bold text-lg">
                                    D
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900">Dina Pertiwi</h4>
                                        <div class="flex text-amber-400 text-xs mt-1">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-regular fa-star"></i>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">1 minggu yang lalu</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">Pengiriman cepet banget, packaging aman.
                                    Bajunya bagus cuma warnanya agak sedikit lebih gelap dari foto, tapi tetep cantik kok.
                                </p>
                            </div>
                        </div>

                        <!-- Review Item 3 -->
                        <div class="flex gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden">
                                    <img src="images/testi2.jpg" alt="User" class="w-full h-full object-cover">
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900">Rina S.</h4>
                                        <div class="flex text-amber-400 text-xs mt-1">
                                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                                class="fa-solid fa-star"></i>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">2 minggu yang lalu</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">Suka banget sama modelnya! Simple tapi
                                    kelihatan mewah. Jahitannya juga rapi banget. Recommended!</p>
                            </div>
                        </div>
                    </div>

                    <button
                        class="w-full mt-8 py-3 border border-gray-200 rounded-xl text-gray-500 font-medium hover:bg-gray-50 transition-colors">
                        Lihat Semua Ulasan
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold font-serif">Produk Terkait</h3>
                <a href="{{ url('/produk') }}"
                    class="text-sm text-accent font-semibold flex items-center gap-1 underline underline-offset-4 decoration-accent/20">Lihat
                    Semua <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <!-- Related Item 1 -->
                <article class="product-card group">
                    <div class="img-container relative aspect-[3/4] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                        <img src="{{ asset('images/busana4.jpg') }}" alt="Abaya Silk Lavender" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all duration-500">
                        </div>
                        <button
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <div
                            class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all text-center">
                            <a href="{{ url('/detail-produk') }}"
                                class="block w-full bg-white text-gray-900 font-semibold py-3 rounded-xl shadow-xl hover:bg-accent hover:text-white transition-colors">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">Busana</span>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Abaya Silk Lavender</h4>
                        <p class="text-accent font-bold font-inter text-sm">Rp 315.000</p>
                    </div>
                </article>

                <!-- Related Item 2 -->
                <article class="product-card group">
                    <div class="img-container relative aspect-[3/4] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                        <img src="{{ asset('images/busana5.jpg') }}" alt="Gamis Polos Exclusive" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all duration-500">
                        </div>
                        <button
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <div
                            class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all text-center">
                            <a href="{{ url('/detail-produk') }}"
                                class="block w-full bg-white text-gray-900 font-semibold py-3 rounded-xl shadow-xl hover:bg-accent hover:text-white transition-colors">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">Busana</span>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Gamis Polos Exclusive</h4>
                        <p class="text-accent font-bold font-inter text-sm">Rp 285.000</p>
                    </div>
                </article>

                <!-- Related Item 3 -->
                <article class="product-card group">
                    <div class="img-container relative aspect-[3/4] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                        <img src="{{ asset('images/busana6.jpg') }}" alt="Tunik Bordir Mewah" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all duration-500">
                        </div>
                        <button
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <div
                            class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all text-center">
                            <a href="{{ url('/detail-produk') }}"
                                class="block w-full bg-white text-gray-900 font-semibold py-3 rounded-xl shadow-xl hover:bg-accent hover:text-white transition-colors">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">Busana</span>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Tunik Bordir Mewah</h4>
                        <p class="text-accent font-bold font-inter text-sm">Rp 265.000</p>
                    </div>
                </article>

                <!-- Related Item 4 -->
                <article class="product-card group">
                    <div class="img-container relative aspect-[3/4] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                        <img src="{{ asset('images/produk3.jpg') }}" alt="Abaya Modern Minimalis" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all duration-500">
                        </div>
                        <button
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <div
                            class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all text-center">
                            <a href="{{ url('/detail-produk') }}"
                                class="block w-full bg-white text-gray-900 font-semibold py-3 rounded-xl shadow-xl hover:bg-accent hover:text-white transition-colors">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">Busana</span>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1">Abaya Modern Minimalis</h4>
                        <p class="text-accent font-bold font-inter text-sm">Rp 295.000</p>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <!-- Size Guide Modal -->
    <div id="sizeGuideModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full overflow-hidden transform transition-all scale-95 opacity-0 duration-500"
            id="modalContent">
            <button id="closeSizeGuide"
                class="absolute right-4 top-4 z-20 bg-white/80 hover:bg-white p-2 rounded-full shadow-md text-gray-800 transition-colors">
                <i class="fa-solid fa-xmark fa-lg"></i>
            </button>
            <div class="p-8 text-center">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Size Guide Arimbi Queen</h3>
                <div class="rounded-2xl overflow-hidden shadow-inner bg-gray-50 p-2">
                    <img src="{{ asset('images/sizeguide.jpg') }}" alt="Size Guide" class="w-full h-auto" />
                </div>
                <p class="mt-6 text-sm text-gray-500 italic">*) Ukuran dapat berbeda 1-2 cm karena proses produksi
                    massal.</p>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/6281234567890"
        class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl shadow-2xl hover:bg-[#128C7E] transition-all hover:scale-110 active:scale-95 duration-300"
        aria-label="Chat via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
@endsection

@section('scripts')
    <script>
        // Mobile menu open/close
        const btnMobile = document.getElementById('btn-mobile');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileClose = document.getElementById('mobileClose');
        const mobileBackdrop = document.getElementById('mobileMenuBackdrop');

        if (btnMobile && mobileMenu) {
            btnMobile.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
            });
        }

        const closeMobileMenu = () => {
            mobileMenu.classList.add('hidden');
        };

        if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
        if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);

        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        // Image Gallery Logic
        const mainImage = document.getElementById('mainImage');
        const thumbnails = document.querySelectorAll('.thumbnail-btn');

        thumbnails.forEach(btn => {
            btn.addEventListener('click', () => {
                const newImg = btn.getAttribute('data-img');
                mainImage.style.opacity = '0';
                setTimeout(() => {
                    mainImage.src = newImg;
                    mainImage.style.opacity = '1';
                }, 150);
                document.querySelector('.thumb-active').classList.remove('thumb-active');
                btn.classList.add('thumb-active');
            });
        });

        // Like button toggle (Shared with index.html logic)
        document.addEventListener('click', (e) => {
            const likeBtn = e.target.closest('.like-btn');
            if (!likeBtn) return;
            const icon = likeBtn.querySelector('i');
            const span = likeBtn.querySelector('span');
            let count = parseInt(span ? span.textContent : '0');

            if (icon.classList.contains('fa-regular')) {
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
                icon.classList.add('text-red-500');
                if (span) span.textContent = count + 1;
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
                icon.classList.remove('text-red-500');
                if (span) span.textContent = count - 1;
            }
        });

        // Size Guide Modal Logic
        const modalSize = document.getElementById('sizeGuideModal');
        const contentSize = document.getElementById('modalContent');
        const showBtnSize = document.getElementById('showSizeGuide');
        const closeBtnSize = document.getElementById('closeSizeGuide');
        const backdropSize = document.getElementById('modalBackdrop');

        const openModalSize = () => {
            modalSize.classList.remove('hidden');
            modalSize.classList.add('flex');
            setTimeout(() => {
                contentSize.classList.remove('scale-95', 'opacity-0');
                contentSize.classList.add('scale-100', 'opacity-100');
            }, 10);
        };

        const closeModalSize = () => {
            contentSize.classList.remove('scale-100', 'opacity-100');
            contentSize.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modalSize.classList.add('hidden');
                modalSize.classList.remove('flex');
            }, 300);
        };

        if (showBtnSize) showBtnSize.addEventListener('click', openModalSize);
        if (closeBtnSize) closeBtnSize.addEventListener('click', closeModalSize);
        if (backdropSize) backdropSize.addEventListener('click', closeModalSize);

        // Size Selection Logic
        const sizeBtns = document.querySelectorAll('.size-btn');
        let selectedSize = null;

        sizeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all
                sizeBtns.forEach(b => b.classList.remove('active'));
                // Add to clicked
                btn.classList.add('active');
                selectedSize = btn.textContent;
            });
        });

        // Quantity Logic
        const btnMinus = document.getElementById('btnMinus');
        const btnPlus = document.getElementById('btnPlus');
        const qtyInput = document.getElementById('qtyInput');

        if (btnMinus && btnPlus && qtyInput) {
            btnMinus.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                if (val > 1) {
                    qtyInput.value = val - 1;
                }
            });

            btnPlus.addEventListener('click', () => {
                let val = parseInt(qtyInput.value);
                qtyInput.value = val + 1;
            });
        }

        // Review Star Rating Logic
        const ratingContainer = document.querySelector('.group-rating');
        if (ratingContainer) {
            const stars = ratingContainer.querySelectorAll('i');
            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    // Reset all
                    stars.forEach(s => s.classList.remove('text-amber-400'));
                    // Fill until clicked
                    for(let i = 0; i <= index; i++) {
                        stars[i].classList.add('text-amber-400');
                    }
                });
            });
        }

        // Review Image Preview
        window.previewReviewImage = function(input) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');
            const container = input.nextElementSibling;
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    removeBtn.classList.remove('hidden');
                    container.classList.add('border-accent', 'bg-gray-50');
                    container.classList.remove('border-gray-300', 'border-dashed');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removeReviewImage = function(e) {
            e.preventDefault();
            e.stopPropagation(); // Stop bubbling to label
            
            const input = document.getElementById('reviewImage');
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');
            const container = input.nextElementSibling;

            input.value = '';
            preview.src = '';
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
            removeBtn.classList.add('hidden');
            container.classList.remove('border-accent', 'bg-gray-50');
            container.classList.add('border-gray-300', 'border-dashed');
        };

        // Add to Cart Logic (Mock)
        const addToCartBtn = document.getElementById('addToCartBtn');
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', () => {
                if (!selectedSize) {
                    alert('Silakan pilih ukuran terlebih dahulu!');
                    return;
                }
                const qty = qtyInput.value;
                alert(`Berhasil menambahkan ${qty} item (Ukuran: ${selectedSize}) ke keranjang!`);
            });
        }
    </script>
@endsection
