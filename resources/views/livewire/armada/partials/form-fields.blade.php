{{--
Partial reusable: field form Armada.
Dipakai oleh create.blade.php dan edit.blade.php.
Bergantung pada property Livewire:
- $kode_armada, $nomor_polisi, $jenis_kendaraan
- $kapasitas, $status
- $jenisOptions (array), $statusOptions (array assoc)
--}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Kode Armada --}}
    <div>
        <label for="kode_armada" class="block mb-1.5 text-sm font-medium text-gray-700">
            Kode Armada <span class="text-red-500">*</span>
        </label>
        <input type="text" id="kode_armada" wire:model="kode_armada" placeholder="Contoh: ARM-007" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500 uppercase
                   {{ $errors->has('kode_armada')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('kode_armada')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor Polisi --}}
    <div>
        <label for="nomor_polisi" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nomor Polisi <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nomor_polisi" wire:model="nomor_polisi" placeholder="Contoh: DD 1234 AB" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500 uppercase
                   {{ $errors->has('nomor_polisi')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nomor_polisi')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jenis Kendaraan --}}
    <div>
        <label for="jenis_kendaraan" class="block mb-1.5 text-sm font-medium text-gray-700">
            Jenis Kendaraan <span class="text-red-500">*</span>
        </label>
        <select id="jenis_kendaraan" wire:model="jenis_kendaraan" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('jenis_kendaraan')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
            <option value="">-- Pilih Jenis --</option>
            @foreach ($jenisOptions as $jenis)
            <option value="{{ $jenis }}">{{ $jenis }}</option>
            @endforeach
        </select>
        @error('jenis_kendaraan')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kapasitas --}}
    <div>
        <label for="kapasitas" class="block mb-1.5 text-sm font-medium text-gray-700">
            Kapasitas <span class="text-red-500">*</span>
        </label>
        <input type="text" id="kapasitas" wire:model="kapasitas" placeholder="Contoh: 5 ton" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('kapasitas')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('kapasitas')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Status --}}
    <div class="md:col-span-2">
        <label for="status" class="block mb-1.5 text-sm font-medium text-gray-700">
            Status <span class="text-red-500">*</span>
        </label>
        <select id="status" wire:model="status" class="w-full md:w-1/2 bg-gray-50 border text-sm rounded-lg px-3 py-2.5
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
