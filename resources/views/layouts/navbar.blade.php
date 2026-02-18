<header class="bg-white/60 backdrop-blur-md sticky top-0 z-40 border-b">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="images/logo-arimbi.jpg" alt="Arimbi Queen Logo" class="w-12 h-12 rounded-full object-cover shadow-sm">
            <div>
                <h1 class="text-lg font-semibold">Arimbi Queen</h1>
                <p class="text-sm text-gray-500">Anggun • Sopan • Percaya Diri</p>
            </div>
        </a>
        <nav class="hidden lg:flex items-center gap-6 text-sm">
            <a href="{{ url('/') }}" class="hover:text-accent transition">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-accent transition font-medium">Produk</a>
            <a href="{{ url('/produk-unggulan') }}" class="hover:text-accent transition">Unggulan</a>
            <a href="#" class="group flex items-center gap-1.5 hover:text-accent transition">
                Live <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
            </a>
            <a href="#testimoni" class="hover:text-accent transition font-medium">Testimoni</a>
            <a href="#tentang" class="hover:text-accent transition">Tentang Kami</a>
            <a href="#blog" class="hover:text-accent transition">Blog</a>
        </nav>
        <div class="hidden md:flex items-center gap-5 ml-4">
            <div class="relative w-[180px]">
                <input type="text" placeholder="Cari..."
                    class="w-full bg-gray-100 border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-1 focus:ring-accent/30 outline-none transition-all" />
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
            <a href="{{ url('/keranjang') }}" class="relative group text-gray-500 hover:text-accent transition-colors">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white shadow-sm">2</span>
            </a>
        </div>
        <div class="md:hidden">
            <button id="btn-mobile" class="p-2 rounded border"><i class="fa-solid fa-bars"></i></button>
        </div>
    </div>
</header>
<div id="mobileMenu" class="fixed inset-0 z-50 invisible transition-all duration-300">
    <div class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-300 ease-in-out" id="mobileMenuBackdrop"></div>
    <div class="absolute right-0 top-0 h-full w-72 bg-white shadow-lg p-6 transform translate-x-full transition-transform duration-300 ease-in-out" id="mobileMenuContent">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <img src="images/logo-arimbi.jpg" alt="Arimbi Queen Logo" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-medium">Arimbi Queen</h3>
                    <p class="text-xs text-gray-500">Anggun • Sopan</p>
                </div>
            </div>
            <button id="mobileClose" class="p-2"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="relative mb-6">
            <input type="text" placeholder="Cari busana..."
                class="w-full bg-gray-100 border-none rounded-xl py-3 pl-11 pr-4 text-sm outline-none" />
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>
        <nav class="flex flex-col gap-4">
            <a href="{{ url('/') }}" class="py-2 border-b mobile-nav-link">Beranda</a>
            <a href="{{ url('/produk') }}" class="py-2 border-b mobile-nav-link">Produk</a>
            <a href="{{ url('/produk-unggulan') }}" class="py-2 border-b mobile-nav-link">Produk Unggulan</a>
            <a href="#" class="py-2 border-b mobile-nav-link flex items-center justify-between">
                Live
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
            </a>
            <a href="#testimoni" class="py-2 border-b mobile-nav-link">Testimoni</a>
            <a href="#tentang" class="py-2 border-b mobile-nav-link">Tentang Kami</a>
            <a href="#informasi" class="py-2 border-b mobile-nav-link">Informasi Kami</a>
            <a href="{{ url('/keranjang') }}" class="py-2 border-b mobile-nav-link flex items-center justify-between">
                Keranjang Belanja
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">2 Item</span>
            </a>
        </nav>
    </div>
</div>
