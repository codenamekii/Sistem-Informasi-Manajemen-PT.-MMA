<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nama_dokumen" class="block mb-2 text-sm font-medium text-gray-900">
                Nama Dokumen
            </label>
            <input type="text" id="nama_dokumen" wire:model.defer="form.nama_dokumen"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: Perjanjian Kerja Sama">
            @error('form.nama_dokumen')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="kategori_dokumen" class="block mb-2 text-sm font-medium text-gray-900">
                Kategori Dokumen
            </label>
            <select id="kategori_dokumen" wire:model.live="form.kategori_dokumen"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih kategori dokumen</option>
                <option value="perjanjian">Perjanjian</option>
                <option value="MoU">MoU</option>
                <option value="izin">Izin</option>
                <option value="legalitas">Legalitas</option>
                <option value="administrasi">Administrasi</option>
                <option value="lainnya">Lainnya</option>
            </select>
            @error('form.kategori_dokumen')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="nomor_referensi" class="block mb-2 text-sm font-medium text-gray-900">
                Nomor Referensi
            </label>
            <input type="text" id="nomor_referensi" wire:model.defer="form.nomor_referensi"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500"
                placeholder="Contoh: DOC-2026-001">
            @error('form.nomor_referensi')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        @if (in_array($form['kategori_dokumen'] ?? '', ['perjanjian', 'MoU'], true))
        <div>
            <label for="kerja_sama_id" class="block mb-2 text-sm font-medium text-gray-900">
                Terkait Kerja Sama
            </label>
            <select id="kerja_sama_id" wire:model.defer="form.kerja_sama_id"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Pilih kerja sama</option>
                @foreach ($this->kerjaSamaOptions as $kerjaSama)
                <option value="{{ $kerjaSama->id }}">
                    {{ $kerjaSama->nomor_perjanjian }} - {{ $kerjaSama->nama_fasilitas_display }}
                </option>
                @endforeach
            </select>
            @error('form.kerja_sama_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-xs text-gray-500">
                Field ini hanya muncul untuk kategori Perjanjian atau MoU.
            </p>
        </div>
        @endif

        <div>
            <label for="tanggal_berlaku_sampai" class="block mb-2 text-sm font-medium text-gray-900">
                Tanggal Berlaku Sampai
            </label>
            <input type="date" id="tanggal_berlaku_sampai" wire:model.defer="form.tanggal_berlaku_sampai"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500">
            @error('form.tanggal_berlaku_sampai')
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
                <option value="valid">Valid</option>
                <option value="expiring_soon">Segera Berakhir</option>
                <option value="expired">Expired</option>
                <option value="missing">Missing</option>
            </select>
            @error('form.status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>