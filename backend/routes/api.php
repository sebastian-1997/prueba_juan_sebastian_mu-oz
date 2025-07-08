<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RickAndMortyController;
use App\Http\Controllers\ImportarController;
use App\Http\Controllers\ReporteController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/importar', [ImportarController::class, 'importar']);
Route::post('/importar/personaje', [ImportarController::class, 'importarPorId']);
Route::get('/personajes', [ReporteController::class, 'buscar']);
Route::get('/reportes/personajes', [ReporteController::class, 'personajesOrdenados']);
Route::get('/reportes/episodios', [ReporteController::class, 'personajesPorEpisodio']);
Route::get('/reportes/locaciones', [ReporteController::class, 'personajesPorLocacion']);
Route::get('/reportes/personajes-por-episodio', [ReporteController::class, 'personajesEnEpisodio']);
Route::get('/locaciones', function () {return \App\Models\Locacion::select('id', 'nombre')->get();});
Route::get('/locaciones', [ReporteController::class, 'listarLocaciones']);
Route::get('/reportes/personajes-por-locacion', [ReporteController::class, 'filtrarPorLocacion']);



// Ruta de prueba sin autenticación
Route::get('/saludo', function () {
    return response()->json([
        'mensaje' => 'Hola desde Laravel'
    ]);
});
