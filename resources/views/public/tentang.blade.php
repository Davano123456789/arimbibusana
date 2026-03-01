@extends('layouts.masterPublic')

@section('title', 'Tentang Kami — Arimbi Queen')
@section('description', 'Kenali lebih dekat Arimbi Queen - Dedikasi kami untuk menyediakan pakaian muslimah yang anggun, sopan, dan meningkatkan kepercayaan diri.')

@section('head')
<style>
    :root {
        --cream: #F5ECE0;
        --dark-cream: #E8D9C5;
        --cream-dark: #B78A58;
        --accent: #5B3A29;
    }

    .hero-about {
        background-image: linear-gradient(rgba(91, 58, 41, 0.4), rgba(91, 58, 41, 0.4)), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1600&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
    }

    .value-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(91, 58, 41, 0.05);
    }

    .value-card:hover {
        transform: translateY(-10px);
        background-color: var(--accent);
        color: white;
        border-color: var(--accent);
    }

    .value-card:hover .icon-box {
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .value-card:hover p {
        color: rgba(255, 255, 255, 0.8);
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-about min-h-[60vh] flex items-center justify-center pt-20">
    <div class="max-w-4xl mx-auto px-6 text-center text-white" data-aos="zoom-in">
        <h1 class="text-4xl md:text-6xl font-serif font-bold mb-6">Cerita Arimbi Queen</h1>
        <p class="text-lg md:text-xl font-light opacity-90 max-w-2xl mx-auto leading-relaxed">
            Menghadirkan keindahan melalui setiap helai kain, menjunjung tinggi nilai kesopanan dalam kemasan yang modern dan anggun.
        </p>
    </div>
</section>

<!-- Our Story -->
<section class="py-24 bg-white relative overflow-hidden">
    <!-- Decorative element -->
    <div class="absolute -left-20 top-40 w-64 h-64 bg-cream rounded-full blur-3xl opacity-50"></div>
    
    <div class="max-w-6xl mx-auto px-6 relative z-10">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="order-2 md:order-1" data-aos="fade-right">
                <div class="relative">
                    <img src="{{ asset('images/produk1.jpg') }}" 
                         alt="Our Story" 
                         class="rounded-[3rem] shadow-2xl w-full h-[500px] object-cover">
                    <!-- Experience badge -->
                    <div class="absolute -bottom-6 -right-6 bg-accent text-white p-8 rounded-3xl shadow-xl">
                        <p class="text-4xl font-bold font-serif leading-none">5+</p>
                        <p class="text-xs font-bold uppercase tracking-widest mt-2">Tahun Berkarya</p>
                    </div>
                </div>
            </div>
            
            <div class="order-1 md:order-2" data-aos="fade-left">
                <span class="text-accent font-bold uppercase tracking-[0.3em] text-xs mb-4 block">Sejak 2018</span>
                <h2 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 mb-8 leading-tight">Dedikasi Untuk Wanita Muslimah</h2>
                <div class="space-y-6 text-gray-600 leading-relaxed text-lg font-light">
                    <p>
                        Arimbi Queen bermula dari sebuah visi sederhana: menciptakan pakaian yang tidak hanya menutupi, tetapi juga memberikan identitas bagi wanita muslimah yang ingin tampil menawan tanpa meninggalkan syariat.
                    </p>
                    <p>
                        Setiap koleksi kami dirancang dengan ketelitian tinggi, pemilihan bahan premium yang nyaman, dan potongan yang modern. Kami percaya bahwa setiap wanita berhak merasa cantik dan percaya diri dalam setiap aktivitasnya.
                    </p>
                    <p>
                        Hingga hari ini, Arimbi Queen telah menjadi bagian dari perjalanan ribuan wanita dalam menemukan gaya terbaik mereka yang Anggun, Sopan, dan Percaya Diri.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-24 bg-cream/30">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 mb-4">Nilai Utama Kami</h2>
            <div class="w-24 h-1 bg-accent mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Anggun -->
            <div class="value-card bg-white p-10 rounded-[2.5rem] text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-box w-20 h-20 bg-cream rounded-2xl flex items-center justify-center text-accent text-3xl mx-auto mb-8 transition-colors">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4">Anggun</h3>
                <p class="text-gray-500 leading-relaxed">
                    Setiap desain menonjolkan keanggunan alami wanita, memberikan kesan premium dan bermartabat.
                </p>
            </div>

            <!-- Sopan -->
            <div class="value-card bg-white p-10 rounded-[2.5rem] text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-box w-20 h-20 bg-cream rounded-2xl flex items-center justify-center text-accent text-3xl mx-auto mb-8 transition-colors">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4">Sopan</h3>
                <p class="text-gray-500 leading-relaxed">
                    Menjunjung tinggi nilai kesantunan dengan potongan yang menutup aurat dengan sempurna namun tetap modis.
                </p>
            </div>

            <!-- Percaya Diri -->
            <div class="value-card bg-white p-10 rounded-[2.5rem] text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="icon-box w-20 h-20 bg-cream rounded-2xl flex items-center justify-center text-accent text-3xl mx-auto mb-8 transition-colors">
                    <i class="fa-solid fa-star"></i>
                </div>
                <h3 class="text-2xl font-serif font-bold mb-4">Percaya Diri</h3>
                <p class="text-gray-500 leading-relaxed">
                    Pakaian yang nyaman membuat pemakainya merasa bangga dan percaya diri menghadapi hari.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi -->
<section class="py-24 bg-white relative">
    <div class="max-w-6xl mx-auto px-6">
        <div class="bg-accent rounded-[3.5rem] overflow-hidden text-white flex flex-col md:flex-row shadow-2xl" data-aos="zoom-in">
            <div class="md:w-1/2 p-12 md:p-20 flex flex-col justify-center border-b md:border-b-0 md:border-r border-white/10">
                <h3 class="text-4xl font-serif font-bold mb-8 italic text-cream">Visi Kami</h3>
                <p class="text-xl font-light leading-relaxed opacity-90">
                    "Menjadi merek fashion muslimah terkemuka yang menginspirasi wanita untuk tampil dengan identitas terbaiknya: Anggun perawakannya, Sopan pekertinya, dan Percaya Diri langkahnya."
                </p>
            </div>
            <div class="md:w-1/2 p-12 md:p-20">
                <h3 class="text-4xl font-serif font-bold mb-8 italic text-cream">Misi Kami</h3>
                <ul class="space-y-6">
                    <li class="flex gap-4">
                        <i class="fa-solid fa-check text-cream mt-1"></i>
                        <p class="font-light leading-relaxed opacity-90">Menyediakan koleksi busana muslimah berkualitas tinggi dengan bahan pilihan.</p>
                    </li>
                    <li class="flex gap-4">
                        <i class="fa-solid fa-check text-cream mt-1"></i>
                        <p class="font-light leading-relaxed opacity-90">Mengembangkan desain yang selalu mengikuti tren fashion tanpa meninggalkan syariat.</p>
                    </li>
                    <li class="flex gap-4">
                        <i class="fa-solid fa-check text-cream mt-1"></i>
                        <p class="font-light leading-relaxed opacity-90">Membangun komunitas muslimah yang saling mendukung dalam kebaikan.</p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-24 bg-white text-center">
    <div class="max-w-4xl mx-auto px-6" data-aos="fade-up">
        <h2 class="text-3xl md:text-5xl font-serif font-bold text-gray-900 mb-8">Jadilah Bagian Dari Keluarga Arimbi</h2>
        <p class="text-lg text-gray-500 mb-12 max-w-2xl mx-auto font-light leading-relaxed">
            Dapatkan update koleksi terbaru kami dan jadilah yang pertama merasakan kualitas produk premium Arimbi Queen.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
            <a href="{{ url('/produk') }}" class="px-10 py-4 bg-accent text-white font-bold rounded-full shadow-xl shadow-accent/20 hover:brightness-110 hover:-translate-y-1 transition-all">
                Lihat Koleksi
            </a>
            <a href="https://wa.me/6281234567890" class="px-10 py-4 border-2 border-accent text-accent font-bold rounded-full hover:bg-accent hover:text-white transition-all">
                Hubungi Kami
            </a>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Smooth scroll for anchors if needed
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endsection
