@extends('layouts.masterPublic')

@section('title', 'Arimbi Queen — Blog')
@section('description', 'Baca artikel terbaru seputar tips fashion, busana muslim, dan gaya hidup dari Arimbi Queen.')

@section('head')
<style>
    :root {
        --cream: #F5ECE0;
        --dark-cream: #E8D9C5;
        --cream-dark: #B78A58;
        --accent: #5B3A29;
    }

    .blog-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .blog-card .img-hover {
        overflow: hidden;
    }

    .blog-card .img-hover img {
        transition: transform 0.6s ease;
    }

    .blog-card:hover .img-hover img {
        transform: scale(1.1);
    }

    .pagination-link {
        transition: all 0.3s ease;
    }

    .pagination-link:hover {
        background-color: var(--accent);
        color: white;
    }
    
    .active-pagination {
        background-color: var(--accent);
        color: white;
    }
</style>
@endsection

@section('content')
<section class="relative pt-32 pb-20 bg-cream/30">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-accent/60 uppercase tracking-widest text-xs font-semibold mb-2 block">Journal & Inspirasi</span>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 font-serif mb-4">Blog Arimbi Queen</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Temukan inspirasi gaya, tips perawatan busana, dan cerita di balik koleksi kami.</p>
        </div>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($posts as $post)
                <article class="blog-card bg-white rounded-3xl overflow-hidden shadow-sm flex flex-col h-full" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                    <a href="{{ route('public.blog.detail', $post->slug) }}" class="img-hover relative h-64 block">
                        <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=800&auto=format&fit=crop' }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-accent text-[10px] uppercase tracking-tighter font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </a>
                    <div class="p-8 flex flex-col flex-grow">
                        <h2 class="text-xl font-bold text-gray-900 mb-4 line-clamp-2 hover:text-accent transition-colors font-serif">
                            <a href="{{ route('public.blog.detail', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                        </p>
                        <div class="mt-auto flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-accent/10 flex items-center justify-center text-accent font-bold text-xs">
                                    {{ substr($post->author, 0, 1) }}
                                </div>
                                <span class="text-xs font-medium text-gray-500">{{ $post->author }}</span>
                            </div>
                            <a href="{{ route('public.blog.detail', $post->slug) }}" class="text-accent text-sm font-bold flex items-center gap-2 group">
                                Baca <i class="fa-solid fa-arrow-right text-[10px] transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-dashed border-gray-200">
                <div class="w-20 h-20 bg-cream rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-newspaper text-accent text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Artikel</h3>
                <p class="text-gray-500">Kami sedang menyiapkan konten menarik untuk Anda. Nantikan segera!</p>
                <a href="{{ url('/') }}" class="mt-8 inline-block btn-cream-dark px-8 py-3 rounded-full text-sm font-bold">Kembali ke Beranda</a>
            </div>
        @endif
    </div>
</section>
@endsection
