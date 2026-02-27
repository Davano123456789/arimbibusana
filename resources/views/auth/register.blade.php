<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Arimbi Queen</title>
    <meta name="description" content="Daftar ke Arimbi Queen untuk mulai belanja busana muslimah premium.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        playfair: ['"Playfair Display"', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        accent: '#6B3A2A',
                        'accent-light': '#8B4E3A',
                        cream: '#F9F3EE',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .slide-up { animation: slideUp 0.7s cubic-bezier(.16,1,.3,1) forwards; }
        @keyframes slideUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: translateY(0); } }
        .input-field {
            width: 100%;
            background: #fafafa;
            border: 1.5px solid #ebebeb;
            border-radius: 14px;
            padding: 0.85rem 1rem 0.85rem 2.85rem;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            color: #1a1a1a;
        }
        .input-field:focus {
            background: #fff;
            border-color: #6B3A2A;
            box-shadow: 0 0 0 4px rgba(107, 58, 42, 0.08);
        }
        .input-field::placeholder { color: #c5c5c5; }
    </style>
</head>
<body class="min-h-screen bg-cream flex items-center justify-center p-4">

    <!-- Card -->
    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/60 p-10 slide-up">

        <!-- Logo & Brand -->
        <div class="text-center mb-9">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-3 group">
                <img src="{{ asset('images/logo-arimbi.jpg') }}" alt="Arimbi Queen"
                    class="w-14 h-14 rounded-full object-cover shadow-md group-hover:shadow-lg transition-shadow">
                <div>
                    <span class="block text-sm font-semibold tracking-widest uppercase text-accent/80">Arimbi Queen</span>
                </div>
            </a>
            <h1 class="mt-5 text-2xl font-playfair font-bold text-gray-900 leading-snug">
                Buat Akun<br>
                <span class="text-accent">Baru</span>
            </h1>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="mb-5 p-3.5 bg-red-50 border border-red-100 rounded-xl">
            <ul class="text-xs text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="flex items-center gap-1.5"><i class="fa-solid fa-circle-exclamation text-red-400"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Form -->
        <form action="{{ url('/register') }}" method="POST" class="space-y-4" novalidate>
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-1.5 ml-0.5">Nama Lengkap</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name"
                        class="input-field" placeholder="Nama Lengkap Anda">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-1.5 ml-0.5">Email</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="input-field" placeholder="nama@email.com">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-1.5 ml-0.5">Password</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                        class="input-field" placeholder="Minimal 8 karakter">
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-[11px] font-semibold tracking-widest uppercase text-gray-400 mb-1.5 ml-0.5">Konfirmasi Password</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-300 text-sm pointer-events-none">
                        <i class="fa-solid fa-lock-open"></i>
                    </span>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                        class="input-field" placeholder="Ulangi password">
                </div>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full mt-4 bg-accent text-white text-sm font-semibold py-3.5 rounded-xl shadow-lg shadow-accent/20 hover:bg-accent-light active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                Daftar Sekarang
                <i class="fa-solid fa-arrow-right-long text-xs"></i>
            </button>
        </form>

        <!-- Divider -->
        <div class="my-7 flex items-center gap-3">
            <div class="flex-1 h-px bg-gray-100"></div>
            <span class="text-[11px] text-gray-300 font-medium tracking-widest uppercase">atau</span>
            <div class="flex-1 h-px bg-gray-100"></div>
        </div>

        <!-- Login Link -->
        <p class="text-center text-xs text-gray-400">
            Sudah punya akun?
            <a href="{{ url('/login') }}" class="text-accent font-semibold hover:underline ml-1">Login di sini</a>
        </p>

        <!-- Back to Home -->
        <div class="mt-6 text-center">
            <a href="{{ url('/') }}" class="text-[11px] text-gray-300 hover:text-gray-500 transition-colors flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-chevron-left text-[9px]"></i>
                Kembali ke Beranda
            </a>
        </div>
    </div>

    <!-- Subtle background pattern -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 -right-32 w-72 h-72 bg-accent/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 -left-32 w-72 h-72 bg-accent/5 rounded-full blur-3xl"></div>
    </div>
</body>
</html>
