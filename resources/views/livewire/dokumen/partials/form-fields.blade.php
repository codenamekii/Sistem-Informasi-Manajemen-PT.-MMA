{{--
Partial reusable: field form Dokumen.
Dipakai oleh create.blade.php dan edit.blade.php.
Bergantung pada property Livewire:
- $nama_dokumen, $kategori_dokumen, $nomor_referensi
- $terkait_dengan, $tanggal_berlaku_sampai, $status
- $kategoriOptions (array), $statusOptions (array assoc)
--}}

<div class="grid grid-cols-1 md:grid-cols-2 gap-5">

    {{-- Nama Dokumen --}}
    <div class="md:col-span-2">
        <label for="nama_dokumen" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nama Dokumen <span class="text-red-500">*</span>
        </label>
        <input type="text" id="nama_dokumen" wire:model="nama_dokumen"
            placeholder="Contoh: Perjanjian Kerja Sama Pengelolaan Limbah" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nama_dokumen')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nama_dokumen')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Kategori Dokumen --}}
    <div>
        <label for="kategori_dokumen" class="block mb-1.5 text-sm font-medium text-gray-700">
            Kategori <span class="text-red-500">*</span>
        </label>
        <select id="kategori_dokumen" wire:model="kategori_dokumen" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('kategori_dokumen')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
            <option value="">-- Pilih Kategori --</option>
            @foreach ($kategoriOptions as $kat)
            <option value="{{ $kat }}">{{ $kat }}</option>
            @endforeach
        </select>
        @error('kategori_dokumen')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Nomor Referensi --}}
    <div>
        <label for="nomor_referensi" class="block mb-1.5 text-sm font-medium text-gray-700">
            Nomor Referensi
            <span class="text-gray-400 font-normal">(opsional)</span>
        </label>
        <input type="text" id="nomor_referensi" wire:model="nomor_referensi" placeholder="Contoh: PKS/MMA/2025/001"
            class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('nomor_referensi')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('nomor_referensi')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Terkait Dengan --}}
    <div class="md:col-span-2">
        <label for="terkait_dengan" class="block mb-1.5 text-sm font-medium text-gray-700">
            Terkait Dengan <span class="text-red-500">*</span>
        </label>
        <input type="text" id="terkait_dengan" wire:model="terkait_dengan"
            placeholder="Contoh: RSUD Dr. Wahidin Sudirohusodo atau PT. Mitra Mecca Abadi" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('terkait_dengan')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('terkait_dengan')
        <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Tanggal Berlaku Sampai --}}
    <div>
        <label for="tanggal_berlaku_sampai" class="block mb-1.5 text-sm font-medium text-gray-700">
            Berlaku Sampai
            <span class="text-gray-400 font-normal">(opsional)</span>
        </label>
        <input type="date" id="tanggal_berlaku_sampai" wire:model="tanggal_berlaku_sampai" class="w-full bg-gray-50 border text-sm rounded-lg px-3 py-2.5
                   focus:ring-blue-500 focus:border-blue-500
                   {{ $errors->has('tanggal_berlaku_sampai')
                      ? 'border-red-500 bg-red-50'
                      : 'border-gray-300 text-gray-900' }}">
        @error('tanggal_berlaku_sampai')
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
