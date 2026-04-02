@extends('layouts.app')

@section('pageTitle', 'Dashboard')

@section('content')

<x-page-header title="Selamat datang, {{ auth()->user()->name }}"
    description="{{ now()->locale('id')->translatedFormat('l, d F Y') }} — Ringkasan operasional PT. Mitra Mecca Abadi" />

{{-- Summary Cards --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <x-stat-card title="Fasilitas Kesehatan" description="4 ditambahkan bulan ini" color="blue">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Kerja Sama Aktif" color="green">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                   a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Jadwal Bulan Ini" color="yellow">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0
                                   00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

    <x-stat-card title="Armada Tersedia" color="purple">
        <x-slot:icon>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
            </svg>
        </x-slot:icon>
    </x-stat-card>

</div>

{{-- Aktivitas Terbaru --}}
<div class="bg-white rounded-lg border border-gray-200 shadow-sm">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
        <h3 class="text-sm font-semibold text-gray-700">Aktivitas Terbaru</h3>
        <span class="text-xs text-gray-400">Sistem baru diinisialisasi</span>
    </div>
    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
        <div class="flex items-center justify-center w-12 h-12 bg-gray-100 rounded-full mb-4">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0
                                   00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
        </div>
        <p class="text-sm font-medium text-gray-500">Belum ada aktivitas tercatat</p>
        <p class="text-xs text-gray-400 mt-1">
            Aktivitas akan muncul setelah modul operasional diaktifkan
        </p>
    </div>
</div>

@endsection
