<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nomor_perjanjian" class="block mb-2 text-sm font-medium text-gray-900">
                Nomor Perjanjian
            </label>
            <input type="text" id="nomor_perjanjian" wire:model.defer="form.nomor_perjanjian"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: PKS-2026-001">
            @error('form.nomor_perjanjian')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="fasilitas_kesehatan_id" class="block mb-2 text-sm font-medium text-gray-900">
                Fasilitas Kesehatan
            </label>
            <select id="fasilitas_kesehatan_id" wire:model.defer="form.fasilitas_kesehatan_id"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih fasilitas kesehatan</option>
                @foreach ($this->fasilitasOptions as $fasilitas)
                <option value="{{ $fasilitas->id }}">{{ $fasilitas->nama }}</option>
                @endforeach
            </select>
            @error('form.fasilitas_kesehatan_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="harga_per_kilogram" class="block mb-2 text-sm font-medium text-gray-900">
                Harga per Kilogram
            </label>
            <input type="number" step="0.01" min="0" id="harga_per_kilogram" wire:model.defer="form.harga_per_kilogram"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: 12500">
            @error('form.harga_per_kilogram')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                Status
            </label>
            <select id="status" wire:model.defer="form.status"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih status</option>
                <option value="draft">Draft</option>
                <option value="active">Aktif</option>
                <option value="expired">Expired</option>
                <option value="terminated">Terminated</option>
            </select>
            @error('form.status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tanggal_mulai" class="block mb-2 text-sm font-medium text-gray-900">
                Tanggal Mulai
            </label>
            <input type="date" id="tanggal_mulai" wire:model.defer="form.tanggal_mulai"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
            @error('form.tanggal_mulai')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tanggal_berakhir" class="block mb-2 text-sm font-medium text-gray-900">
                Tanggal Berakhir
            </label>
            <input type="date" id="tanggal_berakhir" wire:model.defer="form.tanggal_berakhir"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
            @error('form.tanggal_berakhir')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>