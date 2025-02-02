<?php

use App\Http\Controllers\PartidoController;
use Illuminate\Support\Facades\Route;


Route::get('partidos', [PartidoController::class, 'index'])->name('partidos.index');
Route::get('partidos/cardview', [PartidoController::class, 'cardview'])->name('partidos.cardview');
Route::get('partidos/create', [PartidoController::class, 'create'])->name('partidos.create');
Route::post('partidos', [PartidoController::class, 'store'])->name('partidos.store');
Route::get('partidos/{id}', [PartidoController::class, 'show'])->name('partidos.show');
Route::get('partidos/{id}/edit', [PartidoController::class, 'edit'])->name('partidos.edit');
Route::put('partidos/{id}', [PartidoController::class, 'update'])->name('partidos.update');
Route::delete('partidos/{id}', [PartidoController::class, 'destroy'])->name('partidos.destroy');
Route::get('partidos/calendar', [PartidoController::class, 'calendar'])->name('partidos.calendar');
Route::get('partidos/{id}/paneljuego', [PartidoController::class, 'paneljuego'])->name('partidos.paneljuego');
Route::post('partidos/{id}/actualizar-marcador', [PartidoController::class, 'actualizarMarcador'])->name('partidos.actualizarMarcador');
Route::post('partidos/{id}/actualizar-tiempo', [PartidoController::class, 'actualizarTiempo'])->name('partidos.actualizarTiempo');
Route::post('/partidos/{partido}/actualizar-estado', [PartidoController::class, 'actualizarEstado'])->name('partidos.actualizarEstado');
Route::post('partidos/{id}/actualizar-tarjetas', [PartidoController::class, 'actualizarTarjetas'])->name('partidos.actualizarTarjetas');
Route::post('partidos/{id}/asignar-penal', [PartidoController::class, 'asignarPenal'])->name('partidos.asignarPenal');

// Nueva ruta para obtener la lista de partidos actualizada
Route::get('/partidos/lista', [PartidoController::class, 'lista'])->name('partidos.lista');


/*Route::get('/', function () {
    return view('welcome');
});*/
