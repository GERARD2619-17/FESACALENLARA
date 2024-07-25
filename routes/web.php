<?php

use App\Http\Controllers\PartidoController;
use Illuminate\Support\Facades\Route;


Route::get('partidos', [PartidoController::class, 'index'])->name('partidos.index');

Route::get('partidos/cardview', [PartidoController::class, 'cardview'])->name('partidos.cardview');

Route::get('partidos/create', [PartidoController::class, 'create'])->name('partidos.create');

Route::post('partidos', [PartidoController::class, 'store'])->name('partidos.store');

Route::delete('partidos/{id}', [PartidoController::class, 'destroy'])->name('partidos.destroy');

Route::get('partidos/calendar', [PartidoController::class, 'calendar'])->name('partidos.calendar');

Route::get('/partidos/{partido}', [PartidoController::class, 'show'])->name('partidos.show');

Route::get('partidos/events', [PartidoController::class, 'events'])->name('partidos.events');


/*Route::get('/', function () {
    return view('welcome');
});*/
