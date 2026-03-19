@extends('layouts.masterPublic')

@section('title', 'Koleksi Produk — Arimbi Queen')
@section('description', 'Jelajahi berbagai koleksi busana muslim, mukena, dan jilbab premium dari Arimbi Queen.')

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

        .bg-accent {
            background-color: var(--accent);
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

        /* Category Active State */
        .category-btn.active {
            background-color: var(--accent);
            color: white;
            border-color: var(--accent);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
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
    <!-- Hero / Promo Banner (Video) -->
    <section class="relative">
        <div class="relative h-[60vh] md:h-[70vh] w-full overflow-hidden bg-black">
            <video id="heroVideo" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline
                poster="https://images.unsplash.com/photo-1520975911600-5d36cb2d6f6f?q=80&w=1600&auto=format&fit=crop&ixlib=rb-4.0.3&s=0ffb93b7d8f8f5b2e9a3e2a6f2a4a7f7">
                <source src="{{ asset('videos/video-hero.mp4') }}" type="video/mp4">
            </video>

            <!-- Stronger dark overlays -->
            <div class="absolute inset-0 bg-black/45"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/6"></div>

            <!-- Play overlay for autoplay fallback -->
            <button id="heroPlayBtn"
                class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 rounded-full bg-white/95 flex items-center justify-center text-accent text-2xl shadow-lg hidden">
                <i class="fa-solid fa-play"></i>
            </button>

            <div class="max-w-6xl mx-auto px-6 h-full flex items-center">
                <div class="max-w-2xl text-white drop-shadow-lg">
                    <span class="inline-block mb-3 bg-amber-100 text-accent px-3 py-1 rounded-full text-sm font-medium"
                        data-aos="fade-down">Premium
                        Collection</span>
                    <h2 class="text-4xl md:text-6xl font-bold leading-tight mb-4" data-aos="fade-up"
                        data-aos-delay="200">Koleksi Terbaik Kami</h2>
                    <p class="mb-6 text-white/95 max-w-xl" data-aos="fade-up" data-aos-delay="400">Temukan keanggunan
                        dalam setiap jahitan. Koleksi pilihan yang
                        dirancang untuk kenyamanan dan kepercayaan diri Anda.</p>
                    <div class="flex gap-3" data-aos="fade-up" data-aos-delay="600">
                        <button id="heroMute"
                            class="inline-flex items-center gap-2 border border-gray-200 px-4 py-2 rounded text-sm bg-white/10 uppercase font-bold tracking-wider">Unmute
                            <i class="fa-solid fa-volume-high ml-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-6xl mx-auto px-6 py-12 -mt-10 relative z-10 bg-white rounded-t-[3rem]" data-aos="fade-up">

        <!-- Category Filter & Search -->
        <form action="{{ url('/produk') }}" method="GET" id="filterForm" class="flex flex-col gap-6 mb-12 border-b border-gray-100 pb-8" data-aos="fade-up">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-3 overflow-x-auto no-scrollbar w-full md:w-auto pb-4 md:pb-0">
                    <a href="{{ url('/produk') }}"
                        class="category-btn {{ request('category') == '' ? 'active' : '' }} px-6 py-2 rounded-full border border-gray-200 text-sm font-medium whitespace-nowrap transition-all hover:border-accent">Semua</a>
                    @foreach($categories as $category)
                    <a href="{{ url('/produk?category=' . $category->slug . '&min_price=' . request('min_price') . '&max_price=' . request('max_price') . '&sort=' . request('sort')) }}"
                        class="category-btn {{ request('category') == $category->slug ? 'active' : '' }} px-6 py-2 rounded-full border border-gray-200 text-sm font-medium whitespace-nowrap transition-all hover:border-accent text-center">{{ $category->name }}</a>
                    @endforeach
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <select name="sort" onchange="document.getElementById('filterForm').submit()"
                        class="bg-white border border-gray-200 rounded-xl px-4 py-2 outline-none cursor-pointer focus:ring-1 focus:ring-accent/30 transition text-gray-700 font-medium">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Urutkan: Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
            </div>

            <!-- Price Range Filter -->
            <div class="flex flex-wrap items-center gap-4 bg-gray-50/50 p-4 rounded-2xl border border-gray-100">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <div class="flex items-center gap-2 text-gray-700 mr-2">
                    <i class="fa-solid fa-filter text-accent/50"></i>
                    <span class="text-sm font-bold uppercase tracking-wider">Filter Harga</span>
                </div>
                <div class="flex items-center gap-2 md:gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-none">
                        <span class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] md:text-xs font-bold">Rp</span>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min"
                            class="bg-white border border-gray-200 rounded-xl py-2 md:py-2.5 pl-8 md:pl-10 pr-2 md:pr-4 text-xs md:text-sm w-full sm:w-36 md:w-44 focus:ring-1 focus:ring-accent/30 outline-none transition-all shadow-sm" />
                    </div>
                    <span class="text-gray-300 mx-1">—</span>
                    <div class="relative flex-1 sm:flex-none">
                        <span class="absolute left-3 md:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] md:text-xs font-bold">Rp</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                            class="bg-white border border-gray-200 rounded-xl py-2 md:py-2.5 pl-8 md:pl-10 pr-2 md:pr-4 text-xs md:text-sm w-full sm:w-36 md:w-44 focus:ring-1 focus:ring-accent/30 outline-none transition-all shadow-sm" />
                    </div>
                </div>

                <!-- On Sale Filter -->
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-xl border border-gray-200 shadow-sm cursor-pointer hover:border-accent/30 transition-all group">
                    <input type="checkbox" name="on_sale" id="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }} class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent cursor-pointer">
                    <label for="on_sale" class="text-sm font-bold text-gray-700 cursor-pointer select-none">Hanya Produk Diskon</label>
                </div>
                <button type="submit"
                    class="bg-accent text-white px-8 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-[#5B3A29]/10 hover:brightness-110 active:scale-95 transition-all ml-0 md:ml-auto">
                    Terapkan
                </button>
                @if(request()->anyFilled(['category', 'min_price', 'max_price', 'sort']))
                    <a href="{{ url('/produk') }}" class="text-xs text-red-500 font-bold uppercase hover:underline">Reset</a>
                @endif
            </div>

            <div class="text-sm text-gray-400 font-medium">
                Menampilkan {{ $products->count() }} Produk
            </div>
        </form>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-x-8 gap-y-12">

            @forelse($products as $product)
            <article class="product-card group bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all" data-aos="fade-up">
                <div class="img-container relative aspect-[3/4] overflow-hidden bg-gray-100">
                    @php
                        $imagePath = $product->cover_image ? asset('storage/' . $product->cover_image) : ($product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://images.unsplash.com/photo-1589156191108-c762ff4b96ab?q=80&w=800&auto=format&fit=crop');
                    @endphp
                    <img src="{{ $imagePath }}" alt="{{ $product->name }}" class="w-full h-full object-cover text-xs text-secondary" />
                    @if($product->discount_price)
                        <div class="absolute top-4 left-4 z-10">
                            <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded">
                                -{{ $product->discount_percentage }}%
                            </span>
                        </div>
                    @endif
                    
                    <button
                        class="like-btn absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 shadow-sm hover:scale-110 transition-transform" data-id="{{ $product->id }}">
                        <i class="{{ in_array($product->id, $likedProductIds) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                    </button>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <span class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">{{ $product->category->name ?? 'Produk' }}</span>
                    <h4 class="text-lg font-semibold text-gray-800 mb-1 line-clamp-1">{{ $product->name }}</h4>
                    
                    <div class="flex items-center gap-2 mb-4">
                        @if($product->discount_price)
                            <span class="text-accent font-bold font-inter">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            <span class="text-gray-400 line-through text-[10px]">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @else
                            <span class="text-accent font-bold font-inter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    
                    <a href="{{ url('/detail-produk') }}/{{ $product->id }}"
                        class="block w-full btn-cream-dark text-white text-center font-semibold py-3 rounded-xl shadow-md transition-all">
                        <i class="fa-solid fa-eye mr-2"></i> Lihat Detail
                    </a>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-500 font-medium">Belum ada produk yang tersedia.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-20 flex justify-center items-center gap-2">
            <button
                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-accent hover:text-white transition-all"><i
                    class="fa-solid fa-chevron-left"></i></button>
            <button
                class="w-10 h-10 rounded-full bg-accent text-white flex items-center justify-center font-bold shadow-lg">1</button>
            <button
                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-accent hover:text-white transition-all">2</button>
            <button
                class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center hover:bg-accent hover:text-white transition-all"><i
                    class="fa-solid fa-chevron-right"></i></button>
        </div>
    </main>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/6282337115553"
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

        // Category filter toggle
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelector('.category-btn.active').classList.remove('active');
                btn.classList.add('active');
            });
        });

        // Hero video controls
        const heroVideo = document.getElementById('heroVideo');
        const heroMute = document.getElementById('heroMute');
        const heroPlayBtn = document.getElementById('heroPlayBtn');

        function setHeroMuteLabel() {
            if (!heroMute) return;
            heroMute.innerHTML = heroVideo && heroVideo.muted ? 'Unmute <i class="fa-solid fa-volume-high ml-2"></i>' : 'Mute <i class="fa-solid fa-volume-xmark ml-2"></i>';
        }

        function showPlayBtn() { if (heroPlayBtn) heroPlayBtn.classList.remove('hidden'); }
        function hidePlayBtn() { if (heroPlayBtn) heroPlayBtn.classList.add('hidden'); }

        if (heroVideo) {
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => {
                    heroVideo.play().then(() => {
                        hidePlayBtn();
                    }).catch(() => {
                        showPlayBtn();
                    });
                }, 200);
            });

            heroVideo.addEventListener('pause', () => { showPlayBtn(); });
            heroVideo.addEventListener('playing', () => { hidePlayBtn(); });
            heroVideo.addEventListener('ended', () => {
                heroVideo.currentTime = 0;
                heroVideo.play().catch(() => { });
            });

            if (heroPlayBtn) {
                heroPlayBtn.addEventListener('click', () => {
                    heroVideo.muted = true;
                    heroVideo.play().then(() => { hidePlayBtn(); }).catch(() => { });
                });
            }
        }

        if (heroMute && heroVideo) {
            setHeroMuteLabel();
            heroMute.addEventListener('click', () => {
                heroVideo.muted = !heroVideo.muted;
                setHeroMuteLabel();
                heroVideo.play().catch(() => { });
            });
        }
    </script>
@endsection
