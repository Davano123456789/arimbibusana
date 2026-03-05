@extends('layouts.masterAuth')

@section('title', 'Daftar — Arimbi Queen')

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

    .input-focus:focus {
        border-color: var(--cream-dark);
        box-shadow: 0 0 0 4px rgba(183, 138, 88, 0.1);
    }
    
    .bg-auth {
        background-image: url('https://images.unsplash.com/photo-1520975911600-5d36cb2d6f6f?q=80&w=1600&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
    }
</style>
@endsection

@section('content')
<section class="min-h-screen flex items-center justify-center py-20 bg-auth relative">
    <!-- Overlay -->
    <div class="absolute inset-0 bg-accent/20 backdrop-blur-[2px]"></div>

    <div class="max-w-xl w-full px-6 relative z-10" data-aos="fade-up">
        <div class="auth-card rounded-3xl shadow-2xl overflow-hidden">
            <div class="p-8 md:p-10">
                <div class="text-center mb-10">
                    <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Logo" class="w-16 h-16 rounded-full mx-auto mb-4 shadow-lg object-cover">
                    <h2 class="text-3xl font-bold text-gray-900 font-serif">Bergabung Sekarang</h2>
                    <p class="text-gray-500 text-sm mt-2">Dapatkan akses eksklusif ke koleksi premium kami</p>
                </div>

                <form action="{{ url('/register') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border @error('name') border-red-500 @else border-gray-100 @enderror rounded-2xl text-sm transition-all input-focus outline-none" 
                                placeholder="Masukkan nama lengkap">
                            @error('name')
                                <p class="text-[10px] text-red-500 mt-1 font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Alamat Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border @error('email') border-red-500 @else border-gray-100 @enderror rounded-2xl text-sm transition-all input-focus outline-none" 
                                placeholder="nama@email.com">
                            @error('email')
                                <p class="text-[10px] text-red-500 mt-1 font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border @error('password') border-red-500 @else border-gray-100 @enderror rounded-2xl text-sm transition-all input-focus outline-none" 
                                placeholder="••••••••">
                            @error('password')
                                <p class="text-[10px] text-red-500 mt-1 font-bold italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Konfirmasi Sandi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-shield-check"></i>
                            </span>
                            <input type="password" name="password_confirmation" required 
                                class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-100 rounded-2xl text-sm transition-all input-focus outline-none" 
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input type="checkbox" required class="mt-1 w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent">
                            <span class="text-xs text-gray-500 leading-relaxed group-hover:text-gray-700 transition-colors">
                                Saya setuju dengan <a href="#" class="text-accent font-bold hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="text-accent font-bold hover:underline">Kebijakan Privasi</a> yang berlaku.
                            </span>
                        </label>
                    </div>

                    <div class="md:col-span-2 pt-2">
                        <button type="submit" 
                            class="w-full bg-accent text-white font-bold py-4 rounded-2xl shadow-xl shadow-accent/20 hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                            Buat Akun Baru <i class="fa-solid fa-user-plus text-sm"></i>
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-sm text-gray-500">
                        Sudah memiliki akun? 
                        <a href="{{ url('/login') }}" class="font-bold text-accent hover:underline">Masuk Sekarang</a>
                    </p>
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
