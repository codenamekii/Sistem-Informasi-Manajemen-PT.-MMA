{{--
    Partial reusable: field form Fasilitas Kesehatan.
    Dipakai oleh create.blade.php dan edit.blade.php.
    Bergantung pada property Livewire:
      - $nama, $jenis_fasilitas, $kota_kabupaten, $status
      - $jenisOptions (array), $statusOptions (array assoc)
--}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

  {{-- Nama --}}
  <div class="md:col-span-2">
    <label for="nama" class="block mb-1.5 text-sm font-medium text-gray-700">
      Nama Fasilitas <span class="text-red-500">*</span>
    </label>
    <input type="text" id="nama" wire:model="nama" placeholder="Contoh: RSUD Dr. Wahidin Sudirohusodo"
      class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nama') ? 'border-red-500 bg-red-50' : 'border-gray-300 text-gray-900' }}">
    @error('nama')
      <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror
  </div>

  {{-- Jenis Fasilitas --}}
  <div>
    <label for="jenis_fasilitas" class="block mb-1.5 text-sm font-medium text-gray-700">
      Jenis Fasilitas <span class="text-red-500">*</span>
    </label>
    <select id="jenis_fasilitas" wire:model="jenis_fasilitas"
      class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('jenis_fasilitas') ? 'border-red-500 bg-red-50' : 'border-gray-300 text-gray-900' }}">
      <option value="">-- Pilih Jenis --</option>
      @foreach ($jenisOptions as $jenis)
        <option value="{{ $jenis }}">{{ $jenis }}</option>
      @endforeach
    </select>
    @error('jenis_fasilitas')
      <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror
  </div>

  {{-- Kota / Kabupaten --}}
  <div>
    <label for="kota_kabupaten" class="block mb-1.5 text-sm font-medium text-gray-700">
      Kota / Kabupaten <span class="text-red-500">*</span>
    </label>
    <input type="text" id="kota_kabupaten" wire:model="kota_kabupaten" placeholder="Contoh: Makassar"
      class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('kota_kabupaten') ? 'border-red-500 bg-red-50' : 'border-gray-300 text-gray-900' }}">
    @error('kota_kabupaten')
      <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror
  </div>

  {{-- Status --}}
  <div>
    <label for="status" class="block mb-1.5 text-sm font-medium text-gray-700">
      Status <span class="text-red-500">*</span>
    </label>
    <select id="status" wire:model="status"
      class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('status') ? 'border-red-500 bg-red-50' : 'border-gray-300 text-gray-900' }}">
      @foreach ($statusOptions as $value => $label)
        <option value="{{ $value }}">{{ $label }}</option>
      @endforeach
    </select>
    @error('status')
      <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
    @enderror
  </div>

</div>
