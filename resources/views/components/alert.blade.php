@props([
    'type' => 'success',
    'message' => null,
])

@if ($message)
  @php
    $styles = match ($type) {
        'success' => [
            'wrapper' => 'bg-green-50 border border-green-200 text-green-800',
            'icon' => 'text-green-500',
            'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'wrapper' => 'bg-red-50 border border-red-200 text-red-800',
            'icon' => 'text-red-500',
            'path' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'warning' => [
            'wrapper' => 'bg-yellow-50 border border-yellow-200 text-yellow-800',
            'icon' => 'text-yellow-500',
            'path' => 'M12 9v2m0 4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z',
        ],
        'info' => [
            'wrapper' => 'bg-blue-50 border border-blue-200 text-blue-800',
            'icon' => 'text-blue-500',
            'path' => 'M13 16h-1v-4h-1m1-4h.01M12 3a9 9 0 100 18A9 9 0 0012 3z',
        ],
        default => [
            'wrapper' => 'bg-green-50 border border-green-200 text-green-800',
            'icon' => 'text-green-500',
            'path' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    };
  @endphp

  <div x-data="{ show: true }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2" x-init="setTimeout(() => show = false, 4000)"
    {{ $attributes->merge(['class' => 'flex items-start gap-3 p-4 mb-5 rounded-lg text-sm ' . $styles['wrapper']]) }}
    role="alert">
    <svg class="w-5 h-5 shrink-0 mt-0.5 {{ $styles['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $styles['path'] }}" />
    </svg>
    <span class="flex-1">{{ $message }}</span>
    <button type="button" @click="show = false"
      class="shrink-0 opacity-60 hover:opacity-100 transition-opacity duration-150">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>
@endif
