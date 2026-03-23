<header class="bg-white/60 backdrop-blur-md sticky top-0 z-40 border-b">
    <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Arimbi Queen Logo" class="w-12 h-12 rounded-full object-cover shadow-sm">
            <div>
                <h1 class="text-lg font-semibold">Arimbi Queen</h1>
                <p class="text-sm text-gray-500">Anggun • Sopan • Percaya Diri</p>
            </div>
        </a>
        <nav class="hidden lg:flex items-center gap-6 text-sm">
            <a href="{{ url('/') }}" class="hover:text-accent transition">Beranda</a>
            <a href="{{ url('/produk') }}" class="hover:text-accent transition font-medium">Produk</a>
            <a href="{{ url('/produk-unggulan') }}" class="hover:text-accent transition">Unggulan</a>
            <a href="{{ route('public.live') }}" class="group flex items-center gap-1.5 hover:text-accent transition">
                Live 
                @if(isset($settings['is_tiktok_live']) && $settings['is_tiktok_live'] == '1')
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                @endif
            </a>
            <a href="{{ url('/testimoni') }}" class="hover:text-accent transition font-medium">Testimoni</a>
            <a href="{{ url('/tentang') }}" class="hover:text-accent transition">Tentang Kami</a>
            <a href="{{ url('/blog') }}" class="hover:text-accent transition">Blog</a>
        </nav>
        <div class="hidden md:flex items-center gap-5 ml-4">
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ url('/dashboard') }}" class="text-gray-500 hover:text-accent transition-colors" title="Dashboard Admin">
                        <i class="fa-solid fa-gauge-high text-xl"></i>
                    </a>
                @endif
                <form action="{{ route('logout') }}" method="POST" class="m-0 ml-4">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-5 py-2 border border-accent text-accent rounded-full text-sm font-medium hover:bg-accent hover:text-white transition-all duration-300 shadow-sm">
                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ url('/login') }}" class="flex items-center gap-2 px-5 py-2 bg-accent text-white rounded-full text-sm font-medium hover:brightness-110 transition-all duration-300 shadow-sm shadow-accent/20">
                    <i class="fa-solid fa-user text-xs"></i>
                    Login
                </a>
            @endauth
            @auth
            <a href="{{ url('/pesanan') }}" class="text-gray-500 hover:text-accent transition-colors" title="Pesanan Saya">
                <i class="fa-solid fa-clipboard-list text-xl"></i>
            </a>
            @endauth
            <a href="{{ url('/keranjang') }}" class="relative group text-gray-500 hover:text-accent transition-colors">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                @if($cartCount > 0)
                <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center border border-white shadow-sm">{{ $cartCount }}</span>
                @endif
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
                <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Arimbi Queen Logo" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-medium">Arimbi Queen</h3>
                    <p class="text-xs text-gray-500">Anggun • Sopan</p>
                </div>
            </div>
            <button id="mobileClose" class="p-2"><i class="fa-solid fa-xmark"></i></button>
        </div>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ url('/dashboard') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-gray-900 text-white rounded-xl text-sm font-medium hover:brightness-110 transition-all mb-3 shadow-md">
                    <i class="fa-solid fa-gauge-high text-xs"></i>
                    Dashboard Admin
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST" class="mb-6">
                @csrf
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-3 border border-red-500 text-red-500 rounded-xl text-sm font-medium hover:bg-red-500 hover:text-white transition-all">
                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                    Logout
                </button>
            </form>
        @else
            <a href="{{ url('/login') }}" class="flex items-center justify-center gap-2 w-full py-3 bg-accent text-white rounded-xl text-sm font-medium hover:brightness-110 transition-all mb-6 shadow-md shadow-accent/20">
                <i class="fa-solid fa-user text-xs"></i>
                Login
            </a>
        @endauth
        <nav class="flex flex-col gap-4">
            <a href="{{ url('/') }}" class="py-2 border-b mobile-nav-link">Beranda</a>
            <a href="{{ url('/produk') }}" class="py-2 border-b mobile-nav-link">Produk</a>
            <a href="{{ url('/produk-unggulan') }}" class="py-2 border-b mobile-nav-link">Produk Unggulan</a>
            <a href="{{ route('public.live') }}" class="py-2 border-b mobile-nav-link flex items-center justify-between">
                Live
                @if(isset($settings['is_tiktok_live']) && $settings['is_tiktok_live'] == '1')
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                @endif
            </a>
            <a href="{{ url('/testimoni') }}" class="py-2 border-b mobile-nav-link">Testimoni</a>
            <a href="{{ url('/tentang') }}" class="py-2 border-b mobile-nav-link">Tentang Kami</a>
            <a href="{{ route('public.blog') }}" class="py-2 border-b mobile-nav-link">Blog</a>
            <a href="#informasi" class="py-2 border-b mobile-nav-link">Informasi Kami</a>
            @auth
            <a href="{{ url('/pesanan') }}" class="py-2 border-b mobile-nav-link flex items-center justify-between">
                Pesanan Saya
                <i class="fa-solid fa-clipboard-list text-gray-400"></i>
            </a>
            @endauth
            <a href="{{ url('/keranjang') }}" class="py-2 border-b mobile-nav-link flex items-center justify-between">
                Keranjang Belanja
                @if($cartCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $cartCount }} Item</span>
                @endif
            </a>
        </nav>
    </div>
</div>
