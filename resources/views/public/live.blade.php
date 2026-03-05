@extends('layouts.masterPublic')

@section('title', 'TikTok Live — Arimbi Queen')

@section('head')
<style>
    .tiktok-pulse {
        animation: tiktok-pulse 2s infinite;
    }
    @keyframes tiktok-pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 0, 80, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 15px rgba(255, 0, 80, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 0, 80, 0); }
    }
    .tiktok-gradient {
        background: linear-gradient(45deg, #69C9D0 0%, #EE1D52 100%);
    }
</style>
@endsection

@section('content')
<div class="min-h-[80vh] flex flex-col items-center justify-center px-6 py-20 bg-gray-50">
    <div class="max-w-4xl w-full text-center">
        <!-- Live Status Badge -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border-2 {{ ($settings['is_tiktok_live'] ?? '0') == '1' ? 'border-red-500 bg-red-50 text-red-600' : 'border-gray-300 bg-gray-100 text-gray-500' }} font-bold text-sm mb-8 uppercase tracking-widest animate-fade-in">
            <span class="relative flex h-3 w-3">
                @if(($settings['is_tiktok_live'] ?? '0') == '1')
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                @else
                <span class="relative inline-flex rounded-full h-3 w-3 bg-gray-400"></span>
                @endif
            </span>
            {{ ($settings['is_tiktok_live'] ?? '0') == '1' ? 'Sedang Live Sekarang' : 'Sedang Tidak Live' }}
        </div>

        <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 font-serif tracking-tight">
            Arimbi Queen <span class="text-accent italic">on TikTok</span>
        </h1>
        
        <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">
            Dapatkan promo eksklusif, spill detail produk secara langsung, dan tanya-tanya seputar busana Arimbi Queen hanya di Live TikTok kami.
        </p>

        <!-- Preview Mockup/Embed -->
        <div class="relative max-w-sm mx-auto mb-12 group">
            <div class="aspect-[9/16] bg-black rounded-[2.5rem] border-8 border-gray-900 shadow-2xl overflow-hidden relative">
                <!-- TikTok Placeholder Image -->
                <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Live Preview" class="w-full h-full object-cover opacity-60">
                
                @if(($settings['is_tiktok_live'] ?? '0') == '1')
                <!-- Overlay Content when Live -->
                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-white text-center">
                    <div class="w-20 h-20 rounded-full border-4 border-white overflow-hidden mb-4 shadow-xl">
                        <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-xl mb-2">{{ '@' . ($settings['tiktok_username'] ?? 'arimbiqueen') }}</h3>
                    <div class="flex items-center gap-2 px-3 py-1 bg-red-600 rounded-lg text-xs font-bold uppercase mb-8">
                        <i class="fa-solid fa-tower-broadcast"></i> LIVE
                    </div>
                    <p class="text-sm font-light mb-10">Tonton koleksi terbaru kami secara live!</p>
                </div>
                @else
                <!-- Overlay Content when Offline -->
                <div class="absolute inset-0 flex flex-col items-center justify-center p-6 text-white/50 text-center">
                    <i class="fa-solid fa-moon text-6xl mb-6"></i>
                    <p class="text-sm font-medium">Nantikan Live Berikutnya!</p>
                </div>
                @endif

                <!-- Play/Join Button Overlay -->
                @if(($settings['is_tiktok_live'] ?? '0') == '1')
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity bg-black/40">
                    <a href="{{ $settings['tiktok_live_url'] ?? '#' }}" target="_blank" class="w-20 h-20 rounded-full bg-white text-red-600 flex items-center justify-center shadow-2xl transition hover:scale-110">
                        <i class="fa-solid fa-play text-3xl ml-1"></i>
                    </a>
                </div>
                @endif
            </div>

            <!-- Floating Decoration -->
            <div class="absolute -top-6 -right-6 w-20 h-20 tiktok-gradient rounded-full opacity-20 blur-xl"></div>
            <div class="absolute -bottom-6 -left-6 w-24 h-24 bg-blue-400 rounded-full opacity-10 blur-xl"></div>
        </div>

        @if(($settings['is_tiktok_live'] ?? '0') == '1')
        <a href="{{ $settings['tiktok_live_url'] ?? '#' }}" target="_blank" 
           class="inline-flex items-center gap-3 px-10 py-5 tiktok-gradient text-white rounded-2xl font-bold text-lg shadow-2xl shadow-red-500/20 hover:brightness-110 transition-all active:scale-95 tiktok-pulse">
            <i class="fa-brands fa-tiktok fa-lg"></i> Gabung Live Sekarang
        </a>
        @else
        <div class="flex flex-col items-center gap-4">
            <a href="https://www.tiktok.com/{{ '@' . ($settings['tiktok_username'] ?? 'arimbiqueen') }}" target="_blank" 
               class="inline-flex items-center gap-3 px-10 py-5 bg-gray-900 text-white rounded-2xl font-bold text-lg hover:bg-black transition-all">
                <i class="fa-brands fa-tiktok fa-lg"></i> Follow untuk Notifikasi
            </a>
            <p class="text-sm text-gray-400">Ikuti kami untuk mendapatkan pemberitahuan saat kami Live!</p>
        </div>
        @endif
    </div>
</div>
@endsection
