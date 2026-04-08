<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — PT. Mitra Mecca Abadi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f3f3f1] text-neutral-900 antialiased">

    <div class="relative min-h-screen overflow-hidden">

        {{-- Dekorasi pojok kiri atas --}}
        <div class="absolute left-0 top-0 h-44 w-44 bg-red-600/95"
            style="clip-path: polygon(0 0, 100% 0, 0 100%)"></div>
        <div class="absolute left-20 top-0 h-32 w-32 bg-yellow-400"
            style="clip-path: polygon(0 0, 100% 0, 0 100%)"></div>
        {{-- Dekorasi pojok kanan bawah --}}
        <div class="absolute bottom-0 right-0 h-72 w-72 bg-orange-500/80"
            style="clip-path: polygon(100% 0, 100% 100%, 0 100%)"></div>
        <div class="absolute bottom-0 right-24 h-44 w-44 bg-red-500/90"
            style="clip-path: polygon(100% 0, 100% 100%, 0 100%)"></div>
        {{-- Radial gradient overlay --}}
        <div class="absolute inset-0"
            style="background: radial-gradient(circle at top left, rgba(255,255,255,0.7) 0%, transparent 35%),
                              radial-gradient(circle at bottom right, rgba(255,255,255,0.6) 0%, transparent 30%)">
        </div>

        <div class="relative mx-auto grid min-h-screen max-w-7xl items-center gap-10 px-6 py-10
                    md:px-10 lg:grid-cols-[1.05fr_0.95fr] lg:px-16 lg:py-16">

            {{-- Kiri: Branding (hanya tampil di desktop) --}}
            <section class="hidden lg:block">
                <div class="mb-8">
                    <img src="{{ asset('storage/gambar/logomma.png') }}"
                        alt="Logo PT. Mitra Mecca Abadi"
                        class="h-24 w-auto object-contain">
                </div>
                <div class="max-w-xl">
                    <div class="inline-flex rounded-full border border-neutral-300 bg-white/80 px-4
                                py-1.5 text-sm font-medium text-neutral-700 shadow-sm backdrop-blur">
                        Sistem Informasi Manajemen Limbah Infeksius
                    </div>
                    <h1 class="mt-6 text-5xl font-black leading-tight tracking-tight text-neutral-900">
                        Sistem manajemen internal PT. Mitra Mecca Abadi.
                    </h1>
                    <p class="mt-5 text-lg leading-8 text-neutral-700">
                        Masuk untuk mengelola data operasional, jadwal pengangkutan, kerja sama,
                        dan laporan secara terpusat dalam satu platform yang profesional.
                    </p>
                </div>
            </section>

            {{-- Kanan: Form Login --}}
            <section class="mx-auto w-full max-w-md lg:max-w-lg" x-data="{ showPassword: false }">
                <div class="rounded-[32px] border border-white/50 bg-white/85 p-6 shadow-2xl
                            shadow-neutral-900/10 backdrop-blur md:p-8">

                    {{-- Header form --}}
                    <div class="mb-8 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-red-600">
                                Portal Login
                            </p>
                            <h2 class="mt-2 text-3xl font-black text-neutral-900">Masuk ke Sistem</h2>
                            <p class="mt-2 text-sm leading-6 text-neutral-500">
                                Silakan masuk menggunakan akun resmi Anda untuk melanjutkan ke dashboard.
                            </p>
                        </div>
                        <div class="hidden rounded-2xl bg-neutral-50 p-3 ring-1 ring-neutral-200 md:block shrink-0 ml-4">
                            <img src="{{ asset('storage/gambar/logomma.png') }}"
                                alt="Logo PT. Mitra Mecca Abadi"
                                class="h-12 w-auto object-contain">
                        </div>
                    </div>

                    {{-- Validation errors --}}
                    @if ($errors->any())
                        <div class="mb-5 rounded-2xl bg-red-50 px-4 py-3 text-sm text-red-700
                                    ring-1 ring-red-200">
                            <ul class="space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Session status --}}
                    @if (session('status'))
                        <div class="mb-5 rounded-2xl bg-green-50 px-4 py-3 text-sm text-green-700
                                    ring-1 ring-green-200">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        {{-- Email --}}
                        <div>
                            <label for="email"
                                class="mb-2 block text-sm font-semibold text-neutral-800">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" class="h-5 w-5">
                                        <path d="M1.5 8.67v8.58a2.25 2.25 0 0 0 2.25 2.25h16.5a2.25 2.25 0 0 0 2.25-2.25V8.67l-9.35 5.61a2.25 2.25 0 0 1-2.3 0L1.5 8.67Z"/>
                                        <path d="M22.5 6.908V6.75A2.25 2.25 0 0 0 20.25 4.5H3.75A2.25 2.25 0 0 0 1.5 6.75v.158l10.355 6.213a.75.75 0 0 0 .79 0L22.5 6.908Z"/>
                                    </svg>
                                </span>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    placeholder="nama@mma.co.id"
                                    class="w-full rounded-2xl border py-4 pl-12 pr-4 text-base
                                           text-neutral-900 outline-none transition
                                           placeholder:text-neutral-400
                                           focus:border-red-300 focus:bg-white focus:ring-4 focus:ring-red-100
                                           @error('email') border-red-400 bg-red-50 @else border-neutral-200 bg-neutral-50 @enderror">
                            </div>
                        </div>

                        {{-- Password --}}
                        <div>
                            <label for="password"
                                class="mb-2 block text-sm font-semibold text-neutral-800">
                                Password
                            </label>
                            <div class="relative">
                                <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" class="h-5 w-5">
                                        <path fill-rule="evenodd"
                                            d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25V9h-.75A2.25 2.25 0 0 0 3.75 11.25v8.25A2.25 2.25 0 0 0 6 21.75h12a2.25 2.25 0 0 0 2.25-2.25v-8.25A2.25 2.25 0 0 0 18 9h-.75V6.75A5.25 5.25 0 0 0 12 1.5Zm3.75 7.5V6.75a3.75 3.75 0 1 0-7.5 0V9h7.5Z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                </span>
                                <input
                                    id="password"
                                    :type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full rounded-2xl border py-4 pl-12 pr-12 text-base
                                           text-neutral-900 outline-none transition
                                           placeholder:text-neutral-400
                                           focus:border-red-300 focus:bg-white focus:ring-4 focus:ring-red-100
                                           @error('password') border-red-400 bg-red-50 @else border-neutral-200 bg-neutral-50 @enderror">
                                {{-- Toggle show/hide --}}
                                <button type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-neutral-400
                                           transition hover:text-neutral-600">
                                    <svg x-show="!showPassword"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" class="h-5 w-5">
                                        <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                                        <path fill-rule="evenodd"
                                            d="M1.323 11.447C2.811 6.976 7.028 3.75 12.001 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113-1.487 4.471-5.705 7.697-10.677 7.697-4.97 0-9.186-3.223-10.675-7.69a1.762 1.762 0 0 1 0-1.113ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                    <svg x-show="showPassword" x-cloak
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="currentColor" class="h-5 w-5">
                                        <path d="M3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18ZM22.676 12.553a11.249 11.249 0 0 1-2.631 4.31l-3.099-3.099a5.25 5.25 0 0 0-6.71-6.71L7.759 4.577A11.217 11.217 0 0 1 12 3.75c4.97 0 9.185 3.223 10.675 7.69.12.362.12.752 0 1.113ZM15.75 12c0 .18-.013.357-.037.53l-4.244-4.243A3.75 3.75 0 0 1 15.75 12ZM12.001 3.75a9.77 9.77 0 0 0-4.424 1.047l-3.09-3.09a11.21 11.21 0 0 0-2.539 3.257 11.25 11.25 0 0 0 4.049 14.573l3.09-3.09A5.25 5.25 0 0 1 8.25 12a3.75 3.75 0 0 1 5.034-3.54l-1.56-1.56A5.251 5.251 0 0 0 8.25 12a3.75 3.75 0 0 1 3.462-3.73L8.001 4.558A9.77 9.77 0 0 0 12 3.75Z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Remember + Lupa Password --}}
                        <div class="flex items-center justify-between gap-4 pt-1">
                            <label class="inline-flex items-center gap-3 text-sm font-medium text-neutral-600 cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="h-5 w-5 rounded border-neutral-300 text-red-600
                                           focus:ring-red-200 cursor-pointer">
                                Ingat saya
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                    class="text-sm font-semibold text-red-600 transition hover:text-red-700">
                                    Lupa password?
                                </a>
                            @endif
                        </div>

                        {{-- Submit --}}
                        <button type="submit"
                            class="w-full rounded-2xl bg-gradient-to-r from-red-600 via-orange-500
                                   to-yellow-400 px-5 py-4 text-base font-bold text-white shadow-lg
                                   shadow-orange-500/20 transition hover:-translate-y-0.5 hover:shadow-xl
                                   active:translate-y-0">
                            Masuk ke Dashboard
                        </button>
                    </form>

                    {{-- Notice --}}
                    <div class="mt-6 rounded-2xl bg-neutral-50 px-4 py-3 text-sm leading-6
                                text-neutral-500 ring-1 ring-neutral-200">
                        Akses sistem ini hanya diperuntukkan bagi pengguna yang memiliki otorisasi
                        resmi dari PT. Mitra Mecca Abadi.
                    </div>
                </div>

                <div class="mt-5 text-center text-sm text-neutral-500 lg:text-left">
                    © {{ date('Y') }} PT. Mitra Mecca Abadi. All rights reserved.
                </div>
            </section>
        </div>
    </div>

</body>
</html>