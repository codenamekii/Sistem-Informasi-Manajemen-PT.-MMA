<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\FasilitasKesehatan\Index  as FasilitasIndex;
use App\Livewire\FasilitasKesehatan\Create as FasilitasCreate;
use App\Livewire\FasilitasKesehatan\Show   as FasilitasShow;
use App\Livewire\FasilitasKesehatan\Edit   as FasilitasEdit;
use App\Livewire\KerjaSama\Index           as KerjaSamaIndex;
use App\Livewire\KerjaSama\Create          as KerjaSamaCreate;
use App\Livewire\KerjaSama\Show            as KerjaSamaShow;
use App\Livewire\KerjaSama\Edit            as KerjaSamaEdit;
use App\Livewire\Dokumen\Index             as DokumenIndex;
use App\Livewire\Dokumen\Create            as DokumenCreate;
use App\Livewire\Dokumen\Show              as DokumenShow;
use App\Livewire\Dokumen\Edit              as DokumenEdit;
use App\Livewire\Armada\Index              as ArmadaIndex;
use App\Livewire\Armada\Create             as ArmadaCreate;
use App\Livewire\Armada\Show               as ArmadaShow;
use App\Livewire\Armada\Edit               as ArmadaEdit;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Fasilitas Kesehatan
    Route::get('/fasilitas-kesehatan', FasilitasIndex::class)
        ->name('fasilitas-kesehatan.index');
    Route::get('/fasilitas-kesehatan/create', FasilitasCreate::class)
        ->name('fasilitas-kesehatan.create');
    Route::get('/fasilitas-kesehatan/{fasilitasKesehatan}', FasilitasShow::class)
        ->name('fasilitas-kesehatan.show');
    Route::get('/fasilitas-kesehatan/{fasilitasKesehatan}/edit', FasilitasEdit::class)
        ->name('fasilitas-kesehatan.edit');

    // Kerja Sama
    Route::get('/kerja-sama', KerjaSamaIndex::class)
        ->name('kerja-sama.index');
    Route::get('/kerja-sama/create', KerjaSamaCreate::class)
        ->name('kerja-sama.create');
    Route::get('/kerja-sama/{kerjaSama}', KerjaSamaShow::class)
        ->name('kerja-sama.show');
    Route::get('/kerja-sama/{kerjaSama}/edit', KerjaSamaEdit::class)
        ->name('kerja-sama.edit');

    // Dokumen
    Route::get('/dokumen', DokumenIndex::class)
        ->name('dokumen.index');
    Route::get('/dokumen/create', DokumenCreate::class)
        ->name('dokumen.create');
    Route::get('/dokumen/{dokumen}', DokumenShow::class)
        ->name('dokumen.show');
    Route::get('/dokumen/{dokumen}/edit', DokumenEdit::class)
        ->name('dokumen.edit');

    // Armada
    Route::get('/armada', ArmadaIndex::class)
        ->name('armada.index');
    Route::get('/armada/create', ArmadaCreate::class)
        ->name('armada.create');
    Route::get('/armada/{armada}', ArmadaShow::class)
        ->name('armada.show');
    Route::get('/armada/{armada}/edit', ArmadaEdit::class)
        ->name('armada.edit');
});
