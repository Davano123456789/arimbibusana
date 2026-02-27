@extends('layouts.masterPublic')

@section('title', 'Arimbi Queen — Beranda')

@section('description', 'Arimbi Queen - Scarf premium, mukena, hijab, busana wanita. Toko wanita anggun, sopan, percaya diri.')

@section('head')
  <style>
    :root {
      --cream: #F5ECE0;
      --dark-cream: #E8D9C5;
      --cream-dark: #B78A58;
      /* krem tua, solid */
      --accent: #5B3A29;
      /* warm brown */
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

    /* darker cream button utilities (solid, more visible) */
    .bg-cream-dark {
      background-color: var(--cream-dark);
    }

    .btn-cream-dark {
      background-color: var(--cream-dark);
      color: #ffffff;
      box-shadow: 0 6px 18px rgba(87, 52, 34, 0.12);
      border: 1px solid rgba(0, 0, 0, 0.04);
    }

    .btn-cream-dark:hover {
      filter: brightness(0.93);
    }

    .btn-cream-dark:active {
      transform: translateY(1px);
    }

    .btn-cream-dark i {
      color: #ffffff;
    }

    /* small utilities not available by default */
    .bg-cream {
      background-color: var(--cream);
    }

    .text-accent {
      color: var(--accent);
    }

    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(13, 12, 11, 0.08);
    }

    .product-card .img-container {
      overflow: hidden;
      position: relative;
    }

    .product-card .img-container img {
      transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .product-card:hover .img-container img {
      transform: scale(1.1);
    }

    .img-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.3) 0%, transparent 70%);
      opacity: 0;
      transition: opacity 0.4s ease;
      pointer-events: none;
      z-index: 5;
    }

    .product-card:hover .img-overlay {
      opacity: 1;
    }

    /* Slider & slide image */
    .slide-img {
      transition: transform .45s cubic-bezier(.2, .9, .2, 1);
    }

    .slide:hover .slide-img {
      transform: scale(1.06);
    }

    .slider-track {
      scroll-behavior: smooth;
    }

    .slider-btn {
      transition: transform .15s ease;
    }

    .slider-btn:hover {
      transform: scale(1.05);
    }

    /* prevent scrollbar visual jump on some browsers */
    .no-scrollbar::-webkit-scrollbar {
      display: none;
    }

    .no-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    /* Floating WA Animation */
    @keyframes floating {
      0% {
        transform: translateY(0px);
      }

      50% {
        transform: translateY(-10px);
      }

      100% {
        transform: translateY(0px);
      }
    }

    .floating-wa {
      animation: floating 3s ease-in-out infinite;
      box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4);
    }

    .floating-wa:hover {
      animation-play-state: paused;
      transform: scale(1.1);
    }

    /* Smooth Mobile Menu Animation */
    #mobileMenu {
      transition: visibility 0.4s;
    }

    #mobileMenu.hidden {
      visibility: hidden;
      display: flex !important;
      /* Keep display flex but hidden via visibility and opacity */
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

  <!-- Promotional Popup Overlay -->
  <div id="promoPopup" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" id="promoBackdrop"></div>
    <div
      class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-95 opacity-0 duration-500"
      id="promoContent">
      <button id="closePromo"
        class="absolute right-4 top-4 z-20 bg-gray-100 hover:bg-gray-200 p-2 rounded-full shadow-md text-gray-800 transition-colors">
        <i class="fa-solid fa-xmark fa-lg"></i>
      </button>

      <div class="relative h-48 md:h-56 overflow-hidden">
        <img src="images/infopopup.jpg" alt="Special Promo" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-t from-white/20 to-transparent"></div>
      </div>

      <div class="p-8 text-center">
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Koleksi Terbaru!</h3>
        <p class="text-sm text-gray-600 mb-6 leading-relaxed px-4">Dapatkan penawaran eksklusif untuk koleksi premium
          Arimbi Queen. Anggun, Sopan, dan Percaya Diri.</p>
        <div class="flex flex-col gap-3">
          <a href="#produk" id="promoAction"
            class="bg-[#B78A58] text-white text-sm font-bold py-3.5 px-6 rounded-2xl shadow-xl hover:brightness-110 transition-all flex items-center justify-center gap-2 transform active:scale-95">
            Lihat Koleksi Sekarang <i class="fa-solid fa-arrow-right"></i>
          </a>
          <button id="closePromoBtn" class="text-xs text-gray-400 hover:text-gray-600 transition-colors py-2">Nanti
            Saja</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero / Promo Banner (Video) -->
  <section class="relative">
    <div class="relative h-[80vh] md:h-[90vh] w-full overflow-hidden bg-black">
      <video id="heroVideo" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline
        poster="https://images.unsplash.com/photo-1520975911600-5d36cb2d6f6f?q=80&w=1600&auto=format&fit=crop&ixlib=rb-4.0.3&s=0ffb93b7d8f8f5b2e9a3e2a6f2a4a7f7">
        <source src="{{ asset('videos/video-hero.mp4') }}" type="video/mp4">
        <!-- Fallback image -->
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
        <div class="max-w-xl text-white drop-shadow-lg">
          <span class="inline-block mb-3 bg-amber-100 text-accent px-3 py-1 rounded-full text-sm font-medium">Promo
            Baru</span>
          <h2 class="text-4xl md:text-6xl font-bold leading-tight mb-4" data-aos="fade-up">Scarf Premium & Mukena Elegan
          </h2>
          <p class="mb-6 text-white/95" data-aos="fade-up" data-aos-delay="200">Koleksi elegan untuk wanita modern.
            Nyaman dipakai sehari-hari atau untuk momen
            spesial.</p>

          <div class="flex gap-3" data-aos="fade-up" data-aos-delay="400">
            <a href="#produk" class="bg-accent text-white px-5 py-3 rounded shadow">Lihat Koleksi</a>
            <a href="#testimoni" class="border border-gray-300 px-5 py-3 rounded">Lihat Testimoni</a>
            <button id="heroMute"
              class="hidden md:inline-flex items-center gap-2 border border-gray-200 px-4 py-2 rounded text-sm bg-white/10">Unmute
              <i class="fa-solid fa-volume-high ml-2"></i></button>
          </div>

        </div>
      </div>
    </div>
  </section>

  <main class="max-w-6xl mx-auto px-6 -mt-10">

    <!-- Brand Story / Information Section -->
    <section id="tentang" class="mt-24 mb-16 overflow-hidden rounded-2xl bg-cream/30" data-aos="fade-up">
      <div class="grid md:grid-cols-2 gap-0 overflow-hidden">
        <div class="p-8 md:p-12 flex flex-col justify-center order-2 md:order-1" data-aos="fade-right">
          <span class="text-accent/60 uppercase tracking-widest text-xs font-semibold mb-2">Tentang Kami</span>
          <h2 class="text-2xl md:text-3xl font-bold text-gray-900 leading-tight mb-4">Filosofi Keanggunan Arimbi Queen
          </h2>
          <p class="text-sm text-gray-600 leading-relaxed mb-6">
            Terinspirasi dari kelembutan dan kekuatan wanita, Arimbi Queen hadir untuk memberikan koleksi busana yang
            tidak hanya indah secara visual, tetapi juga nyaman dan sopan dalam setiap detiknya.
            <br><br>
            Kami percaya bahwa kepercayaan diri dimulai dari kenyamanan. Itulah mengapa setiap helai kain yang kami
            pilih melalui proses seleksi ketat untuk memastikan kualitas premium bagi Anda.
          </p>
          <div class="grid grid-cols-2 gap-6 pt-2">
            <div>
              <h4 class="text-xl font-bold text-accent mb-0 underline decoration-amber-200 underline-offset-4">Premium
              </h4>
              <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Bahan Pilihan Terbaik</p>
            </div>
            <div>
              <h4 class="text-xl font-bold text-accent mb-0 underline decoration-amber-200 underline-offset-4">Elegant
              </h4>
              <p class="text-[10px] text-gray-500 uppercase tracking-wider font-semibold">Desain Eksklusif</p>
            </div>
          </div>
        </div>
        <div class="relative h-64 md:h-[400px] overflow-hidden order-1 md:order-2" data-aos="fade-left">
          <img src="images/tentangkamibusana.jpg" alt="Arimbi Queen Brand Story"
            class="w-full h-full object-cover transition-transform duration-1000 scale-105 hover:scale-100" />
        </div>
      </div>
    </section>



    <!-- Produk & View All -->
    <section id="produk-unggulan" class="mt-20" data-aos="fade-up">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-2xl font-semibold flex items-center gap-2" data-aos="fade-right"><i
            class="fa-solid fa-star text-amber-500"></i>
          Produk Unggulan</h3>
        <a href="#" class="text-sm text-accent" data-aos="fade-left">Lihat Semua <i
            class="fa-solid fa-chevron-right ml-1"></i></a>
      </div>

      <div class="relative">
        <!-- arrows -->
        <button id="prevFeatured"
          class="slider-btn absolute left-0 top-1/2 -translate-y-1/2 z-20 p-3 bg-white rounded-full shadow-md ml-2"
          aria-label="Sebelumnya" title="Sebelumnya"><i class="fa-solid fa-chevron-left text-accent"></i></button>
        <button id="nextFeatured"
          class="slider-btn absolute right-0 top-1/2 -translate-y-1/2 z-20 p-3 bg-white rounded-full shadow-md mr-2"
          aria-label="Berikutnya" title="Berikutnya"><i class="fa-solid fa-chevron-right text-accent"></i></button>

        <div id="featuredTrack" class="overflow-hidden">
          <div id="featuredTrackInner" class="flex gap-6 no-scrollbar">

            <!-- Slides using local images busana1..busana6 -->

            @foreach($bestSellers as $product)
            <article
              class="slide bg-white rounded-lg overflow-hidden min-w-[85%] md:min-w-[32%] lg:min-w-[23%] shadow-sm">
              <div class="relative">
                @php
                    $imagePath = $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://images.unsplash.com/photo-1589156191108-c762ff4b96ab?q=80&w=800&auto=format&fit=crop';
                @endphp
                <img class="slide-img w-full h-52 object-cover" src="{{ $imagePath }}" alt="{{ $product->name }}"
                  loading="lazy" />
                <button class="absolute right-3 top-3 bg-white/80 text-red-500 p-2 rounded-full shadow like-btn"><i
                    class="fa-regular fa-heart"></i></button>
              </div>
              <div class="p-4">
                <h4 class="font-medium">{{ $product->name }}</h4>
                <p class="text-sm text-gray-500 mt-1 line-clamp-1">{{ $product->description ?? 'Bahan premium, desain elegan.' }}</p>
                <p class="text-sm font-bold text-accent mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center gap-3">
                  <a href="{{ url('/detail-produk/' . $product->id) }}"
                    class="flex-1 text-center btn-cream-dark text-white px-3 py-2 rounded flex items-center justify-center gap-2">
                    <i class="fa-solid fa-eye"></i> Lihat Detail
                  </a>
                  <a href="#" class="inline-flex items-center gap-2 btn-cream-dark px-3 py-2 rounded shadow-md text-white transition-colors"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
              </div>
            </article>
            @endforeach

          </div>
        </div>
      </div>
    </section>

    <!-- Produk (Grid 3x3) -->
    <section id="produk" class="mt-20" data-aos="fade-up">
      <div class="flex items-center justify-between mb-8">
        <h3 class="text-2xl font-semibold">Produk</h3>
        <a href="#" class="text-sm text-accent">Lihat Semua <i class="fa-solid fa-chevron-right ml-1"></i></a>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($latestProducts as $product)
        <article class="product-card bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-all">
          <div class="img-container relative">
            @php
                $imagePath = $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://images.unsplash.com/photo-1589156191108-c762ff4b96ab?q=80&w=800&auto=format&fit=crop';
            @endphp
            <img class="w-full h-72 object-cover" src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy" />
            <div class="img-overlay"></div>
            <button
              class="absolute right-3 top-3 bg-white/80 text-red-500 p-2 rounded-full shadow-lg like-btn z-10 transition-transform hover:scale-110">
              <i class="fa-regular fa-heart"></i>
            </button>
          </div>
          <div class="p-6">
            <h4 class="font-medium text-lg text-gray-900 font-serif">{{ $product->name }}</h4>
            <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $product->description ?? 'Bahan premium yang lembut dan desain yang sangat elegan.' }}</p>
            <p class="text-accent font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <div class="mt-6 flex items-center gap-3">
              <a href="{{ url('/detail-produk/' . $product->id) }}"
                class="flex-1 text-center btn-cream-dark text-white px-3 py-2 rounded flex items-center justify-center gap-2">
                <i class="fa-solid fa-eye"></i> Lihat Detail
              </a>
              <a href="#" class="inline-flex items-center gap-2 btn-cream-dark px-3 py-2 rounded shadow-md text-white transition-colors"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
          </div>
        </article>
        @endforeach
      </div>
    </section>



    <!-- Yang Kamu Suka (recommend slider) -->
    <section id="recommendation" class="mt-20">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-semibold flex items-center gap-2"><i class="fa-solid fa-heart text-red-500"></i> Yang
          Kamu Suka</h3>
        <a href="#" class="text-sm text-accent">Lihat Semua <i class="fa-solid fa-chevron-right ml-1"></i></a>
      </div>

      <div class="relative">
        <!-- arrows -->
        <button id="prevRecommend"
          class="slider-btn absolute left-0 top-1/2 -translate-y-1/2 z-20 p-3 bg-white rounded-full shadow-md ml-2"
          aria-label="Sebelumnya" title="Sebelumnya"><i class="fa-solid fa-chevron-left text-accent"></i></button>
        <button id="nextRecommend"
          class="slider-btn absolute right-0 top-1/2 -translate-y-1/2 z-20 p-3 bg-white rounded-full shadow-md mr-2"
          aria-label="Berikutnya" title="Berikutnya"><i class="fa-solid fa-chevron-right text-accent"></i></button>

        <div id="recommendTrack" class="overflow-hidden">
          <div id="recommendTrackInner" class="flex gap-6 no-scrollbar">

            @foreach($recommended as $product)
            <article
              class="slide bg-white rounded-lg overflow-hidden min-w-[85%] md:min-w-[32%] lg:min-w-[23%] shadow-sm">
              <div class="img-container relative">
                @php
                    $imagePath = $product->images->first() ? asset('storage/' . $product->images->first()->image) : 'https://images.unsplash.com/photo-1589156191108-c762ff4b96ab?q=80&w=800&auto=format&fit=crop';
                @endphp
                <img class="w-full h-52 object-cover" src="{{ $imagePath }}" alt="{{ $product->name }}" loading="lazy" />
                <div class="img-overlay"></div>
                <button class="absolute right-3 top-3 bg-white/80 text-red-500 p-2 rounded-full shadow like-btn z-10"><i
                    class="fa-regular fa-heart"></i></button>
              </div>
              <div class="p-4">
                <h4 class="font-medium">{{ $product->name }}</h4>
                <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <div class="mt-4 flex items-center gap-2">
                  <a href="{{ url('/detail-produk/' . $product->id) }}"
                    class="flex-1 text-center text-xs btn-cream-dark text-white px-2 py-2 rounded">Lihat Detail</a>
                  <a href="#" class="inline-flex items-center justify-center btn-cream-dark px-3 py-2 rounded shadow-md text-white transition-colors text-xs"><i class="fa-solid fa-cart-shopping"></i></a>
                </div>
              </div>
            </article>
            @endforeach

          </div>
        </div>
      </div>
    </section>


    <!-- Testimoni -->
    <section id="testimoni" class="mt-12 mb-24" data-aos="fade-up">
      <h3 class="text-2xl font-semibold mb-8 text-center" data-aos="fade-up">Testimoni Pelanggan</h3>
      <div class="grid md:grid-cols-3 gap-8">
        <!-- Testi 1 -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-8 border border-gray-50"
          data-aos="fade-up" data-aos-delay="100">
          <div class="flex items-center gap-4">
            <img src="images/testi1.jpg" alt="Nadhira" class="w-14 h-14 rounded-full object-cover ring-2 ring-amber-50">
            <div>
              <p class="font-bold text-gray-900">Nadhira</p>
              <p class="text-xs text-gray-500">Jakarta</p>
            </div>
            <div class="ml-auto text-amber-400 text-xs">
              <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="mt-6 text-gray-600 italic leading-relaxed text-sm">"Mukena sangat lembut and desainnya elegan.
            Packing rapi, pengiriman cepat!"</p>
        </div>

        <!-- Testi 2 -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-8 border border-gray-50"
          data-aos="fade-up" data-aos-delay="200">
          <div class="flex items-center gap-4">
            <img src="images/testi2.jpg" alt="Siti" class="w-14 h-14 rounded-full object-cover ring-2 ring-amber-50">
            <div>
              <p class="font-bold text-gray-900">Siti</p>
              <p class="text-xs text-gray-500">Bandung</p>
            </div>
            <div class="ml-auto text-amber-400 text-xs">
              <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="mt-6 text-gray-600 italic leading-relaxed text-sm">"Scarf nyaman dipakai seharian, warnanya tidak
            pudar setelah dicuci."</p>
        </div>

        <!-- Testi 3 -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow p-8 border border-gray-50"
          data-aos="fade-up" data-aos-delay="300">
          <div class="flex items-center gap-4">
            <img src="images/testi3.jpg" alt="Amina" class="w-14 h-14 rounded-full object-cover ring-2 ring-amber-50">
            <div>
              <p class="font-bold text-gray-900">Amina</p>
              <p class="text-xs text-gray-500">Surabaya</p>
            </div>
            <div class="ml-auto text-amber-400 text-xs">
              <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="mt-6 text-gray-600 italic leading-relaxed text-sm">"Suka banget dengan service dan kualitas produk
            Arimbi Queen."</p>
        </div>
      </div>

    
    </section>

    <!-- Informasi Kami (Map & Social Media) -->
    <section id="informasi" class="mb-24">
      <h3 class="text-2xl font-semibold mb-8">Informasi Kami</h3>
      <div class="grid md:grid-cols-2 gap-10 items-center bg-cream/20 p-8 rounded-3xl">
        <!-- Left: Google Map -->
        <div class="overflow-hidden rounded-2xl shadow-lg h-80">
          <iframe class="w-full h-full"
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d317714.2718115563!2d106.6894311!3d-6.2293863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3b1b8b0a1a9%3A0x7c9a3f2e6a1a4f!2sJakarta!5e0!3m2!1sid!2sid!4v1670000000000!5m2!1sid!2sid"
            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

        <!-- Right: Social Media -->
        <div class="flex flex-col gap-6">
          <div>
            <h4 class="text-xl font-bold text-gray-900 mb-2">Terhubung dengan Kami</h4>
            <p class="text-gray-600 text-sm">Ikuti update terbaru koleksi kami dan dapatkan promo menarik setiap
              minggunya melalui media sosial resmi kami.</p>
          </div>

          <div class="grid grid-cols-2 gap-4">
            <a href="https://instagram.com"
              class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all group">
              <div
                class="w-10 h-10 rounded-full bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-600 flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform">
                <i class="fa-brands fa-instagram fa-lg"></i>
              </div>
              <span class="text-sm font-medium text-gray-700">Instagram</span>
            </a>
            <a href="https://tiktok.com"
              class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all group">
              <div
                class="w-10 h-10 rounded-full bg-black flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform">
                <i class="fa-brands fa-tiktok fa-lg"></i>
              </div>
              <span class="text-sm font-medium text-gray-700">TikTok</span>
            </a>
            <a href="https://facebook.com"
              class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all group">
              <div
                class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform">
                <i class="fa-brands fa-facebook-f"></i>
              </div>
              <span class="text-sm font-medium text-gray-700">Facebook</span>
            </a>
            <a href="https://wa.me/6281234567890"
              class="flex items-center gap-3 p-4 bg-white rounded-2xl shadow-sm hover:shadow-md transition-all group">
              <div
                class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white scale-90 group-hover:scale-100 transition-transform">
                <i class="fa-brands fa-whatsapp fa-lg"></i>
              </div>
              <span class="text-sm font-medium text-gray-700">WhatsApp</span>
            </a>
          </div>
        </div>
      </div>
    </section>

  </main>


  <!-- Floating WhatsApp -->
  <a href="https://wa.me/6281234567890"
    class="fixed bottom-6 right-6 z-50 bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl floating-wa transition-all hover:bg-green-600"
    aria-label="Chat via WhatsApp" title="Hubungi Kami via WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
  </a>

