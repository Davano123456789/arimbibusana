@extends('layouts.masterPublic')

@section('title', 'Testimoni Pelanggan — Arimbi Queen')
@section('description', 'Baca ulasan nyata dari pelanggan Arimbi Queen. Bagikan pengalaman belanja Anda dan bantu pembeli lain membuat keputusan terbaik.')

@section('head')
<style>
    :root {
        --cream: #F5ECE0;
        --dark-cream: #E8D9C5;
        --cream-dark: #B78A58;
        --accent: #5B3A29;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
    }

    h1, h2, h3, h4 {
        font-family: 'Playfair Display', serif;
    }

    .bg-cream       { background-color: var(--cream); }
    .text-accent    { color: var(--accent); }
    .bg-accent      { background-color: var(--accent); }

    .btn-cream-dark {
        background-color: var(--cream-dark);
        color: #ffffff;
        transition: all 0.3s ease;
        box-shadow: 0 6px 18px rgba(87,52,34,0.12);
    }
    .btn-cream-dark:hover {
        filter: brightness(0.9);
        transform: translateY(-2px);
    }

    /* ── Testi card ── */
    .testi-card {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .testi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    /* ── Interactive Star Rating ── */
    .star-rating-input { display: flex; gap: 6px; flex-direction: row-reverse; justify-content: flex-end; }
    .star-rating-input input { display: none; }
    .star-rating-input label {
        font-size: 1.75rem;
        color: #d1d5db;
        cursor: pointer;
        transition: color 0.15s ease, transform 0.15s ease;
    }
    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label,
    .star-rating-input input:checked ~ label {
        color: #f59e0b;
    }
    .star-rating-input label:hover { transform: scale(1.15); }

    /* ── Image preview ── */
    #imagePreviewWrapper {
        display: none;
        position: relative;
        width: 88px;
        height: 88px;
    }
    #imagePreviewWrapper img {
        width: 88px;
        height: 88px;
        object-fit: cover;
        border-radius: 12px;
        border: 2px solid var(--cream-dark);
    }
    #removeImg {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 22px;
        height: 22px;
        background: #ef4444;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 10px;
        line-height: 1;
    }

    /* ── Mobile menu (same as beranda) ── */
    #mobileMenu { transition: visibility 0.4s; }
    #mobileMenu.hidden { visibility: hidden; display: flex !important; pointer-events: none; }
    #mobileMenuBackdrop { transition: opacity 0.4s ease; }
    #mobileMenu.hidden #mobileMenuBackdrop { opacity: 0; }
    #mobileMenuContent { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); transform: translateX(0); }
    #mobileMenu.hidden #mobileMenuContent { transform: translateX(100%); }

    /* ── Floating WA ── */
    @keyframes floating {
        0%   { transform: translateY(0px); }
        50%  { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    .floating-wa {
        animation: floating 3s ease-in-out infinite;
        box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.4);
    }
    .floating-wa:hover { animation-play-state: paused; transform: scale(1.1); }

    /* ── Rating badge ── */
    .rating-star { color: #f59e0b; }
    .rating-star.empty { color: #d1d5db; }

    /* ── Form section soft bg ── */
    .form-section {
        background: linear-gradient(135deg, var(--cream) 0%, #fff9f2 100%);
        border: 1px solid rgba(183,138,88,0.15);
    }

    /* ── File upload zone ── */
    .file-drop-zone {
        border: 2px dashed rgba(183,138,88,0.4);
        transition: border-color 0.3s, background 0.3s;
        cursor: pointer;
    }
    .file-drop-zone:hover { border-color: var(--cream-dark); background: rgba(245,236,224,0.5); }

    /* ── No scrollbar ── */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection

@section('content')

{{-- ═══════════════════════════════════════════════ HERO ═══════════════════════════════════════════════ --}}
<section class="relative">
    <div class="relative h-[55vh] md:h-[65vh] w-full overflow-hidden bg-black">
        <video id="heroVideo" class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline
            poster="https://images.unsplash.com/photo-1520975911600-5d36cb2d6f6f?q=80&w=1600&auto=format&fit=crop">
            <source src="{{ asset('videos/video-hero.mp4') }}" type="video/mp4">
        </video>

        <div class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/60"></div>

        <button id="heroPlayBtn"
            class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-20 h-20 rounded-full bg-white/95 flex items-center justify-center text-accent text-2xl shadow-lg hidden">
            <i class="fa-solid fa-play"></i>
        </button>

        <div class="max-w-6xl mx-auto px-6 h-full flex items-center">
            <div class="max-w-2xl text-white drop-shadow-lg" data-aos="fade-up">
                <span class="inline-block mb-3 bg-amber-100 text-accent px-3 py-1 rounded-full text-sm font-medium">Suara Pelanggan</span>
                <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-4">Testimoni<br>Pelanggan</h1>
                <p class="mb-6 text-white/90 max-w-lg">Kepercayaan Anda adalah kebanggaan kami. Simak cerita nyata dari pelanggan setia Arimbi Queen.</p>
                <a href="#tulis-ulasan"
                    class="inline-flex items-center gap-2 bg-[#B78A58] text-white px-6 py-3 rounded-full font-semibold shadow-xl hover:brightness-110 active:scale-95 transition-all">
                    <i class="fa-solid fa-pen-to-square"></i> Tulis Ulasan
                </a>
            </div>
        </div>
    </div>
</section>

<main class="max-w-6xl mx-auto px-6 -mt-10 relative z-10">

    {{-- ═══════════════════ SUCCESS / ERROR ALERT ═══════════════════ --}}


    {{-- ═══════════════════ STATS ROW ═══════════════════ --}}
    @php
        $totalReviews = $testimonials->count();
        $avgRating    = $totalReviews > 0 ? round($testimonials->avg('rating'), 1) : 0;
        $fiveStars    = $testimonials->where('rating', 5)->count();
    @endphp
    <section class="mt-12 grid grid-cols-3 gap-4 md:gap-8" data-aos="fade-up">
        <div class="text-center bg-white rounded-2xl shadow-sm border border-gray-50 py-6 px-4">
            <p class="text-3xl md:text-4xl font-bold text-accent font-serif">{{ $totalReviews }}</p>
            <p class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Total Ulasan</p>
        </div>
        <div class="text-center bg-white rounded-2xl shadow-sm border border-gray-50 py-6 px-4">
            <p class="text-3xl md:text-4xl font-bold text-accent font-serif">{{ number_format($avgRating, 1) }}<span class="text-amber-400 text-2xl">★</span></p>
            <p class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Rating Rata-rata</p>
        </div>
        <div class="text-center bg-white rounded-2xl shadow-sm border border-gray-50 py-6 px-4">
            <p class="text-3xl md:text-4xl font-bold text-accent font-serif">{{ $fiveStars }}</p>
            <p class="text-xs text-gray-500 uppercase tracking-wider mt-1 font-semibold">Bintang 5 ⭐</p>
        </div>
    </section>

    {{-- ═══════════════════ TESTIMONIALS GRID ═══════════════════ --}}
    <section class="mt-16" data-aos="fade-up">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900" data-aos="fade-right">
                <i class="fa-solid fa-comments text-amber-400 mr-2"></i> Ulasan Pelanggan
            </h2>
            <span class="text-sm text-gray-400 font-medium" data-aos="fade-left">{{ $totalReviews }} ulasan</span>
        </div>

        @if($testimonials->isEmpty())
        {{-- Empty State --}}
        <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm" data-aos="fade-up">
            <div class="w-20 h-20 rounded-full bg-cream flex items-center justify-center mx-auto mb-6">
                <i class="fa-regular fa-face-smile text-3xl text-[#B78A58]"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Ulasan</h3>
            <p class="text-gray-500 text-sm max-w-xs mx-auto mb-6">Jadilah yang pertama berbagi pengalaman berbelanja di Arimbi Queen!</p>
            <a href="#tulis-ulasan" class="inline-flex items-center gap-2 btn-cream-dark px-6 py-3 rounded-full font-semibold shadow-lg">
                <i class="fa-solid fa-pen-to-square"></i> Tulis Ulasan Pertama
            </a>
        </div>
        @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($testimonials as $i => $testi)
            <div class="testi-card bg-white rounded-2xl shadow-sm hover:shadow-md border border-gray-50 p-7 flex flex-col"
                data-aos="fade-up" data-aos-delay="{{ min($i * 80, 400) }}">

                {{-- Header: avatar + name + rating --}}
                <div class="flex items-start gap-4 mb-5">
                    @if($testi->image)
                        <img src="{{ asset('storage/' . $testi->image) }}" alt="{{ $testi->name }}"
                            class="w-14 h-14 rounded-full object-cover ring-2 ring-amber-100 flex-shrink-0">
                    @else
                        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#B78A58] to-[#5B3A29] flex items-center justify-center text-white text-xl font-bold flex-shrink-0 ring-2 ring-amber-100">
                            {{ mb_strtoupper(mb_substr($testi->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $testi->name }}</p>
                        @if($testi->product)
                            <p class="text-xs text-[#B78A58] font-medium truncate mt-0.5">{{ $testi->product->name }}</p>
                        @endif

                        {{-- Stars --}}
                        <div class="flex gap-0.5 mt-1.5">
                            @for($s = 1; $s <= 5; $s++)
                                <i class="fa-solid fa-star text-xs {{ $s <= $testi->rating ? 'rating-star' : 'rating-star empty' }}"></i>
                            @endfor
                        </div>
                    </div>

                    {{-- Date --}}
                    <span class="text-[10px] text-gray-400 whitespace-nowrap flex-shrink-0 mt-1">
                        {{ $testi->created_at->format('d M Y') }}
                    </span>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-50 mb-4"></div>

                {{-- Comment --}}
                <p class="text-gray-600 italic leading-relaxed text-sm flex-1">"{{ $testi->comment }}"</p>

                {{-- Rating badge --}}
                <div class="mt-5 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 text-xs font-semibold px-3 py-1 rounded-full">
                        <i class="fa-solid fa-star text-amber-500 text-[10px]"></i>
                        {{ $testi->rating }}/5
                    </span>
                    <span class="w-7 h-7 rounded-full bg-green-50 flex items-center justify-center">
                        <i class="fa-solid fa-circle-check text-green-500 text-sm"></i>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- ═══════════════════ WRITE REVIEW FORM ═══════════════════ --}}
    <section id="tulis-ulasan" class="mt-20 mb-24" data-aos="fade-up">
        <div class="form-section rounded-3xl p-8 md:p-12">

            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-10">
                    <span class="inline-block bg-white text-[#B78A58] border border-amber-200 text-xs font-bold uppercase tracking-widest px-4 py-1.5 rounded-full mb-4">Berbagi Pengalaman</span>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Tulis Ulasan Anda</h2>
                    <p class="text-sm text-gray-500">Ulasan Anda sangat berarti bagi pelanggan lain dan membantu kami terus berkembang.</p>
                </div>

                <form action="{{ url('/testimoni') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="reviewForm" novalidate>
                    @csrf

                    {{-- Name + Product --}}
                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="name">
                                <i class="fa-solid fa-user text-[#B78A58] mr-1"></i> Nama Anda <span class="text-red-400">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                placeholder="Mis. Nadhira Putri"
                                class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#B78A58]/30 focus:border-[#B78A58] transition-all shadow-sm @error('name') border-red-400 @enderror">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2" for="product_id">
                                <i class="fa-solid fa-tag text-[#B78A58] mr-1"></i> Pilih Produk <span class="text-red-400">*</span>
                            </label>
                            <select id="product_id" name="product_id" required
                                class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#B78A58]/30 focus:border-[#B78A58] transition-all shadow-sm @error('product_id') border-red-400 @enderror">
                                <option value="" disabled {{ old('product_id') ? '' : 'selected' }}>— Pilih produk —</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fa-solid fa-star text-[#B78A58] mr-1"></i> Rating <span class="text-red-400">*</span>
                        </label>
                        <div class="star-rating-input" id="starInput">
                            @for($r = 5; $r >= 1; $r--)
                                <input type="radio" id="star{{ $r }}" name="rating" value="{{ $r }}" {{ old('rating') == $r ? 'checked' : '' }}>
                                <label for="star{{ $r }}" title="{{ $r }} bintang">
                                    <i class="fa-solid fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-400 mt-2" id="starLabel">Pilih bintang untuk memberi rating</p>
                        @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Comment --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="comment">
                            <i class="fa-solid fa-comment text-[#B78A58] mr-1"></i> Ulasan <span class="text-red-400">*</span>
                        </label>
                        <textarea id="comment" name="comment" rows="5" required
                            placeholder="Ceritakan pengalaman berbelanja Anda, kualitas produk, proses pengiriman, dll..."
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#B78A58]/30 focus:border-[#B78A58] transition-all shadow-sm resize-none @error('comment') border-red-400 @enderror">{{ old('comment') }}</textarea>
                        <div class="flex justify-between mt-1">
                            @error('comment')<p class="text-red-500 text-xs">{{ $message }}</p>@enderror
                            <span class="text-xs text-gray-400 ml-auto" id="charCount">0 / 1000</span>
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fa-solid fa-image text-[#B78A58] mr-1"></i> Foto (opsional)
                        </label>
                        <div class="flex items-start gap-4">
                            <div id="imagePreviewWrapper">
                                <img id="imagePreview" src="#" alt="Preview">
                                <button type="button" id="removeImg" title="Hapus foto">
                                    <i class="fa-solid fa-xmark fa-2xs"></i>
                                </button>
                            </div>
                            <label for="image" class="file-drop-zone flex-1 flex flex-col items-center justify-center gap-2 py-6 px-4 rounded-xl bg-white text-gray-400 text-sm text-center">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl text-[#B78A58]/60"></i>
                                <span>Klik atau seret foto ke sini</span>
                                <span class="text-xs text-gray-300">JPG, PNG, GIF — maks. 2 MB</span>
                                <input type="file" id="image" name="image" accept="image/*" class="sr-only">
                            </label>
                        </div>
                        @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Submit --}}
                    <div class="pt-2">
                        <button type="submit" id="submitBtn"
                            class="w-full btn-cream-dark py-4 rounded-2xl font-bold text-base tracking-wide shadow-xl flex items-center justify-center gap-3 active:scale-95 transition-all">
                            <i class="fa-solid fa-paper-plane"></i>
                            Kirim Ulasan
                        </button>
                        <p class="text-center text-xs text-gray-400 mt-3">
                            <i class="fa-solid fa-lock mr-1"></i> Ulasan Anda aman dan tidak akan dibagikan tanpa izin.
                        </p>
                    </div>

                </form>
            </div>
        </div>
    </section>

</main>

{{-- Floating WhatsApp --}}
<a href="https://wa.me/6282337115553"
    class="fixed bottom-6 right-6 z-50 bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center text-2xl floating-wa transition-all hover:bg-green-600"
    aria-label="Chat via WhatsApp" title="Hubungi Kami via WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>

@endsection

@section('scripts')
<script>
    // ── Hero video autoplay ──
    const heroVideo  = document.getElementById('heroVideo');
    const heroPlayBtn = document.getElementById('heroPlayBtn');
    if (heroVideo) {
        heroVideo.play().catch(() => { if (heroPlayBtn) heroPlayBtn.classList.remove('hidden'); });
        heroVideo.addEventListener('pause', () => { if (heroPlayBtn) heroPlayBtn.classList.remove('hidden'); });
        heroVideo.addEventListener('playing', () => { if (heroPlayBtn) heroPlayBtn.classList.add('hidden'); });
        if (heroPlayBtn) {
            heroPlayBtn.addEventListener('click', () => {
                heroVideo.muted = true;
                heroVideo.play().then(() => heroPlayBtn.classList.add('hidden')).catch(() => {});
            });
        }
    }

    // ── Star rating label feedback ──
    const starLabel  = document.getElementById('starLabel');
    const starLabels = ['', 'Kurang memuaskan', 'Cukup memuaskan', 'Lumayan bagus', 'Bagus sekali', 'Luar biasa!'];
    document.querySelectorAll('.star-rating-input input').forEach(radio => {
        radio.addEventListener('change', () => {
            if (starLabel) starLabel.textContent = starLabels[radio.value] ?? '';
        });
    });

    // set initial label if old() value exists (after validation error)
    const checkedStar = document.querySelector('.star-rating-input input:checked');
    if (checkedStar && starLabel) starLabel.textContent = starLabels[checkedStar.value] ?? '';

    // ── Character counter ──
    const commentArea = document.getElementById('comment');
    const charCount   = document.getElementById('charCount');
    if (commentArea && charCount) {
        const update = () => {
            const len = commentArea.value.length;
            charCount.textContent = len + ' / 1000';
            charCount.style.color = len > 900 ? '#ef4444' : '';
        };
        commentArea.addEventListener('input', update);
        update();
    }

    // ── Image preview ──
    const imageInput   = document.getElementById('image');
    const previewWrapper = document.getElementById('imagePreviewWrapper');
    const previewImg   = document.getElementById('imagePreview');
    const removeImgBtn = document.getElementById('removeImg');

    if (imageInput) {
        imageInput.addEventListener('change', () => {
            const file = imageInput.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => {
                previewImg.src = e.target.result;
                previewWrapper.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    if (removeImgBtn) {
        removeImgBtn.addEventListener('click', () => {
            imageInput.value = '';
            previewImg.src   = '#';
            previewWrapper.style.display = 'none';
        });
    }

    // ── Drag-over visual feedback ──
    const dropZone = document.querySelector('.file-drop-zone');
    if (dropZone) {
        ['dragover', 'dragenter'].forEach(ev =>
            dropZone.addEventListener(ev, e => { e.preventDefault(); dropZone.style.borderColor = 'var(--cream-dark)'; })
        );
        ['dragleave', 'drop'].forEach(ev =>
            dropZone.addEventListener(ev, () => { dropZone.style.borderColor = ''; })
        );
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                const reader = new FileReader();
                reader.onload = ev => {
                    previewImg.src = ev.target.result;
                    previewWrapper.style.display = 'block';
                };
                reader.readAsDataURL(files[0]);
            }
        });
    }

    // ── Submit loading state ──
    const reviewForm = document.getElementById('reviewForm');
    const submitBtn  = document.getElementById('submitBtn');
    if (reviewForm && submitBtn) {
        reviewForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
        });
    }

    // ── Auto dismiss success alert ──
    const successAlert = document.querySelector('[role="alert"]');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500);
        }, 5000);
    }

    // ── Mobile menu (consistent with page layout) ──
    const btnMobile   = document.getElementById('btn-mobile');
    const mobileMenu  = document.getElementById('mobileMenu');
    const mobileClose = document.getElementById('mobileClose');
    const mobileBackdrop = document.getElementById('mobileMenuBackdrop');

    if (btnMobile && mobileMenu) {
        btnMobile.addEventListener('click', () => mobileMenu.classList.remove('hidden'));
    }
    const closeMobileMenu = () => { if (mobileMenu) mobileMenu.classList.add('hidden'); };
    if (mobileClose)    mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);
    document.querySelectorAll('.mobile-nav-link').forEach(link => link.addEventListener('click', closeMobileMenu));
</script>
@endsection
