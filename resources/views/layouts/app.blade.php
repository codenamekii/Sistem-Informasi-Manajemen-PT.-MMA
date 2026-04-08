<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('pageTitle', $pageTitle ?? 'Dashboard') — PT. MMA</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="bg-gray-50 antialiased" x-data="{ sidebarOpen: false }">

  {{-- Overlay mobile --}}
  <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
    class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden">
  </div>

  {{-- Sidebar --}}
  <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-30 h-screen w-64 bg-white border-r border-gray-200
                  transition-transform duration-300 ease-in-out lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-200">
      <div class="flex items-center justify-center w-10 h-10 shrink-0">
        <img src="{{ asset('storage/gambar/logomma.png') }}" alt="Logo MMA" class="w-full h-full object-contain">
      </div>
      <div class="overflow-hidden">
        <p class="text-sm font-bold text-gray-800 leading-tight truncate">PT. Mitra Mecca Abadi</p>
        <p class="text-xs text-gray-400 leading-tight">Sistem Manajemen Internal</p>
      </div>
    </div>

    {{-- Nav --}}
    <nav class="flex flex-col justify-between h-[calc(100vh-65px)]">
      <ul class="px-3 py-4 space-y-1 overflow-y-auto">

        @php $user = auth()->user(); @endphp

        {{-- Dashboard — semua role --}}
        <li>
          <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                               {{ request()->routeIs('dashboard')
  ? 'bg-blue-50 text-blue-700'
  : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0
                                   01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
          </a>
        </li>

        {{-- Fasilitas Kesehatan --}}
        @if ($user->canAccess('fasilitas'))
              <li>
                <a href="{{ route('fasilitas-kesehatan.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('fasilitas-kesehatan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2
                                               0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                  Fasilitas Kesehatan
                </a>
              </li>
        @endif

        {{-- Kerja Sama --}}
        @if ($user->canAccess('kerja_sama'))
              <li>
                <a href="{{ route('kerja-sama.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('kerja-sama.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                                               01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Kerja Sama
                </a>
              </li>
        @endif

        {{-- Dokumen --}}
        @if ($user->canAccess('dokumen'))
              <li>
                <a href="{{ route('dokumen.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('dokumen.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0
                                               0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                  </svg>
                  Dokumen
                </a>
              </li>
        @endif

        {{-- Jadwal Pengangkutan --}}
        @if ($user->canAccess('jadwal'))
              <li>
                <a href="{{ route('jadwal-pengangkutan.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('jadwal-pengangkutan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                                               00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  Jadwal Pengangkutan
                </a>
              </li>
        @endif

        {{-- Armada --}}
        @if ($user->canAccess('armada'))
              <li>
                <a href="{{ route('armada.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('armada.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                  </svg>
                  Armada
                </a>
              </li>
        @endif

        {{-- Petugas --}}
        @if ($user->canAccess('petugas'))
              <li>
                <a href="{{ route('petugas.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('petugas.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7
                                               20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002
                                               0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Petugas
                </a>
              </li>
        @endif

        {{-- Realisasi --}}
        @if ($user->canAccess('realisasi'))
              <li>
                <a href="{{ route('realisasi.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('realisasi.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  Realisasi
                </a>
              </li>
        @endif

        {{-- Laporan --}}
        @if ($user->canAccess('laporan'))
              <li>
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg
                                           {{ request()->routeIs('laporan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0
                                               01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                  Laporan
                </a>
              </li>
        @endif

      </ul>

      {{-- Footer sidebar: label role + logout --}}
      <div class="px-3 py-4 border-t border-gray-200 space-y-1">

        {{-- Label role --}}
        <div class="px-3 py-2">
          <p class="text-xs font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
          <p class="text-xs text-gray-400 truncate">{{ auth()->user()->labelRole() }}</p>
        </div>

        <form method="POST" action="/logout">
          @csrf
          <button type="submit" class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-medium
                               rounded-lg text-red-600 hover:bg-red-50 hover:text-red-700
                               transition-colors duration-200">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0
                                   01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            Logout
          </button>
        </form>
      </div>
    </nav>

  </aside>

  {{-- Wrapper utama --}}
  <div class="lg:ml-64 flex flex-col min-h-screen">

    {{-- Topbar --}}
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200 px-4 py-3">
      <div class="flex items-center justify-between gap-3">

        <button @click="sidebarOpen = !sidebarOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-lg
                           text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <h1 class="text-base font-semibold text-gray-700 truncate">
          @yield('pageTitle', $pageTitle ?? 'Dashboard')
        </h1>

        <div class="flex items-center gap-3 ml-auto">
          <div class="text-right hidden sm:block">
            <p class="text-sm font-medium text-gray-800 leading-tight">
              {{ auth()->user()->name }}
            </p>
            <p class="text-xs text-gray-400 leading-tight">
              {{ auth()->user()->labelRole() }}
            </p>
          </div>
          <div class="flex items-center justify-center w-8 h-8 rounded-full
                                bg-blue-700 text-white text-sm font-bold shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
        </div>

      </div>
    </header>

    {{-- Konten halaman --}}
    <main class="flex-1 p-4 sm:p-6">
      {{ $slot ?? '' }}
      @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="px-6 py-4 border-t border-gray-100">
      <p class="text-xs text-gray-400 text-center">
        &copy; {{ date('Y') }} PT. Mitra Mecca Abadi. All rights reserved.
      </p>
    </footer>

  </div>

  @livewireScripts

</body>

</html>