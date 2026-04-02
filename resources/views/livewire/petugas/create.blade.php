<div>

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <x-page-header title="Tambah Petugas" description="Isi form berikut untuk menambahkan petugas baru."
            class="mb-0" />
        <a href="{{ route('petugas.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-600
                  bg-white border border-gray-300 rounded-lg hover:bg-gray-50
                  focus:ring-4 focus:ring-gray-200 transition-colors duration-200 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg border border-gray-200 shadow-sm">

        <div class="px-5 py-4 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-700">Informasi Petugas</h3>
            <p class="text-xs text-gray-400 mt-0.5">
                Field bertanda <span class="text-red-500">*</span> wajib diisi.
            </p>
        </div>

        <form wire:submit="save" class="px-5 py-6">

            @include('livewire.petugas.partials.form-fields')

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 mt-8 pt-5
                        border-t border-gray-100">
                <a href="{{ route('petugas.index') }}" class="w-full sm:w-auto text-center px-5 py-2.5 text-sm font-medium
                          text-gray-600 bg-white border border-gray-300 rounded-lg
                          hover:bg-gray-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:loading.class="opacity-60 cursor-not-allowed"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                           px-5 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg
                           hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                           transition-colors duration-200">
                    <svg wire:loading wire:target="save" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
                    </svg>
                    Simpan Petugas
                </button>
            </div>

        </form>

    </div>

</div>