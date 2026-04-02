@props(['title', 'description' => null])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
  <h2 class="text-xl font-bold text-gray-800">
    {{ $title }}
  </h2>
  @if ($description)
    <p class="text-sm text-gray-500 mt-1">
      {{ $description }}
    </p>
  @endif
</div>
