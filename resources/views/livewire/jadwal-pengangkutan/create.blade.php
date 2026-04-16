<div>
  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
    <x-page-header title="Tambah Jadwal Pengangkutan" description="Buat jadwal pengangkutan baru" class="mb-0" />
    <div class="shrink-0">
      <a href="{{ route('jadwal-pengangkutan.index') }}"
        class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
        Kembali
      </a>
    </div>
  </div>

  @if (session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 border border-green-200">
      {{ session('success') }}
    </div>
  @endif

  <form wire:submit="save" enctype="multipart/form-data">
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 space-y-6">

      <div>
        <label for="kode_jadwal" class="block mb-2 text-sm font-medium text-gray-900">
          Kode Jadwal <span class="text-red-500">*</span>
        </label>
        <input type="text" id="kode_jadwal" wire:model="kode_jadwal"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('kode_jadwal') border-red-500 @enderror"
          placeholder="Kode jadwal" />
        @error('kode_jadwal')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="tanggal_pengangkutan" class="block mb-2 text-sm font-medium text-gray-900">
          Tanggal Pengangkutan <span class="text-red-500">*</span>
        </label>
        <input type="date" id="tanggal_pengangkutan" wire:model="tanggal_pengangkutan"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tanggal_pengangkutan') border-red-500 @enderror" />
        @error('tanggal_pengangkutan')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="kerja_sama_id" class="block mb-2 text-sm font-medium text-gray-900">
          Kerja Sama <span class="text-red-500">*</span>
        </label>
        <select id="kerja_sama_id" wire:model="kerja_sama_id"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('kerja_sama_id') border-red-500 @enderror">
          <option value="">— Pilih Kerja Sama —</option>
          @foreach ($this->kerjaSamaOptions as $ks)
            <option value="{{ $ks->id }}">
              {{ $ks->nomor_perjanjian }} — {{ $ks->nama_fasilitas_display }}
            </option>
          @endforeach
        </select>
        @error('kerja_sama_id')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="armada_id" class="block mb-2 text-sm font-medium text-gray-900">
          Armada <span class="text-red-500">*</span>
        </label>
        <select id="armada_id" wire:model="armada_id"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('armada_id') border-red-500 @enderror">
          <option value="">— Pilih Armada —</option>
          @foreach ($this->armadaOptions as $arm)
            <option value="{{ $arm->id }}">
              {{ $arm->nomor_polisi }} — {{ $arm->jenis_kendaraan }}
              @if($arm->kapasitas)
                ({{ $arm->kapasitas }} kg)
              @endif
            </option>
          @endforeach
        </select>
        @error('armada_id')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block mb-2 text-sm font-medium text-gray-900">
          Petugas <span class="text-red-500">*</span>
          <span class="text-gray-500 font-normal">(pilih minimal 1)</span>
        </label>
        @error('petugas_ids')
          <p class="mb-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <div class="border border-gray-300 rounded-lg divide-y divide-gray-100 max-h-56 overflow-y-auto">
          @forelse ($this->petugasOptions as $p)
            <label class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 cursor-pointer">
              <input type="checkbox" wire:model="petugas_ids" value="{{ $p->id }}"
                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
              <span class="text-sm text-gray-900">{{ $p->nama_petugas }}</span>
              @if($p->jabatan)
                <span class="text-xs text-gray-500">{{ $p->jabatan }}</span>
              @endif
            </label>
          @empty
            <p class="px-4 py-3 text-sm text-gray-500">Belum ada petugas tersedia.</p>
          @endforelse
        </div>
      </div>

      <div>
        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">
          Status <span class="text-red-500">*</span>
        </label>
        <select id="status" wire:model.live="status"
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('status') border-red-500 @enderror">
          <option value="draft">Draft</option>
          <option value="scheduled">Terjadwal</option>
          <option value="in_progress">Berlangsung</option>
          <option value="completed">Selesai</option>
          <option value="cancelled">Dibatalkan</option>
        </select>
        @error('status')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      @if ($status === 'completed')
        <div class="border border-green-200 bg-green-50 rounded-xl p-5 space-y-5">
          <h4 class="text-sm font-semibold text-green-800">
            Bukti Penyelesaian Pengangkutan
          </h4>

          <div>
            <label for="tanggal_realisasi" class="block mb-2 text-sm font-medium text-gray-900">
              Tanggal Realisasi <span class="text-red-500">*</span>
            </label>
            <input type="date" id="tanggal_realisasi" wire:model="tanggal_realisasi"
              class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tanggal_realisasi') border-red-500 @enderror" />
            @error('tanggal_realisasi')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="total_limbah_kg" class="block mb-2 text-sm font-medium text-gray-900">
              Total Limbah Diangkut (Kg) <span class="text-red-500">*</span>
            </label>
            <input type="number" id="total_limbah_kg" wire:model="total_limbah_kg" step="0.01" min="0.01"
              placeholder="Contoh: 125.50"
              class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('total_limbah_kg') border-red-500 @enderror" />
            <p class="mt-1 text-xs text-gray-500">
              Masukkan total limbah medis yang benar-benar diangkut pada realisasi ini.
            </p>
            @error('total_limbah_kg')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="manifest_elektronik" class="block mb-2 text-sm font-medium text-gray-900">
              Manifest Elektronik <span class="text-red-500">*</span>
              <span class="text-gray-500 font-normal">(PDF, maks. 10 MB)</span>
            </label>
            <input type="file" id="manifest_elektronik" wire:model="manifest_elektronik" accept=".pdf"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none p-2 @error('manifest_elektronik') border-red-500 @enderror" />
            <div wire:loading wire:target="manifest_elektronik" class="mt-1 text-xs text-blue-600">
              Mengunggah...
            </div>
            @error('manifest_elektronik')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="bukti_foto_pengangkutan" class="block mb-2 text-sm font-medium text-gray-900">
              Bukti Foto Pengangkutan <span class="text-red-500">*</span>
              <span class="text-gray-500 font-normal">(JPG/PNG, maks. 10 MB)</span>
            </label>
            <input type="file" id="bukti_foto_pengangkutan" wire:model="bukti_foto_pengangkutan" accept=".jpg,.jpeg,.png"
              class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none p-2 @error('bukti_foto_pengangkutan') border-red-500 @enderror" />
            <div wire:loading wire:target="bukti_foto_pengangkutan" class="mt-1 text-xs text-blue-600">
              Mengunggah...
            </div>
            @error('bukti_foto_pengangkutan')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>
      @endif

    </div>

    <div class="flex items-center justify-end gap-3 mt-6">
      <a href="{{ route('jadwal-pengangkutan.index') }}"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
        Batal
      </a>
      <button type="submit" wire:loading.attr="disabled" wire:target="save"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-colors duration-200 disabled:opacity-60">
        <span wire:loading.remove wire:target="save">Simpan</span>
        <span wire:loading wire:target="save">Menyimpan...</span>
      </button>
    </div>
  </form>
</div>