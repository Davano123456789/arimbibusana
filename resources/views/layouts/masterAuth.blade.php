<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Arimbi Queen')</title>

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
  <!-- Google Fonts + Font Awesome -->
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <!-- AOS Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <style>
    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }
    h1, h2, h3, .font-serif {
      font-family: 'Playfair Display', serif;
    }
  </style>
  @yield('head')
</head>

<body class="antialiased text-gray-800 bg-white">

  <main>
    @yield('content')
  </main>

  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
    });
  </script>
  @yield('scripts')
</body>

</html>
