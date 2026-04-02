{{--
Partial reusable: field form Kerja Sama.
Dipakai oleh create.blade.php dan edit.blade.php.
Bergantung pada property Livewire:
- $nomor_perjanjian, $nama_fasilitas_kesehatan
- $tanggal_mulai, $tanggal_berakhir, $status
- $statusOptions (array assoc)
--}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Nomor Perjanjian --}}
    <div class="md:col-span-2">
        <label for="nomor_perjanjian" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nomor Perjanjian <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nomor_perjanjian" wire:model="nomor_perjanjian" placeholder="Contoh: PKS/MMA/2025/001"
            class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nomor_perjanjian')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nomor_perjanjian')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nama Fasilitas Kesehatan --}}
    <div class="md:col-span-2">
        <label for="nama_fasilitas_kesehatan" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nama Fasilitas Kesehatan <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_fasilitas_kesehatan" wire:model="nama_fasilitas_kesehatan"
            placeholder="Contoh: RSUD Dr. Wahidin Sudirohusodo" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nama_fasilitas_kesehatan')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nama_fasilitas_kesehatan')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Mulai --}}
    <div>
        <label for="tanggal_mulai" class="block mb-1.5 text-sm font-medium text-gray-700">
            Tanggal Mulai <span class="text-red-500">*</span>
        </label>
        <input type="date" id="tanggal_mulai" wire:model="tanggal_mulai" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('tanggal_mulai')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('tanggal_mulai')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Berakhir --}}
    <div>
        <label for="tanggal_berakhir" class="block mb-1.5 text-sm font-medium text-gray-700">
            Tanggal Berakhir <span class="text-red-500">*</span>
        </label>
        <input type="date" id="tanggal_berakhir" wire:model="tanggal_berakhir" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('tanggal_berakhir')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('tanggal_berakhir')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div>
        <label for="status" class="block mb-1.5 text-sm font-medium text-gray-700">
            Status <span class="text-red-500">*</span>
        </label>
        <select id="status" wire:model="status" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('status')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
            @foreach ($statusOptions as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
            @endforeach
        </select>
        @error('status')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

</div>
