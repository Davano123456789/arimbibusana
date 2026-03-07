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

        /* Color Button State */
        .color-btn.active {
            border-color: var(--accent);
            background-color: var(--accent);
            color: white;
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
                <li><a href="{{ url('/') }}" class="hover:text-accent">Beranda</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li><a href="{{ url('/produk') }}" class="hover:text-accent">Produk</a></li>
                <li><i class="fa-solid fa-chevron-right text-[10px] mx-2"></i></li>
                <li class="text-gray-900 font-medium">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-24">
            <!-- Left: Image Gallery -->
            <div class="space-y-4" data-aos="fade-right">
                <div
                    class="relative aspect-[4/5] overflow-hidden rounded-3xl bg-gray-100 shadow-sm border border-gray-50">
                    @php
                        $firstImage = $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://images.unsplash.com/photo-1589156191108-c762ff4b96ab?q=80&w=800&auto=format&fit=crop';
                    @endphp
                    <img id="mainImage" src="{{ $firstImage }}" alt="{{ $product->name }}"
                        class="w-full h-full object-cover transition-opacity duration-300" />
                </div>
                <div class="flex gap-4 overflow-x-auto no-scrollbar py-2">
                    @foreach($product->images as $key => $image)
                    <button
                        class="thumbnail-btn {{ $key == 0 ? 'thumb-active' : '' }} relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border-2 border-transparent transition-all"
                        data-img="{{ asset('storage/' . $image->image) }}"
                        data-color="{{ $image->color }}">
                        <img src="{{ asset('storage/' . $image->image) }}" class="w-full h-full object-cover" />
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="flex flex-col" data-aos="fade-left">
                <div class="mb-2">
                    @if($product->is_best_seller)
                    <span
                        class="inline-block px-3 py-1 bg-amber-50 text-accent text-[10px] font-bold uppercase tracking-widest rounded-full">Koleksi
                        Terlaris</span>
                    @endif
                    @if($product->is_recommended)
                    <span
                        class="inline-block px-3 py-1 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-widest rounded-full">Rekomendasi</span>
                    @endif
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-2 font-serif">{{ $product->name }}</h2>
                <div class="flex items-center gap-4 mb-6 text-gray-400 text-sm">
                    <div class="flex text-amber-400">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <span>(Rating Toko)</span>
                </div>

                <div class="flex items-center gap-3 mb-8">
                    @if($product->discount_price)
                        <span class="text-4xl font-bold text-gray-900 font-inter">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                        <span class="text-lg text-gray-400 line-through font-inter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-xs font-bold">-{{ $product->discount_percentage }}% OFF</span>
                    @else
                        <span class="text-4xl font-bold text-gray-900 font-inter">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>

                <div class="mb-8">
                    <h4 class="text-sm font-bold text-gray-900 mb-3 uppercase tracking-wider">Deskripsi Produk</h4>
                    <p class="text-gray-600 leading-relaxed text-sm">
                        {{ $product->description ?? 'Tidak ada deskripsi produk.' }}
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
                        <div class="flex gap-3 flex-wrap">
                            @foreach($product->sizes as $size)
                            <button 
                                class="size-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all {{ $size->stock == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" 
                                data-id="{{ $size->id }}"
                                data-stock="{{ $size->stock }}"
                                {{ $size->stock == 0 ? 'disabled' : '' }}>
                                {{ $size->size }}
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Colors -->
                    @php
                        $colors = $product->images->pluck('color')->unique()->filter();
                    @endphp
                    @if($colors->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Pilih Warna</h4>
                        <div class="flex gap-3 flex-wrap">
                            @foreach($colors as $color)
                            <button 
                                class="color-btn px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:border-accent transition-all" 
                                data-color="{{ $color }}">
                                {{ $color }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quantity -->
                    <div>
                        <h4 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Jumlah</h4>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center border border-gray-300 rounded-xl bg-white">
                                <button type="button" id="btnMinus" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-accent transition-colors"><i class="fa-solid fa-minus"></i></button>
                                <input type="number" id="qtyInput" value="1" min="1" max="{{ $product->stock }}" class="w-12 text-center border-none focus:ring-0 text-gray-900 font-bold p-0 appearance-none bg-transparent" readonly />
                                <button type="button" id="btnPlus" class="w-10 h-10 flex items-center justify-center text-gray-500 hover:text-accent transition-colors"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <span class="text-xs text-gray-500">Tersedia <span id="displayStock">{{ $product->stock }}</span> stok</span>
                        </div>
                    </div>
                </div>

                <!-- Call to Action -->
                {{-- 
                <form id="addToCartForm" action="{{ route('cart.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="size_id" id="sizeInput">
                    <input type="hidden" name="quantity" id="finalQtyInput" value="1">
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" id="addToCartBtn"
                            class="flex-1 btn-cream-dark py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-xl hover:brightness-110 transition-all active:scale-95">
                            <i class="fa-solid fa-cart-shopping fa-xl"></i> Masukkan ke Keranjang
                        </button>
                        <button type="button"
                            class="like-btn px-6 h-16 flex items-center justify-center gap-2 rounded-2xl border-2 {{ $isLiked ? 'bg-red-50 border-red-100' : 'border-gray-100' }} text-red-500 hover:bg-red-50 transition-all"
                            data-id="{{ $product->id }}">
                            <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                            <span id="likeCount" class="font-bold text-lg">{{ $product->likes_count }}</span>
                        </button>
                    </div>
                </form>
                --}}

                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <button type="button" id="btnOrderOlshop"
                        class="flex-1 bg-accent text-white py-4 rounded-2xl font-bold flex items-center justify-center gap-3 shadow-xl hover:brightness-110 transition-all active:scale-95">
                        <i class="fa-solid fa-shop fa-xl"></i> Pesan di Olshop Kami
                    </button>
                    <button type="button"
                        class="like-btn px-6 h-16 flex items-center justify-center gap-2 rounded-2xl border-2 {{ $isLiked ? 'bg-red-50 border-red-100' : 'border-gray-100' }} text-red-500 hover:bg-red-50 transition-all"
                        data-id="{{ $product->id }}">
                        <i class="{{ $isLiked ? 'fa-solid' : 'fa-regular' }} fa-heart fa-xl"></i>
                        <span id="likeCount" class="font-bold text-lg">{{ $product->likes_count }}</span>
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
            @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    iziToast.success({
                        title: 'Berhasil',
                        message: '{{ session("success") }}',
                        position: 'topRight',
                        transitionIn: 'fadeInDown',
                        timeout: 5000,
                        backgroundColor: '#FDF7F2',
                        titleColor: '#8C6A53',
                        messageColor: '#8C6A53',
                        icon: 'fa-solid fa-circle-check',
                        iconColor: '#8C6A53',
                    });
                });
            </script>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Review Form (4 cols) -->
                <div class="lg:col-span-4">
                    <div class="sticky top-24">
                        <h3 class="text-2xl font-bold font-serif mb-6">Tulis Ulasan</h3>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <form action="{{ url('/detail-produk/' . $product->id . '/ulasan') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Rating Kamu</label>
                                    <div class="flex gap-2 text-gray-300 text-xl cursor-pointer group-rating">
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors" data-value="1"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors" data-value="2"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors" data-value="3"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors" data-value="4"></i>
                                        <i class="fa-solid fa-star hover:text-amber-400 transition-colors" data-value="5"></i>
                                    </div>
                                    <input type="hidden" name="rating" id="ratingInput" value="5">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" required
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-white focus:border-accent focus:ring-2 focus:ring-accent/10 focus:outline-none transition-all"
                                        placeholder="Nama kamu...">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ulasan</label>
                                    <textarea name="comment" rows="4" required
                                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-white focus:border-accent focus:ring-2 focus:ring-accent/10 focus:outline-none transition-all resize-none"
                                        placeholder="Ceritakan pengalamanmu..."></textarea>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Foto Testimoni (Opsional)</label>
                                    <div class="relative">
                                        <input type="file" name="image" id="reviewImage" accept="image/*" class="hidden" onchange="previewReviewImage(this)">
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
                                <button type="submit"
                                    class="w-full btn-cream-dark py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all active:scale-95">Kirim
                                    Ulasan</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right: Reviews List (8 cols) -->
                <div class="lg:col-span-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-2xl font-bold font-serif">Ulasan Pembeli ({{ $product->testimonials->count() }})</h3>
                    </div>

                    <div class="space-y-6">
                        @forelse($product->testimonials as $testi)
                        <div class="flex gap-4 p-6 bg-white rounded-2xl border border-gray-100 shadow-sm transition-all hover:shadow-md">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 rounded-full bg-accent/10 text-accent flex items-center justify-center font-bold text-lg">
                                    {{ strtoupper(substr($testi->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $testi->name }}</h4>
                                        <div class="flex text-amber-400 text-xs mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="{{ $i <= $testi->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400">{{ $testi->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-600 text-sm leading-relaxed">{{ $testi->comment }}</p>

                                @if($testi->image)
                                <div class="flex gap-2 mt-4">
                                    <div class="w-24 h-24 rounded-xl bg-gray-100 overflow-hidden cursor-pointer hover:opacity-90 border border-gray-200 transition-all">
                                        <img src="{{ asset('storage/' . $testi->image) }}" class="w-full h-full object-cover" onclick="window.open(this.src)">
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                            <i class="fa-solid fa-message-slash text-4xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500">Belum ada ulasan untuk produk ini.<br>Jadilah yang pertama memberikan ulasan!</p>
                        </div>
                        @endforelse
                    </div>

                    @if($product->testimonials->count() > 5)
                    <button
                        class="w-full mt-8 py-3 border border-gray-200 rounded-xl text-gray-500 font-medium hover:bg-gray-50 transition-colors">
                        Lihat Semua Ulasan
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-20">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold font-serif">Produk Lainnya</h3>
                <a href="{{ url('/produk') }}"
                    class="text-sm text-accent font-semibold flex items-center gap-1 underline underline-offset-4 decoration-accent/20">Lihat
                    Semua <i class="fa-solid fa-arrow-right"></i></a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                @forelse($relatedProducts as $item)
                <article class="product-card group">
                    <div class="img-container relative aspect-[3/4] overflow-hidden rounded-2xl bg-gray-100 mb-4">
                        @php
                            $relatedImage = $item->images->first() ? asset('storage/' . $item->images->first()->image) : asset('images/placeholder.jpg');
                        @endphp
                        <img src="{{ $relatedImage }}" alt="{{ $item->name }}" class="w-full h-full object-cover" />
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-black/20 transition-all duration-500">
                        </div>
                        <button
                            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/90 flex items-center justify-center text-red-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all shadow-sm">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <div
                            class="absolute bottom-4 left-4 right-4 translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all text-center px-4">
                            <a href="{{ url('/detail-produk/' . $item->id) }}"
                                class="block w-full bg-white text-gray-900 font-semibold py-3 rounded-xl shadow-xl hover:bg-accent hover:text-white transition-colors">
                                <i class="fa-solid fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-[10px] text-accent font-bold uppercase tracking-wider mb-1 block">{{ $item->category->name ?? 'Busana' }}</span>
                        <h4 class="text-lg font-semibold text-gray-800 mb-1 leading-tight">{{ $item->name }}</h4>
                        <p class="text-accent font-bold font-inter text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-8 text-center text-gray-500 italic">
                    Belum ada produk terkait lainnya.
                </div>
                @endforelse
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
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Size Guide {{ $product->name }}</h3>
                <div class="rounded-2xl overflow-hidden shadow-inner bg-gray-50 p-2">
                    @if($product->size_guide)
                        <img src="{{ asset('storage/' . $product->size_guide) }}" alt="Size Guide {{ $product->name }}" class="w-full h-auto" />
                    @else
                        <img src="{{ asset('images/sizeguide.jpg') }}" alt="Size Guide Default" class="w-full h-auto" />
                    @endif
                </div>
                <p class="mt-6 text-sm text-gray-500 italic">*) Ukuran dapat berbeda 1-2 cm karena proses produksi
                    massal.</p>
            </div>
        </div>
    </div>

    <!-- Olshop Selection Modal -->
    <div id="olshopModal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity duration-300" id="olshopModalBackdrop"></div>
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all scale-95 opacity-0 duration-300"
            id="olshopModalContent">
            <button id="closeOlshopModal"
                class="absolute right-4 top-4 z-20 bg-gray-100 hover:bg-gray-200 p-2 rounded-full text-gray-800 transition-colors">
                <i class="fa-solid fa-xmark fa-lg"></i>
            </button>
            <div class="p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-2 text-center font-serif">Pesan Sekarang</h3>
                <p class="text-gray-500 text-sm text-center mb-8">Pilih platform favorit Anda</p>
                
                <div class="grid gap-4">
                    <!-- TikTok -->
                    <a href="https://www.tiktok.com/@arimbiqueenscarves" target="_blank" 
                        class="flex items-center gap-4 p-4 rounded-2xl bg-[#000000] text-white hover:scale-[1.02] transition-transform shadow-md group">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <i class="fa-brands fa-tiktok text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="block font-bold text-base">TikTok Shop</span>
                            <span class="text-xs text-white/60">@arimbiqueenscarves</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-40 group-hover:opacity-100 transition-opacity"></i>
                    </a>

                    <!-- Shopee -->
                    <a href="https://shopee.co.id/ArimbiQueen.Scarves" target="_blank" 
                        class="flex items-center gap-4 p-4 rounded-2xl bg-[#EE4D2D] text-white hover:scale-[1.02] transition-transform shadow-md group">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                           <i class="fa-solid fa-bag-shopping text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="block font-bold text-base">Shopee</span>
                            <span class="text-xs text-white/60">ArimbiQueen.Scarves</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-40 group-hover:opacity-100 transition-opacity"></i>
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://wa.me/6282337115553?text=Halo%20Arimbi%20Queen,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->name) }}" target="_blank" 
                        class="flex items-center gap-4 p-4 rounded-2xl bg-[#25D366] text-white hover:scale-[1.02] transition-transform shadow-md group">
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center group-hover:bg-white/20 transition-colors">
                            <i class="fa-brands fa-whatsapp text-3xl"></i>
                        </div>
                        <div class="flex-1">
                            <span class="block font-bold text-base">WhatsApp</span>
                            <span class="text-xs text-white/60">0823-3711-5553</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs opacity-40 group-hover:opacity-100 transition-opacity"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/6282337115553"
        class="fixed bottom-6 right-6 z-50 bg-[#25D366] text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl shadow-2xl hover:bg-[#128C7E] transition-all hover:scale-110 active:scale-95 duration-300"
        aria-label="Chat via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Product Detail Scripts Initialized');

            // 1. Image Gallery Logic
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail-btn');
            const colorBtns = document.querySelectorAll('.color-btn');
            let selectedColor = null;

            if (mainImage && thumbnails.length > 0) {
                thumbnails.forEach(btn => {
                    btn.addEventListener('click', () => {
                        const newImg = btn.getAttribute('data-img');
                        if (!newImg) return;

                        mainImage.style.opacity = '0';
                        setTimeout(() => {
                            mainImage.src = newImg;
                            mainImage.style.opacity = '1';
                        }, 150);

                        thumbnails.forEach(t => t.classList.remove('thumb-active'));
                        btn.classList.add('thumb-active');

                        // Sync with colors: Highlight color button if thumb has color
                        const color = btn.getAttribute('data-color');
                        if (color && typeof colorBtns !== 'undefined') {
                            colorBtns.forEach(b => {
                                if (b.getAttribute('data-color') === color) {
                                    b.classList.add('active');
                                    selectedColor = color;
                                } else {
                                    b.classList.remove('active');
                                }
                            });
                        }
                    });
                });
            }

            // 2. Size & Stock Selection Logic
            const sizeBtns = document.querySelectorAll('.size-btn');
            const displayStock = document.getElementById('displayStock');
            const qtyInput = document.getElementById('qtyInput');
            const sizeInput = document.getElementById('sizeInput');
            const finalQtyInput = document.getElementById('finalQtyInput');
            let selectedSizeId = null;
            const selectColor = (btn) => {
                colorBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedColor = btn.getAttribute('data-color');

                // Sync with gallery: Find first thumbnail with this color
                const matchedThumb = Array.from(thumbnails).find(t => t.getAttribute('data-color') === selectedColor);
                if (matchedThumb) {
                    matchedThumb.click();
                }
            };

            colorBtns.forEach(btn => {
                btn.addEventListener('click', () => selectColor(btn));
            });

            // Auto-select first color if available
            if (colorBtns.length > 0) {
                selectColor(colorBtns[0]);
            }

            const selectSize = (btn) => {
                if (btn.disabled) return;
                
                sizeBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedSizeId = btn.getAttribute('data-id');
                if (sizeInput) sizeInput.value = selectedSizeId;
                
                const stock = parseInt(btn.getAttribute('data-stock') || '0');
                if (displayStock) displayStock.textContent = stock;
                if (qtyInput) {
                    qtyInput.setAttribute('max', stock);
                    if (parseInt(qtyInput.value) > stock) {
                        qtyInput.value = stock;
                    }
                    if (finalQtyInput) finalQtyInput.value = qtyInput.value;
                }
            };
            
            // Note: need to add data-id to size buttons in Blade first
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', () => selectSize(btn));
            });

            // Auto-select first available size
            const firstAvailableSize = Array.from(sizeBtns).find(btn => !btn.disabled);
            if (firstAvailableSize) {
                selectSize(firstAvailableSize);
            }

            // 3. Quantity Controls
            const btnMinus = document.getElementById('btnMinus');
            const btnPlus = document.getElementById('btnPlus');

            if (btnMinus && btnPlus && qtyInput) {
                btnMinus.addEventListener('click', () => {
                    let val = parseInt(qtyInput.value) || 1;
                    if (val > 1) {
                        qtyInput.value = val - 1;
                        if (finalQtyInput) finalQtyInput.value = qtyInput.value;
                    }
                });

                btnPlus.addEventListener('click', () => {
                    let val = parseInt(qtyInput.value) || 1;
                    let max = parseInt(qtyInput.getAttribute('max') || '999');
                    if (val < max) {
                        qtyInput.value = val + 1;
                        if (finalQtyInput) finalQtyInput.value = qtyInput.value;
                    } else {
                        alert('Maaf, stok tidak mencukupi.');
                    }
                });
            }

            // 4. Like Counter Logic (Live with Database)
            // ... (rest of the file)
            const likeBtn = document.querySelector('.like-btn');
            if (likeBtn) {
                likeBtn.addEventListener('click', function(e) {
                    const productId = this.getAttribute('data-id');
                    const icon = this.querySelector('i');
                    const countSpan = document.getElementById('likeCount');
                    const btn = this;

                    // Prevent multiple clicks
                    if (btn.classList.contains('pointer-events-none')) return;
                    btn.classList.add('pointer-events-none');

                    fetch(`/detail-produk/${productId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        btn.classList.remove('pointer-events-none');
                        if (data.status === 'liked') {
                            icon.classList.remove('fa-regular');
                            icon.classList.add('fa-solid');
                            btn.classList.add('bg-red-50', 'border-red-100');
                            btn.classList.remove('border-gray-100');
                        } else {
                            icon.classList.remove('fa-solid');
                            icon.classList.add('fa-regular');
                            btn.classList.remove('bg-red-50', 'border-red-100');
                            btn.classList.add('border-gray-100');
                        }
                        countSpan.textContent = data.likes_count;
                    })
                    .catch(error => {
                        btn.classList.remove('pointer-events-none');
                        console.error('Error:', error);
                        iziToast.error({
                            title: 'Error',
                            message: 'Gagal memproses Like. Silakan coba lagi.',
                            position: 'topRight'
                        });
                    });
                });
            }

            // 5. Review Star Rating Logic
            const ratingContainer = document.querySelector('.group-rating');
            const ratingInput = document.getElementById('ratingInput');
            
            if (ratingContainer && ratingInput) {
                const stars = ratingContainer.querySelectorAll('i');
                stars.forEach((star, index) => {
                    star.addEventListener('click', () => {
                        const val = index + 1;
                        ratingInput.value = val;
                        
                        stars.forEach((s, i) => {
                            if (i <= index) {
                                s.classList.remove('text-gray-300', 'fa-regular');
                                s.classList.add('text-amber-400', 'fa-solid');
                            } else {
                                s.classList.add('text-gray-300', 'fa-regular');
                                s.classList.remove('text-amber-400', 'fa-solid');
                            }
                        });
                    });
                });
                
                // Initialize default (5 stars)
                stars[4].click();
            }

            // 6. Size Guide Modal
            const modalSize = document.getElementById('sizeGuideModal');
            const contentSize = document.getElementById('modalContent');
            const showBtnSize = document.getElementById('showSizeGuide');
            const closeBtnSize = document.getElementById('closeSizeGuide');
            const backdropSize = document.getElementById('modalBackdrop');

            if (showBtnSize && modalSize && contentSize) {
                showBtnSize.addEventListener('click', () => {
                    modalSize.classList.remove('hidden');
                    modalSize.classList.add('flex');
                    setTimeout(() => {
                        contentSize.classList.remove('scale-95', 'opacity-0');
                        contentSize.classList.add('scale-100', 'opacity-100');
                    }, 10);
                });

                const closeModal = () => {
                    contentSize.classList.remove('scale-100', 'opacity-100');
                    contentSize.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        modalSize.classList.add('hidden');
                        modalSize.classList.remove('flex');
                    }, 300);
                };

                if (closeBtnSize) closeBtnSize.addEventListener('click', closeModal);
                if (backdropSize) backdropSize.addEventListener('click', closeModal);
            }

            // 7. Add to Cart Logic
            const addToCartForm = document.getElementById('addToCartForm');
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', function(e) {
                    @guest
                        e.preventDefault();
                        iziToast.warning({
                            title: 'Login Diperlukan',
                            message: 'Silakan login terlebih dahulu untuk menambah produk ke keranjang.',
                            position: 'topRight'
                        });
                        setTimeout(() => {
                            window.location.href = "{{ route('login') }}";
                        }, 2000);
                        return;
                    @endguest

                    if (!selectedSizeId) {
                        e.preventDefault();
                        alert('Silakan pilih ukuran terlebih dahulu!');
                    }
                });
            }

            // 8. Olshop Modal Logic
            const olshopModal = document.getElementById('olshopModal');
            const olshopModalContent = document.getElementById('olshopModalContent');
            const showOlshopBtn = document.getElementById('btnOrderOlshop');
            const closeOlshopBtn = document.getElementById('closeOlshopModal');
            const olshopBackdrop = document.getElementById('olshopModalBackdrop');

            if (showOlshopBtn && olshopModal && olshopModalContent) {
                showOlshopBtn.addEventListener('click', () => {
                    // Validation before opening modal
                    if (!selectedSizeId) {
                        alert('Silakan pilih ukuran terlebih dahulu!');
                        return;
                    }
                    if (colorBtns.length > 0 && !selectedColor) {
                        alert('Silakan pilih warna terlebih dahulu!');
                        return;
                    }

                    // Update WA Link with selected variants
                    const waLink = olshopModal.querySelector('a[href^="https://wa.me/"]');
                    if (waLink) {
                        const productName = "{{ $product->name }}";
                        const activeSizeBtn = document.querySelector('.size-btn.active');
                        const sizeName = activeSizeBtn ? activeSizeBtn.textContent.trim() : '-';
                        const colorName = selectedColor ? ` warna ${selectedColor}` : '';
                        const quantity = qtyInput.value;
                        const message = `Halo Arimbi Queen, saya tertarik dengan produk ${productName} ukuran ${sizeName}${colorName} sebanyak ${quantity} pcs.`;
                        waLink.href = `https://wa.me/6282337115553?text=${encodeURIComponent(message)}`;
                    }

                    olshopModal.classList.remove('hidden');
                    olshopModal.classList.add('flex');
                    setTimeout(() => {
                        olshopModalContent.classList.remove('scale-95', 'opacity-0');
                        olshopModalContent.classList.add('scale-100', 'opacity-100');
                    }, 10);
                });

                const closeOlshop = () => {
                    olshopModalContent.classList.remove('scale-100', 'opacity-100');
                    olshopModalContent.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => {
                        olshopModal.classList.add('hidden');
                        olshopModal.classList.remove('flex');
                    }, 300);
                };

                if (closeOlshopBtn) closeOlshopBtn.addEventListener('click', closeOlshop);
                if (olshopBackdrop) olshopBackdrop.addEventListener('click', closeOlshop);
            }
        });

        // Global functions for Review Image Preview
        window.previewReviewImage = function(input) {
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');
            const container = input.nextElementSibling;
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview) {
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    if (placeholder) placeholder.classList.add('hidden');
                    if (removeBtn) removeBtn.classList.remove('hidden');
                    if (container) {
                        container.classList.add('border-accent', 'bg-gray-50');
                        container.classList.remove('border-gray-300', 'border-dashed');
                    }
                }
                reader.readAsDataURL(input.files[0]);
            }
        };

        window.removeReviewImage = function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const input = document.getElementById('reviewImage');
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const removeBtn = document.getElementById('removeImageBtn');
            
            if (input) {
                input.value = '';
                const container = input.nextElementSibling;
                if (container) {
                    container.classList.remove('border-accent', 'bg-gray-50');
                    container.classList.add('border-gray-300', 'border-dashed');
                }
            }
            if (preview) {
                preview.src = '';
                preview.classList.add('hidden');
            }
            if (placeholder) placeholder.classList.remove('hidden');
            if (removeBtn) removeBtn.classList.add('hidden');
        };
    </script>
@endsection
