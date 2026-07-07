@extends('layouts.masterAuth')

@section('title', 'Masuk — Arimbi Queen')

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
                <div class="text-center mb-10">
                    <img src="{{ asset('images/logo-arimbi.png') }}" alt="Logo" class="w-20 h-20 rounded-full mx-auto mb-4 shadow-lg object-cover">
                    <h2 class="text-3xl font-bold text-gray-900 font-serif">Selamat Datang</h2>
                    <p class="text-gray-500 text-sm mt-2">Silakan masuk ke akun Arimbi Queen Anda</p>
                </div>

                <form action="{{ url('/login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
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
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold uppercase tracking-widest text-gray-400">Kata Sandi</label>
                            <a href="#" class="text-[10px] font-bold text-accent hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" id="password" name="password" required 
                                class="w-full pl-11 pr-12 py-3.5 bg-gray-50 border @error('password') border-red-500 @else border-gray-100 @enderror rounded-2xl text-sm transition-all input-focus outline-none" 
                                placeholder="••••••••">
                            <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors z-10">
                                <i class="fa-solid fa-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-[10px] text-red-500 mt-1 font-bold italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="remember" class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>

                    <button type="submit" 
                        class="w-full bg-accent text-white font-bold py-4 rounded-2xl shadow-xl shadow-accent/20 hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        Masuk Ke Akun <i class="fa-solid fa-arrow-right-to-bracket text-sm"></i>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs uppercase">
                        <span class="bg-white px-4 text-gray-500 font-bold tracking-wider">atau</span>
                    </div>
                </div>

                <!-- Google Sign-In Button -->
                <a href="{{ route('google.login') }}" 
                    class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3.5 px-4 border border-gray-300 rounded-2xl shadow-sm hover:shadow transition-all flex items-center justify-center gap-3 text-sm active:scale-[0.98]">
                    <svg class="w-5 h-5" viewBox="0 0 24 24">
                        <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.68 1.54 14.98 1 12 1 7.35 1 3.37 3.67 1.39 7.56l3.85 2.99c.9-2.69 3.42-4.51 6.76-4.51z"/>
                        <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.35H12v4.51h6.48c-.29 1.48-1.14 2.73-2.4 3.58l3.72 2.88c2.18-2.01 3.69-4.97 3.69-8.62z"/>
                        <path fill="#FBBC05" d="M5.24 14.75c-.24-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29L1.39 7.18C.5 8.98 0 10.99 0 13s.5 4.02 1.39 5.82l3.85-3.07z"/>
                        <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.72-2.88c-1.04.7-2.38 1.12-4.24 1.12-3.34 0-5.86-1.82-6.76-4.51L1.39 16.9C3.37 20.33 7.35 23 12 23z"/>
                    </svg>
                    <span>Masuk dengan Google</span>
                </a>

                <div class="mt-10 text-center">
                    <p class="text-sm text-gray-500">
                        Belum punya akun? 
                        <a href="{{ url('/register') }}" class="font-bold text-accent hover:underline">Daftar Sekarang</a>
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

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (togglePassword && passwordInput && eyeIcon) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // toggle the eye icon class
                if (type === 'password') {
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            });
        }
    });
</script>
@endsection
