<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">
                Nama Fasilitas Kesehatan
            </label>
            <input type="text" id="nama" wire:model.defer="form.nama"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: RSUD Makassar">
            @error('form.nama')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="jenis_fasilitas" class="block mb-2 text-sm font-medium text-gray-900">
                Jenis Fasilitas
            </label>
            <select id="jenis_fasilitas" wire:model.defer="form.jenis_fasilitas"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih jenis fasilitas</option>
                <option value="Rumah Sakit">Rumah Sakit</option>
                <option value="Klinik">Klinik</option>
                <option value="Puskesmas">Puskesmas</option>
                <option value="Laboratorium">Laboratorium</option>
                <option value="Apotek">Apotek</option>
                <option value="Lainnya">Lainnya</option>
            </select>
            @error('form.jenis_fasilitas')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kota_kabupaten" class="block mb-2 text-sm font-medium text-gray-900">
                Kota/Kabupaten
            </label>
            <input type="text" id="kota_kabupaten" wire:model.defer="form.kota_kabupaten"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: Makassar">
            @error('form.kota_kabupaten')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="provinsi" class="block mb-2 text-sm font-medium text-gray-900">
                Provinsi
            </label>
            <input type="text" id="provinsi" wire:model.defer="form.provinsi"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: Sulawesi Selatan">
            @error('form.provinsi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
                Status Prospek
            </label>
            <select id="status" wire:model.defer="form.status"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih status prospek</option>
                <option value="prospect">Prospek</option>
                <option value="active">Aktif</option>
                <option value="inactive">Non-aktif</option>
            </select>
            @error('form.status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status_penawaran" class="block mb-2 text-sm font-medium text-gray-900">
                Status Penawaran
            </label>
            <select id="status_penawaran" wire:model.defer="form.status_penawaran"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="belum_masuk_penawaran">Belum Masuk Penawaran</option>
                <option value="masuk_penawaran">Masuk Penawaran</option>
            </select>
            @error('form.status_penawaran')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="pic_nama" class="block mb-2 text-sm font-medium text-gray-900">
                Nama PIC
            </label>
            <input type="text" id="pic_nama" wire:model.defer="form.pic_nama"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Opsional">
            @error('form.pic_nama')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="pic_nomor_telepon" class="block mb-2 text-sm font-medium text-gray-900">
                Nomor Telepon PIC
            </label>
            <input type="text" id="pic_nomor_telepon" wire:model.defer="form.pic_nomor_telepon"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Opsional">
            @error('form.pic_nomor_telepon')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="kendala" class="block mb-2 text-sm font-medium text-gray-900">
            Kendala
        </label>
        <textarea id="kendala" rows="4" wire:model.defer="form.kendala"
            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
            placeholder="Opsional"></textarea>
        @error('form.kendala')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>