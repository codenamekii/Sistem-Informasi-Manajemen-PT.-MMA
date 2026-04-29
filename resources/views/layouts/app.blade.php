<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('pageTitle', $pageTitle ?? 'Dashboard') — PT. MMA</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 antialiased" x-data="{ sidebarOpen: false }">

  {{-- Overlay mobile --}}
  <div x-show="sidebarOpen" x-transition.opacity x-cloak @click="sidebarOpen = false"
    class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden">
  </div>

  {{-- Sidebar --}}
  <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-30 h-screen w-64 bg-white border-r border-gray-200
           transition-transform duration-300 ease-in-out lg:translate-x-0
           flex flex-col overflow-hidden">

    {{-- ===================== HEADER SIDEBAR ===================== --}}
    <div class="shrink-0 border-b border-gray-200 px-4 py-3 sm:px-4 sm:py-3.5">
      <div class="flex items-center gap-3 min-w-0">
        <div class="flex items-center justify-center w-10 h-10 shrink-0">
          <img src="{{ asset('storage/gambar/logomma.png') }}" alt="Logo MMA" class="w-full h-full object-contain">
        </div>

        <div class="min-w-0 flex-1">
          <p class="text-[12px] sm:text-[13px] font-bold text-gray-800 leading-tight truncate">
            PT. Mitra Mecca Abadi
          </p>
          <p class="mt-0.5 text-[10px] sm:text-[11px] text-gray-400 leading-tight truncate">
            Sistem Manajemen Internal
          </p>
        </div>
      </div>
    </div>

    {{-- ===================== MENU SIDEBAR ===================== --}}
    <div class="flex-1 min-h-0 overflow-y-auto">
      <ul class="px-2.5 py-3 sm:px-3 sm:py-3.5 space-y-0.5 sm:space-y-1">

        @php $user = auth()->user(); @endphp

        {{-- Dashboard --}}
        <li>
          <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                   {{ request()->routeIs('dashboard')
  ? 'bg-blue-50 text-blue-700'
  : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <x-heroicon-o-home class="w-5 h-5 shrink-0" />
            Dashboard
          </a>
        </li>

        {{-- Fasilitas Kesehatan --}}
        @if ($user->canAccess('fasilitas'))
              <li>
                <a href="{{ route('fasilitas-kesehatan.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('fasilitas-kesehatan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-building-office-2 class="w-5 h-5 shrink-0" />
                  Fasilitas Kesehatan
                </a>
              </li>
        @endif

        {{-- Kerja Sama --}}
        @if ($user->canAccess('kerja_sama'))
              <li>
                <a href="{{ route('kerja-sama.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('kerja-sama.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-document-text class="w-5 h-5 shrink-0" />
                  Kerja Sama
                </a>
              </li>
        @endif

        {{-- Dokumen --}}
        @if ($user->canAccess('dokumen'))
              <li>
                <a href="{{ route('dokumen.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('dokumen.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-document class="w-5 h-5 shrink-0" />
                  Dokumen
                </a>
              </li>
        @endif

        {{-- Jadwal Pengangkutan --}}
        @if ($user->canAccess('jadwal'))
              <li>
                <a href="{{ route('jadwal-pengangkutan.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('jadwal-pengangkutan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-calendar-days class="w-5 h-5 shrink-0" />
                  Jadwal Pengangkutan
                </a>
              </li>
        @endif

        {{-- Armada --}}
        @if ($user->canAccess('armada'))
              <li>
                <a href="{{ route('armada.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('armada.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-truck class="w-5 h-5 shrink-0" />
                  Armada
                </a>
              </li>
        @endif

        {{-- Petugas --}}
        @if ($user->canAccess('petugas'))
              <li>
                <a href="{{ route('petugas.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('petugas.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-users class="w-5 h-5 shrink-0" />
                  Petugas
                </a>
              </li>
        @endif

        {{-- Realisasi --}}
        @if ($user->canAccess('realisasi'))
              <li>
                <a href="{{ route('realisasi.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('realisasi.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-check-circle class="w-5 h-5 shrink-0" />
                  Realisasi
                </a>
              </li>
        @endif

        {{-- Laporan --}}
        @if ($user->canAccess('laporan'))
              <li>
                <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                                 {{ request()->routeIs('laporan.*')
          ? 'bg-blue-50 text-blue-700'
          : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                  <x-heroicon-o-document-chart-bar class="w-5 h-5 shrink-0" />
                  Laporan
                </a>
              </li>
        @endif

      </ul>
    </div>

    {{-- ===================== FOOTER SIDEBAR ===================== --}}
    <div class="shrink-0 border-t border-gray-200 bg-white px-2.5 py-3 sm:px-3 sm:py-3.5">
      <div class="px-3 pb-2">
        <p class="text-xs font-medium text-gray-700 truncate">{{ auth()->user()->name }}</p>
        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->labelRole() }}</p>
      </div>

      <a href="{{ route('akun.ubah-password') }}" class="flex w-full items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
               {{ request()->routeIs('akun.ubah-password')
  ? 'bg-blue-50 text-blue-700'
  : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
        <x-heroicon-o-key class="w-5 h-5 shrink-0" />
        Ubah Password
      </a>

      <form method="POST" action="/logout">
        @csrf
        <button type="submit" class="flex w-full items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg
                 text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-200">
          <x-heroicon-o-arrow-right-start-on-rectangle class="w-5 h-5 shrink-0" />
          Logout
        </button>
      </form>
    </div>

  </aside>

  {{-- Wrapper utama --}}
  <div class="lg:ml-64 flex flex-col min-h-screen">

    {{-- Topbar --}}
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200 px-4 py-3">
      <div class="flex items-center justify-between gap-3">

        <button @click="sidebarOpen = !sidebarOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-lg
                 text-gray-500 hover:bg-gray-100 hover:text-gray-700 lg:hidden">
          <x-heroicon-o-bars-3 class="w-5 h-5" />
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


</body>

</html>