@extends('layouts.masterPublic')

@section('title', $post->title . ' — Arimbi Queen')
@section('description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('head')
<style>
    :root {
        --cream: #F5ECE0;
        --dark-cream: #E8D9C5;
        --cream-dark: #B78A58;
        --accent: #5B3A29;
    }

    .article-content {
        line-height: 1.8;
        color: #374151;
    }

    .article-content h2 {
        font-family: 'Playfair Display', serif;
        font-size: 1.875rem;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1.25rem;
        color: #111827;
    }

    .article-content p {
        margin-bottom: 1.5rem;
    }

    .article-content img {
        border-radius: 1.5rem;
        margin: 2rem 0;
    }

    .sidebar-card {
        transition: all 0.3s ease;
    }

    .sidebar-card:hover {
        background-color: var(--cream);
    }
</style>
@endsection

@section('content')
<article class="pt-32 pb-24 bg-white">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid lg:grid-cols-12 gap-16">
            <!-- Main Content -->
            <div class="lg:col-span-8">
                <!-- Meta -->
                <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-accent/50 mb-8" data-aos="fade-up">
                    <a href="{{ url('/') }}" class="hover:text-accent">Beranda</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <a href="{{ route('public.blog') }}" class="hover:text-accent">Blog</a>
                    <i class="fa-solid fa-chevron-right text-[8px]"></i>
                    <span class="text-accent truncate max-w-[200px]">{{ $post->title }}</span>
                </nav>

                <header class="mb-12" data-aos="fade-up">
                    <h1 class="text-3xl md:text-5xl font-bold text-gray-900 font-serif leading-tight mb-6">
                        {{ $post->title }}
                    </h1>
                    
                    <div class="flex items-center gap-6 py-6 border-y border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-accent text-white flex items-center justify-center font-bold">
                                {{ substr($post->author, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Penulis</p>
                                <p class="text-sm font-bold text-gray-900">{{ $post->author }}</p>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-gray-100"></div>
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-tighter">Tanggal</p>
                            <p class="text-sm font-bold text-gray-900">
                                {{ $post->published_at ? $post->published_at->format('d F Y') : $post->created_at->format('d F Y') }}
                            </p>
                        </div>
                    </div>
                </header>

                <div class="mb-12 rounded-3xl overflow-hidden shadow-2xl" data-aos="zoom-in">
                    <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200&auto=format&fit=crop' }}" 
                         alt="{{ $post->title }}" 
                         class="w-full object-cover">
                </div>

                <div class="article-content" data-aos="fade-up">
                    {!! nl2br($post->content) !!}
                </div>

                <!-- Share -->
                <div class="mt-16 pt-8 border-t border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-bold text-gray-900">Bagikan artikel:</span>
                        <div class="flex items-center gap-2">
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-accent hover:text-white transition-all">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-accent hover:text-white transition-all">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-accent hover:text-white transition-all">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                        </div>
                    </div>
                    <a href="{{ route('public.blog') }}" class="text-sm font-bold text-accent flex items-center gap-2 hover:underline">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Blog
                    </a>
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                <div class="sticky top-32 space-y-12">
                    <!-- Recent Posts -->
                    <div data-aos="fade-left">
                        <h3 class="text-xl font-bold font-serif mb-6 pb-4 border-b-2 border-accent">Artikel Terbaru</h3>
                        <div class="space-y-6">
                            @foreach($recentPosts as $recent)
                            <a href="{{ route('public.blog.detail', $recent->slug) }}" class="group flex gap-4">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden flex-shrink-0">
                                    <img src="{{ $recent->thumbnail ? asset('storage/' . $recent->thumbnail) : 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=200&auto=format&fit=crop' }}" 
                                         alt="{{ $recent->title }}" 
                                         class="w-full h-full object-cover transition-transform group-hover:scale-110">
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h4 class="text-sm font-bold text-gray-900 line-clamp-2 group-hover:text-accent transition-colors leading-snug">
                                        {{ $recent->title }}
                                    </h4>
                                    <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase">
                                        {{ $recent->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter/CTA -->
                    <div class="bg-cream p-8 rounded-3xl" data-aos="fade-left" data-aos-delay="200">
                        <h3 class="text-xl font-bold font-serif mb-4">Ingin Promo Menarik?</h3>
                        <p class="text-sm text-gray-600 mb-6 leading-relaxed">Dapatkan update koleksi terbaru dan promo eksklusif langsung di WhatsApp Anda.</p>
                        <a href="https://wa.me/6281234567890" class="flex items-center justify-center gap-2 w-full bg-green-500 text-white font-bold py-3 rounded-2xl shadow-lg hover:bg-green-600 transition-all">
                            <i class="fa-brands fa-whatsapp"></i> Chat Admin
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>
@endsection
