<div>
  <x-alert type="success" :message="session('success')" />

  <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-6">
    <x-page-header title="Ubah Password" description="Ganti password akun Anda untuk menjaga keamanan akses sistem."
      class="mb-0" />

    <div class="shrink-0">
      <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-medium
                       text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50
                       focus:ring-4 focus:ring-gray-200 transition-colors duration-200">
        Kembali
      </a>
    </div>
  </div>

  <div class="bg-white border border-gray-200 rounded-xl shadow-sm">
    <div class="px-6 py-4 border-b border-gray-100">
      <h3 class="text-sm font-semibold text-gray-700">Form Ubah Password</h3>
      <p class="text-xs text-gray-400 mt-0.5">
        Gunakan password yang kuat dan mudah Anda ingat.
      </p>
    </div>

    <form wire:submit.prevent="save" class="px-6 py-6 space-y-5">
      <div>
        <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900">
          Password Saat Ini <span class="text-red-500">*</span>
        </label>
        <input type="password" id="current_password" wire:model.defer="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                           @error('current_password', 'updatePassword') border-red-500 @enderror"
          placeholder="Masukkan password saat ini" />
        @error('current_password', 'updatePassword')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
          Password Baru <span class="text-red-500">*</span>
        </label>
        <input type="password" id="password" wire:model.defer="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                           @error('password', 'updatePassword') border-red-500 @enderror"
          placeholder="Masukkan password baru" />
        @error('password', 'updatePassword')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
          Konfirmasi Password Baru <span class="text-red-500">*</span>
        </label>
        <input type="password" id="password_confirmation" wire:model.defer="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                           @error('password_confirmation', 'updatePassword') border-red-500 @enderror"
          placeholder="Ulangi password baru" />
        @error('password_confirmation', 'updatePassword')
          <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <div class="pt-3 border-t border-gray-100 flex items-center justify-end gap-3">
        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300
                           rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200
                           transition-colors duration-200">
          Batal
        </a>

        <button type="submit" wire:loading.attr="disabled" wire:target="save" class="px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg
                           hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                           transition-colors duration-200 disabled:opacity-60">
          <span wire:loading.remove wire:target="save">Simpan Password</span>
          <span wire:loading wire:target="save">Menyimpan...</span>
        </button>
      </div>
    </form>
  </div>
</div>