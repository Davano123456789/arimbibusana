@extends('layouts.masterAuth')

@section('title', 'Verifikasi Email — Arimbi Queen')

@section('head')
<style>
    :root {
        --cream: #F5ECE0;
        --dark-cream: #E8D9C5;
        --cream-dark: #B78A58;
        --accent: #5B3A29;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(183, 138, 88, 0.1);
    }

    .bg-auth {
        background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1600&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
    }
</style>
@endsection

@section('content')
<section class="min-h-screen flex items-center justify-center py-12 bg-auth relative">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-accent/20 backdrop-blur-[2px]"></div>

    <div class="max-w-md w-full px-6 relative z-10" data-aos="fade-up">
        <div class="auth-card rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Logo" class="w-20 h-20 rounded-full mx-auto mb-4 shadow-lg object-cover">
                    <h2 class="text-2xl font-bold text-gray-900 font-serif">Verifikasi Email Kamu</h2>
                    <p class="text-gray-500 text-sm mt-2">
                        Kami sudah mengirim link verifikasi ke email kamu.<br>
                        Silakan cek <strong>inbox</strong> atau folder <strong>spam</strong>.
                    </p>
                </div>

                {{-- Session messages --}}
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-2xl flex items-start gap-3">
                        <i class="fa-solid fa-circle-check text-green-500 mt-0.5"></i>
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-2xl flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                        <p class="text-sm text-amber-700">{{ session('warning') }}</p>
                    </div>
                @endif

                {{-- Icon Envelope --}}
                <div class="flex justify-center mb-8">
                    <div class="w-24 h-24 rounded-full bg-amber-50 flex items-center justify-center">
                        <i class="fa-solid fa-envelope-open text-5xl text-amber-400"></i>
                    </div>
                </div>

                @if (auth()->check())
                    <p class="text-center text-sm text-gray-500 mb-6">
                        Email dikirim ke: <span class="font-bold text-gray-800">{{ auth()->user()->email }}</span>
                    </p>

                    {{-- Resend Button --}}
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-accent text-white font-bold py-4 rounded-2xl shadow-xl shadow-accent/20 hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            <i class="fa-solid fa-paper-plane text-sm"></i> Kirim Ulang Email Verifikasi
                        </button>
                    </form>
                @endif

                <div class="mt-8 text-center space-y-3">
                    <p class="text-xs text-gray-400">Sudah verifikasi?</p>
                    <a href="{{ url('/login') }}"
                        class="text-sm font-bold text-accent hover:underline flex items-center justify-center gap-2">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk ke Akun
                    </a>
                </div>
            </div>

            <div class="bg-cream/50 p-4 text-center border-t border-gray-100">
                <a href="{{ url('/') }}" class="text-xs font-bold text-accent/60 hover:text-accent flex items-center justify-center gap-2 transition-colors">
                    <i class="fa-solid fa-house"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
