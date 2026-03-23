<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Arimbi Queen')</title>
  <meta name="description"
    content="@yield('description', 'Arimbi Queen - Scarf premium, mukena, hijab, busana wanita. Toko wanita anggun, sopan, percaya diri.')" />

  <!-- Tailwind Play CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            accent: '#5B3A29',
            cream: '#F5ECE0',
            'cream-dark': '#B78A58',
          }
        }
      }
    }
  </script>
  <!-- Google Fonts (elegant headings) + Font Awesome -->
  <link
    href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
  <!-- IziToast -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast/dist/css/iziToast.min.css">
  
  {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

  @yield('head')

</head>

<body class="antialiased text-gray-800 bg-white overflow-x-hidden">

  @include('layouts.navbar')

  <main>
    @yield('content')
  </main>

  @include('layouts.footer')

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100,
    });

    // Mobile menu open/close
    const btnMobile = document.getElementById('btn-mobile');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuContent = document.getElementById('mobileMenuContent');
    const mobileBackdrop = document.getElementById('mobileMenuBackdrop');
    const mobileClose = document.getElementById('mobileClose');

    if (btnMobile && mobileMenu) {
      btnMobile.addEventListener('click', () => {
        // Show container
        mobileMenu.classList.remove('invisible');
        document.body.classList.add('overflow-hidden');
        
        // Trigger animations
        setTimeout(() => {
          if (mobileBackdrop) {
            mobileBackdrop.classList.remove('opacity-0');
            mobileBackdrop.classList.add('opacity-100');
          }
          if (mobileMenuContent) {
            mobileMenuContent.classList.remove('translate-x-full');
            mobileMenuContent.classList.add('translate-x-0');
          }
        }, 10);
      });
    }

    const closeMobileMenu = () => {
      if (!mobileMenu) return;

      // Reverse animations and enable body scroll
      document.body.classList.remove('overflow-hidden');

      if (mobileBackdrop) {
        mobileBackdrop.classList.remove('opacity-100');
        mobileBackdrop.classList.add('opacity-0');
      }
      if (mobileMenuContent) {
        mobileMenuContent.classList.remove('translate-x-0');
        mobileMenuContent.classList.add('translate-x-full');
      }

      // Hide container after transition
      setTimeout(() => {
        mobileMenu.classList.add('invisible');
        document.body.classList.remove('overflow-hidden');
      }, 300); // Matches duration-300
    };

    if (mobileClose) mobileClose.addEventListener('click', closeMobileMenu);
    if (mobileBackdrop) mobileBackdrop.addEventListener('click', closeMobileMenu);

    // Close menu when clicking links
    document.querySelectorAll('.mobile-nav-link').forEach(link => {
      link.addEventListener('click', closeMobileMenu);
    });

    // Like button toggle (global)
    document.addEventListener('click', async (e) => {
      const likeBtn = e.target.closest('.like-btn');
      if (!likeBtn) return;
      
      const productId = likeBtn.getAttribute('data-id');
      if (!productId) return;

      const icon = likeBtn.querySelector('i');
      
      // Prevent multiple clicks
      if (likeBtn.classList.contains('pointer-events-none')) return;
      likeBtn.classList.add('pointer-events-none');

      try {
        const response = await fetch(`/detail-produk/${productId}/like`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });

        const data = await response.json();
        
        if (data.status === 'liked') {
          icon.classList.remove('fa-regular');
          icon.classList.add('fa-solid');
          
          // Specialized UI handling (for detail page)
          if (likeBtn.classList.contains('border-2')) {
            likeBtn.classList.add('bg-red-50', 'border-red-100');
            likeBtn.classList.remove('border-gray-100');
          }

          // Update count if exists
          const countSpan = document.getElementById('likeCount');
          if (countSpan) countSpan.textContent = data.likes_count;
        } else {
          icon.classList.remove('fa-solid');
          icon.classList.add('fa-regular');
          
          // Specialized UI handling (for detail page)
          if (likeBtn.classList.contains('border-2')) {
            likeBtn.classList.remove('bg-red-50', 'border-red-100');
            likeBtn.classList.add('border-gray-100');
          }

          // Update count if exists
          const countSpan = document.getElementById('likeCount');
          if (countSpan) countSpan.textContent = data.likes_count;
        }
      } catch (error) {
        console.error('Error toggling like:', error);
        if (typeof iziToast !== 'undefined') {
          iziToast.error({
            title: 'Error',
            message: 'Gagal memproses Like. Silakan coba lagi.',
            position: 'topRight'
          });
        }
      } finally {
        likeBtn.classList.remove('pointer-events-none');
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/izitoast/dist/js/iziToast.min.js"></script>
  @include('layouts.notifications')
  @yield('scripts')
</body>

</html>