@endsection

@section('scripts')
  <script>
    // Accessibility: trap focus could be added later for production

    // Hero video controls: mute toggle + robust autoplay behavior + fallback play button
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
      // Try initial autoplay and show play overlay if blocked
      document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
          heroVideo.play().then(() => {
            hidePlayBtn();
          }).catch(() => {
            // autoplay blocked — show play button so user can start
            showPlayBtn();
          });
        }, 200);
      });

      // If video pauses for any reason show play button
      heroVideo.addEventListener('pause', () => { showPlayBtn(); });
      heroVideo.addEventListener('playing', () => { hidePlayBtn(); });

      // Ended -> restart (robust loop)
      heroVideo.addEventListener('ended', () => {
        heroVideo.currentTime = 0;
        heroVideo.play().catch(() => { });
      });

      // Visibility/focus attempts
      document.addEventListener('visibilitychange', () => {
        if (!document.hidden) { heroVideo.play().catch(() => { showPlayBtn(); }); }
      });
      window.addEventListener('focus', () => { heroVideo.play().catch(() => { showPlayBtn(); }); });

      // heroPlayBtn click to start video if autoplay blocked
      if (heroPlayBtn) {
        heroPlayBtn.addEventListener('click', () => {
          heroVideo.muted = true; // ensure muted to allow play on some browsers
          heroVideo.play().then(() => { hidePlayBtn(); }).catch(() => { /* still blocked */ });
        });
      }
    }

    if (heroMute && heroVideo) {
      // ensure initial label matches state
      setHeroMuteLabel();

      heroMute.addEventListener('click', () => {
        heroVideo.muted = !heroVideo.muted;
        setHeroMuteLabel();
        // attempt play when unmuted (some browsers require user gesture but try anyway)
        heroVideo.play().catch(() => { showPlayBtn(); });
      });
    }

    /* Slider: Produk Unggulan (continuous autoplay to the right, pause on hover, manual arrows) */
    (function () {
      const container = document.getElementById('featuredTrack'); // scrollable container
      const track = document.getElementById('featuredTrackInner'); // inner flex track
      const prev = document.getElementById('prevFeatured');
      const next = document.getElementById('nextFeatured');
      if (!container || !track || !prev || !next) return;

      // continuous scroll settings
      const pxPerSecond = 60; // speed in pixels per second (tweakable) — slowed down per request
      let running = true;
      let rafId = null;
      let lastTS = null;
      let pausedByInteraction = false;

      function step(ts) {
        if (!lastTS) lastTS = ts;
        const dt = ts - lastTS;
        lastTS = ts;
        if (running) {
          const delta = (pxPerSecond * dt) / 1000;
          const maxScroll = container.scrollWidth - container.clientWidth;
          container.scrollLeft += delta;
          if (container.scrollLeft >= maxScroll - 1) {
            // loop to start for continuous effect
            container.scrollLeft = 0;
          }
        }
        rafId = requestAnimationFrame(step);
      }

      function startAuto() {
        running = true; pausedByInteraction = false; lastTS = null;
        if (!rafId) rafId = requestAnimationFrame(step);
      }
      function stopAuto() { running = false; }

      // init
      startAuto();

      // pause when hovering slider/arrows/slides
      [container, prev, next].forEach(el => {
        el.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
        el.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
      });

      track.querySelectorAll('.slide').forEach(s => {
        s.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
        s.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
      });

      // arrow controls: move by one slide width
      function getSlideWidth() {
        const slide = track.querySelector('.slide');
        if (!slide) return track.clientWidth;
        const style = window.getComputedStyle(slide);
        const marginRight = parseFloat(style.marginRight) || 0;
        return slide.offsetWidth + marginRight;
      }

      prev.addEventListener('click', () => {
        stopAuto(); pausedByInteraction = true;
        const w = getSlideWidth();
        if (container.scrollLeft === 0) {
          container.scrollTo({ left: container.scrollWidth - container.clientWidth, behavior: 'smooth' });
        } else {
          container.scrollBy({ left: -w, behavior: 'smooth' });
        }
      });

      next.addEventListener('click', () => {
        stopAuto(); pausedByInteraction = true;
        const w = getSlideWidth();
        container.scrollBy({ left: w, behavior: 'smooth' });
      });

      // allow clicking on track to scroll to clicked slide
      track.addEventListener('click', (e) => {
        const slide = e.target.closest('.slide');
        if (!slide) return;
        const left = slide.offsetLeft;
        container.scrollTo({ left, behavior: 'smooth' });
        stopAuto(); pausedByInteraction = true;
      });

      // pause when page hidden
      document.addEventListener('visibilitychange', () => { if (document.hidden) stopAuto(); else if (!pausedByInteraction) startAuto(); });

      // cleanup on unload
      window.addEventListener('beforeunload', () => { if (rafId) cancelAnimationFrame(rafId); });

    })();

    /* Slider: Yang Kamu Suka */
    (function () {
      const container = document.getElementById('recommendTrack');
      const track = document.getElementById('recommendTrackInner');
      const prev = document.getElementById('prevRecommend');
      const next = document.getElementById('nextRecommend');
      if (!container || !track || !prev || !next) return;

      const pxPerSecond = 50;
      let running = true;
      let rafId = null;
      let lastTS = null;
      let pausedByInteraction = false;

      function step(ts) {
        if (!lastTS) lastTS = ts;
        const dt = ts - lastTS;
        lastTS = ts;
        if (running) {
          const delta = (pxPerSecond * dt) / 1000;
          const maxScroll = container.scrollWidth - container.clientWidth;
          container.scrollLeft += delta;
          if (container.scrollLeft >= maxScroll - 1) {
            container.scrollLeft = 0;
          }
        }
        rafId = requestAnimationFrame(step);
      }

      function startAuto() { running = true; pausedByInteraction = false; lastTS = null; if (!rafId) rafId = requestAnimationFrame(step); }
      function stopAuto() { running = false; }

      startAuto();

      [container, prev, next].forEach(el => {
        el.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
        el.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
      });

      track.querySelectorAll('.slide').forEach(s => {
        s.addEventListener('mouseenter', () => { stopAuto(); pausedByInteraction = true; });
        s.addEventListener('mouseleave', () => { if (pausedByInteraction) startAuto(); });
      });

      function getSlideWidth() {
        const slide = track.querySelector('.slide');
        if (!slide) return track.clientWidth;
        const style = window.getComputedStyle(slide);
        const marginRight = parseFloat(style.marginRight) || 0;
        return slide.offsetWidth + marginRight;
      }

      prev.addEventListener('click', () => {
        stopAuto(); pausedByInteraction = true;
        const w = getSlideWidth();
        if (container.scrollLeft === 0) {
          container.scrollTo({ left: container.scrollWidth - container.clientWidth, behavior: 'smooth' });
        } else {
          container.scrollBy({ left: -w, behavior: 'smooth' });
        }
      });

      next.addEventListener('click', () => {
        stopAuto(); pausedByInteraction = true;
        const w = getSlideWidth();
        container.scrollBy({ left: w, behavior: 'smooth' });
      });

      document.addEventListener('visibilitychange', () => { if (document.hidden) stopAuto(); else if (!pausedByInteraction) startAuto(); });
      window.addEventListener('beforeunload', () => { if (rafId) cancelAnimationFrame(rafId); });
    })();

    /* Promo Popup Logic */
    window.addEventListener('load', () => {
      const popup = document.getElementById('promoPopup');
      const content = document.getElementById('promoContent');
      const closeBtns = [
        document.getElementById('closePromo'),
        document.getElementById('closePromoBtn'),
        document.getElementById('promoBackdrop'),
        document.getElementById('promoAction')
      ];

      // Delay show slightly for better effect
      setTimeout(() => {
        popup.classList.remove('hidden');
        popup.classList.add('flex');
        // Trigger reflow for transition
        void content.offsetWidth;
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');
      }, 500);

      const hidePopup = () => {
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
          popup.classList.add('hidden');
          popup.classList.remove('flex');
        }, 500);
      };

      closeBtns.forEach(btn => {
        if (btn) btn.addEventListener('click', hidePopup);
      });
    });
  </script>
@endsection
