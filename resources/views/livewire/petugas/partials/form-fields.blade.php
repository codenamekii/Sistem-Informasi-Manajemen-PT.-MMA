{{--
Partial reusable: field form Petugas.
Dipakai oleh create.blade.php dan edit.blade.php.
Bergantung pada property Livewire:
- $nama_petugas, $jabatan, $nomor_telepon
- $wilayah_tugas, $status
- $jabatanOptions (array), $statusOptions (array assoc)
--}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Nama Petugas --}}
    <div class="md:col-span-2">
        <label for="nama_petugas" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nama Petugas <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_petugas" wire:model="nama_petugas" placeholder="Contoh: Ahmad Fauzi" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nama_petugas')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nama_petugas')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Jabatan --}}
    <div>
        <label for="jabatan" class="block mb-1.5 text-sm font-medium text-gray-700">
            Jabatan <span class="text-red-500">*</span>
        </label>
        <select id="jabatan" wire:model="jabatan" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('jabatan')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
            <option value="">-- Pilih Jabatan --</option>
            @foreach ($jabatanOptions as $jab)
            <option value="{{ $jab }}">{{ $jab }}</option>
            @endforeach
        </select>
        @error('jabatan')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor Telepon --}}
    <div>
        <label for="nomor_telepon" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nomor Telepon <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nomor_telepon" wire:model="nomor_telepon" placeholder="Contoh: 0812-3456-7890" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nomor_telepon')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nomor_telepon')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Wilayah Tugas --}}
    <div>
        <label for="wilayah_tugas" class="block mb-1.5 text-sm font-medium text-gray-700">
            Wilayah Tugas <span class="text-red-500">*</span>
        </label>
        <input type="text" id="wilayah_tugas" wire:model="wilayah_tugas" placeholder="Contoh: Makassar Utara" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('wilayah_tugas')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('wilayah_tugas')
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