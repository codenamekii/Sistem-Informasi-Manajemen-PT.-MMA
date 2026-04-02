@props(['title', 'value' => '—', 'description' => 'Belum ada data', 'color' => 'blue'])

@php
  $colorMap = [
      'blue' => ['bg' => 'bg-blue-100', 'icon' => 'text-blue-700'],
      'green' => ['bg' => 'bg-green-100', 'icon' => 'text-green-700'],
      'yellow' => ['bg' => 'bg-yellow-100', 'icon' => 'text-yellow-600'],
      'purple' => ['bg' => 'bg-purple-100', 'icon' => 'text-purple-700'],
      'red' => ['bg' => 'bg-red-100', 'icon' => 'text-red-700'],
  ];

  $colors = $colorMap[$color] ?? $colorMap['blue'];
@endphp

<div class="bg-white rounded-lg border border-gray-200 shadow-sm p-5">
  <div class="flex items-center justify-between mb-3">
    <span class="text-sm font-medium text-gray-500">{{ $title }}</span>
    <div class="flex items-center justify-center w-9 h-9 rounded-lg {{ $colors['bg'] }}">
      <div class="{{ $colors['icon'] }}">
        {{ $icon ?? '' }}
      </div>
    </div>
  </div>
  <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
  <p class="text-xs text-gray-400 mt-1">{{ $description }}</p>
</div>
