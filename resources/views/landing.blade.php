<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PT. Mitra Mecca Abadi</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white antialiased">

  {{-- Navbar --}}
  <nav class="bg-white border-b border-gray-200 px-4 lg:px-6 py-3 shadow-sm">
    <div class="flex justify-between items-center mx-auto max-w-screen-xl">

      <a href="/">
        <span class="text-xl font-bold text-blue-700 whitespace-nowrap">
          PT. Mitra Mecca Abadi
        </span>
      </a>

      <a href="/login"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                      font-medium rounded-lg text-sm px-4 py-2 transition-colors duration-200">
        Login
      </a>

    </div>
  </nav>

  {{-- Hero --}}
  <section class="py-24 px-4">
    <div class="max-w-screen-md mx-auto text-center">

      <span
        class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1
                         rounded-full mb-6 inline-block tracking-wide uppercase">
        Sistem Informasi Internal
      </span>

      <h1 class="mb-5 text-4xl font-extrabold tracking-tight text-gray-900 md:text-5xl leading-tight">
        Manajemen Mitra &amp; Penjadwalan<br>Limbah Infeksius
      </h1>

      <p class="mb-10 text-lg text-gray-500 lg:px-10">
        Platform digital untuk pengelolaan mitra kerja sama dan penjadwalan
        pengangkutan limbah infeksius PT. Mitra Mecca Abadi secara terpusat.
      </p>

      <a href="/login"
        class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base
                      font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800
                      focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
        Masuk ke Sistem
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
        </svg>
      </a>

    </div>
  </section>

  {{-- Footer --}}
  <footer class="border-t border-gray-200 py-8 mt-12">
    <div class="max-w-screen-xl mx-auto px-4 text-center">
      <p class="text-sm text-gray-400">
        &copy; {{ date('Y') }} PT. Mitra Mecca Abadi. Hak cipta dilindungi undang-undang.
      </p>
    </div>
  </footer>

</body>

</html>
