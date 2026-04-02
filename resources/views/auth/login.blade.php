@extends('layouts.guest')

@section('content')
  <div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">

      {{-- Brand --}}
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900">PT. Mitra Mecca Abadi</h1>
        <p class="text-sm text-gray-500 mt-1">Sistem Informasi Manajemen Limbah Infeksius</p>
      </div>

      {{-- Card --}}
      <div class="bg-white rounded-lg shadow-md border border-gray-200 p-8">

        <h2 class="text-xl font-semibold text-gray-800 mb-6">Masuk ke Sistem</h2>

        {{-- Error --}}
        @if ($errors->any())
          <div class="flex items-center p-4 mb-5 text-sm text-red-800 rounded-lg bg-red-50 border border-red-200"
            role="alert">
            <svg class="shrink-0 inline w-4 h-4 me-3" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form method="POST" action="/login">
          @csrf

          {{-- Email --}}
          <div class="mb-5">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
              Alamat Email
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@mma.co.id"
              required autofocus
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
          </div>

          {{-- Password --}}
          <div class="mb-6">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
              Password
            </label>
            <input type="password" id="password" name="password" placeholder="••••••••" required
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
          </div>

          {{-- Remember Me --}}
          <div class="flex items-center mb-6">
            <input id="remember" name="remember" type="checkbox"
              class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
            <label for="remember" class="ms-2 text-sm font-medium text-gray-600">
              Ingat saya
            </label>
          </div>

          {{-- Submit --}}
          <button type="submit"
            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4
                           focus:outline-none focus:ring-blue-300 font-medium rounded-lg
                           text-sm px-5 py-2.5 text-center transition-colors duration-200">
            Masuk
          </button>
        </form>
      </div>

      <p class="text-center text-xs text-gray-400 mt-6">
        &copy; {{ date('Y') }} PT. Mitra Mecca Abadi. All rights reserved.
      </p>

    </div>
  </div>
@endsection
