<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Mitra Mecca Abadi — Transporter Limbah B3</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f3f3f1] text-neutral-900 antialiased">

    {{-- HEADER --}}
    <header class="relative overflow-hidden border-b border-neutral-200 bg-white">
        {{-- Dekorasi pojok kiri atas --}}
        <div class="absolute left-0 top-0 h-40 w-40 bg-red-600/90"
            style="clip-path: polygon(0 0, 100% 0, 0 100%)"></div>
        <div class="absolute left-16 top-0 h-28 w-28 bg-yellow-400"
            style="clip-path: polygon(0 0, 100% 0, 0 100%)"></div>
        {{-- Dekorasi pojok kanan bawah --}}
        <div class="absolute bottom-0 right-0 h-56 w-56 bg-orange-500/80"
            style="clip-path: polygon(100% 0, 100% 100%, 0 100%)"></div>
        <div class="absolute bottom-0 right-20 h-36 w-36 bg-red-500/90"
            style="clip-path: polygon(100% 0, 100% 100%, 0 100%)"></div>

        <div class="relative mx-auto grid max-w-7xl gap-10 px-6 py-8
                    md:grid-cols-[1.2fr_0.8fr] md:px-10 lg:px-16 lg:py-16">

            {{-- Kiri: Logo + Nama + Tagline --}}
            <div>
                {{-- [REVISI 1] Logo + nama perusahaan sejajar --}}
                <div class="mb-6 flex items-center gap-4">
                    <img src="{{ asset('storage/gambar/logomma.png') }}"
                        alt="Logo PT. Mitra Mecca Abadi"
                        class="h-20 w-auto object-contain md:h-24">
                    <span class="text-xl font-black uppercase tracking-wide text-neutral-900
                                 md:text-2xl leading-tight">
                        PT. MITRA<br>MECCA ABADI
                    </span>
                </div>
                <h1 class="max-w-3xl text-4xl font-black tracking-tight md:text-6xl">
                    Solusi transporter Limbah B3 yang profesional, aman, dan Terpercaya
                </h1>
                <p class="mt-5 max-w-2xl text-base leading-7 text-neutral-700 md:text-lg">
                    PT. Mitra Mecca Abadi hadir sebagai mitra layanan pengangkutan dan pengelolaan
                    Limbah B3 yang berkomitmen pada profesionalisme, kepatuhan, dan tanggung jawab
                    lingkungan untuk mendukung kebutuhan perusahaan, fasilitas kesehatan, dan institusi.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#tentang"
                        class="rounded-2xl bg-neutral-900 px-5 py-3 text-sm font-semibold
                               text-white shadow-lg shadow-neutral-900/15 hover:bg-neutral-800
                               transition-colors duration-200">
                        Selengkapnya
                    </a>
                    <a href="{{ route('login') }}"
                        class="rounded-2xl border border-neutral-300 bg-white px-5 py-3
                               text-sm font-semibold text-neutral-800 hover:bg-neutral-50
                               transition-colors duration-200">
                        Masuk ke Sistem
                    </a>
                </div>
            </div>

            {{-- Kanan: Highlight cards --}}
            <div class="grid grid-cols-2 gap-4 self-end">
                @foreach ([
  'Pelayanan profesional dan bertanggung jawab',
  'Berorientasi pada kepatuhan regulasi',
  'Mitra pengangkutan Limbah B3 yang siap dipercaya',
  'Komitmen pada keselamatan dan lingkungan',
] as $item)
                      <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-neutral-200">
                          <div class="mb-3 h-2 w-14 rounded-full bg-yellow-400"></div>
                          <p class="text-sm font-semibold leading-6 text-neutral-800">{{ $item }}</p>
                      </div>
                @endforeach
            </div>
        </div>
    </header>

    {{-- MAIN --}}
    <main class="mx-auto max-w-7xl space-y-8 px-6 py-8 md:px-10 lg:px-16 lg:py-12">

        {{-- Section: Tentang + Info Cards --}}
        <section id="tentang" class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">

            {{-- [REVISI 2] Gambar hero --}}
            <div class="rounded-[28px] bg-white p-7 shadow-sm ring-1 ring-neutral-200">
                <div class="mb-3 inline-flex rounded-full bg-red-50 px-3 py-1
                            text-xs font-semibold uppercase tracking-[0.18em] text-red-600">
                    Tentang Kami
                </div>
                <div class="h-[360px] w-full overflow-hidden rounded-[24px]">
                    <img src="{{ asset('storage/gambar/hero.png') }}"
                        alt="Operasional PT. Mitra Mecca Abadi"
                        class="h-full w-full object-cover">
                </div>
            </div>

            {{-- Info cards --}}
            <div class="grid gap-6 sm:grid-cols-2">
                @foreach ([
  [
    'accent' => 'Tentang',
    'title' => 'Tentang Kami',
    'text' => 'PT. Mitra Mecca Abadi adalah perusahaan yang bergerak di bidang transporter Limbah Bahan Berbahaya dan Beracun (B3), dengan komitmen pada pelayanan yang profesional, aman, bertanggung jawab, dan sesuai dengan ketentuan peraturan perundang-undangan yang berlaku di Indonesia.',
  ],
  [
    'accent' => 'Visi Misi',
    'title' => 'Visi & Misi',
    'text' => 'Kami menempatkan kualitas layanan, kepatuhan operasional, keselamatan lingkungan, dan kemitraan berkelanjutan sebagai fondasi utama dalam membangun perusahaan yang terpercaya.',
  ],
  [
    'accent' => 'Layanan',
    'title' => 'Layanan Kami',
    'text' => 'Layanan utama disajikan secara ringkas agar calon klien dapat segera memahami cakupan solusi yang ditawarkan perusahaan, mulai dari pengangkutan hingga konsultasi pengelolaan Limbah B3.',
  ],
  [
    'accent' => 'Trust',
    'title' => 'Trust',
    'text' => 'Kepercayaan dibangun melalui pengalaman operasional, kemitraan yang jelas, perlindungan asuransi, serta komitmen perusahaan terhadap standar kerja yang dapat dipertanggungjawabkan.',
  ],
] as $card)
                      <div class="rounded-[28px] bg-white p-6 shadow-sm ring-1 ring-neutral-200
                                  transition hover:-translate-y-0.5 hover:shadow-md">
                          <div class="mb-3 inline-flex rounded-full bg-yellow-50 px-3 py-1
                                      text-xs font-semibold uppercase tracking-[0.16em] text-yellow-700">
                              {{ $card['accent'] }}
                          </div>
                          <h2 class="text-xl font-bold">{{ $card['title'] }}</h2>
                          <p class="mt-3 text-sm leading-7 text-neutral-600">{{ $card['text'] }}</p>
                      </div>
                @endforeach
            </div>
        </section>

        {{-- Section: Layanan --}}
        <section class="rounded-[32px] bg-white px-7 py-8 shadow-sm ring-1 ring-neutral-200
                        md:px-10 md:py-10">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-red-600">
                        Layanan utama
                    </p>
                    <h3 class="mt-3 text-3xl font-black text-neutral-900 md:text-4xl">
                        Layanan yang dirancang untuk kebutuhan pengelolaan Limbah B3 yang lebih
                        tertib dan bertanggung jawab.
                    </h3>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-neutral-600">
                        Penyajian layanan dibuat dalam bentuk kartu agar lebih mudah dipahami oleh
                        calon klien, tanpa harus membaca uraian panjang seperti dalam company
                        profile konvensional.
                    </p>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ([
  [
    'title' => 'Transporter Limbah B3',
    'desc' => 'Menyediakan jasa pengangkutan Limbah B3 secara aman, tertib, dan profesional dari lokasi penghasil menuju fasilitas pengolahan atau pemusnahan yang berizin.',
  ],
  [
    'title' => 'Konsultasi Pengelolaan Limbah B3',
    'desc' => 'Memberikan pendampingan bagi perusahaan atau fasilitas kesehatan dalam menyusun pengelolaan limbah yang lebih efektif, efisien, dan sesuai regulasi.',
  ],
  [
    'title' => 'Pengolahan Limbah B3',
    'desc' => 'Mendukung kebutuhan pengolahan Limbah B3 melalui pendekatan yang tepat, bertanggung jawab, dan memperhatikan aspek keamanan serta lingkungan.',
  ],
] as $service)
                          <div class="rounded-[24px] bg-neutral-900 p-5 text-white">
                              <div class="mb-3 h-2 w-12 rounded-full bg-yellow-400"></div>
                              <h4 class="text-lg font-bold leading-6">{{ $service['title'] }}</h4>
                              <p class="mt-3 text-sm leading-7 text-neutral-300">{{ $service['desc'] }}</p>
                          </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- [REVISI 3] Trust + CTA — layout horizontal dalam 1 card besar --}}
        <section class="rounded-[32px] bg-white shadow-sm ring-1 ring-neutral-200 overflow-hidden">
            <div class="grid lg:grid-cols-[1fr_auto]">

                {{-- Trust --}}
                <div class="px-7 py-8 md:px-10 md:py-10">
                    <div class="mb-3 inline-flex rounded-full bg-yellow-50 px-3 py-1
                                text-xs font-semibold uppercase tracking-[0.16em] text-yellow-700">
                        Kepercayaan anda, sangat berharga
                    </div>
                    <h3 class="text-2xl font-black text-neutral-900">
                        Kepercayaan dibangun melalui pelayanan yang jelas, aman, dan bertanggung jawab.
                    </h3>
                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        @foreach ([
  [
    'title' => 'Kemitraan yang Jelas',
    'desc' => 'Kerja sama yang terstruktur sebagai dasar pelayanan agar setiap proses berjalan lebih tertib, kredibel, dan mudah ditindaklanjuti.',
  ],
  [
    'title' => 'Perlindungan Asuransi',
    'desc' => 'Jaminan asuransi memperkuat rasa aman klien terhadap risiko operasional dan tanggung jawab lingkungan.',
  ],
  [
    'title' => 'Pendekatan Profesional',
    'desc' => 'Setiap layanan dirancang mencerminkan profesionalisme, ketepatan proses, dan standar kerja yang serius.',
  ],
] as $point)
                              <div class="rounded-[20px] bg-neutral-50 p-5 ring-1 ring-neutral-200">
                                  <p class="text-base font-bold text-neutral-900">{{ $point['title'] }}</p>
                                  <p class="mt-2 text-sm leading-6 text-neutral-600">{{ $point['desc'] }}</p>
                              </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA --}}
                <div class="flex flex-col justify-center bg-gradient-to-b from-red-600 via-orange-500
                            to-yellow-400 px-8 py-8 text-white lg:w-72 lg:rounded-none
                            lg:bg-gradient-to-br">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-white/70">
                        Mulai sekarang
                    </p>
                    <h3 class="mt-3 text-2xl font-black leading-tight">
                        Mari bangun kerja sama yang profesional dan berkelanjutan.
                    </h3>
                    <p class="mt-3 text-sm leading-6 text-white/85">
                        PT. Mitra Mecca Abadi siap menjadi mitra pengangkutan Limbah B3 yang
                        membantu institusi Anda bekerja lebih tertib dan aman.
                    </p>
                    {{-- [REVISI 5] Tombol download company profile --}}
                    <a href="https://drive.google.com/file/d/1rX6s93eiHxfj5uBAnRU1Gr1iVHfEBqdL/view?usp=sharing"
   target="_blank"
   rel="noopener"
   class="mt-6 inline-flex items-center justify-center gap-2 rounded-xl bg-white/15 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur transition hover:bg-white/25">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
        <path fill-rule="evenodd"
            d="M12 2.25a.75.75 0 0 1 .75.75v11.69l3.22-3.22a.75.75 0 1 1 1.06 1.06l-4.5 4.5a.75.75 0 0 1-1.06 0l-4.5-4.5a.75.75 0 1 1 1.06-1.06l3.22 3.22V3a.75.75 0 0 1 .75-.75Zm-9 13.5a.75.75 0 0 1 .75.75v2.25a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5V16.5a.75.75 0 0 1 1.5 0v2.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V16.5a.75.75 0 0 1 .75-.75Z"
            clip-rule="evenodd" />
    </svg>
    Download Company Profile
</a>
                </div>

            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="border-t border-neutral-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4
                    text-sm text-neutral-500 md:px-10 lg:px-16">
            <p class="font-medium text-neutral-700">PT. Mitra Mecca Abadi</p>
            <p>made by <a href="https://kiiiii.netlify.app/" target="_blank" rel="noopener" class="font-bold">Taufiqurrahman</a></p>
        </div>
    </footer>

    {{-- [REVISI 4] WhatsApp FAB — pakai gambar --}}
    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
        aria-label="Hubungi via WhatsApp"
        class="fixed bottom-6 right-6 inline-flex h-14 w-14 items-center justify-center
               rounded-full shadow-2xl shadow-green-500/30 transition hover:scale-105">
        <img src="{{ asset('storage/gambar/whatsapp.png') }}"
            alt="WhatsApp"
            class="h-14 w-14 rounded-full object-cover">
    </a>

</body>
</html>