<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RoleController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// rutas categorias
Route::get('/categoria/reporte-pdf', [CategoriaController::class, "funReportePDF"]);

Route::get('/categoria', [CategoriaController::class, "funListar"]);
Route::post('/categoria', [CategoriaController::class, "funGuardar"]);
Route::get('/categoria/{id}', [CategoriaController::class, "funMostrar"]);
Route::put('/categoria/{id}', [CategoriaController::class, "funModificar"]);
Route::delete('/categoria/{id}', [CategoriaController::class, "funEliminar"]);

// rutas roles (CRUD resource)
Route::apiResource("role", RoleController::class);
// rutas personas
Route::apiResource("persona", PersonaController::class);


