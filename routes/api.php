<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Auth 
Route::prefix('/v1/auth')->group(function(){
    
    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);

    Route::middleware('auth:sanctum')->group(function(){
        
        Route::get("/profile", [AuthController::class, "funPerfil"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });

});

// rutas categorias con SQL



Route::middleware('auth:sanctum')->group(function(){
    
    Route::get('/categoria/reporte-pdf', [CategoriaController::class, "funReportePDF"]);
    Route::get('/categoria', [CategoriaController::class, "funListar"]);
    Route::post('/categoria', [CategoriaController::class, "funGuardar"]);
    Route::get('/categoria/{id}', [CategoriaController::class, "funMostrar"]);
    Route::put('/categoria/{id}', [CategoriaController::class, "funModificar"]);
    Route::delete('/categoria/{id}', [CategoriaController::class, "funEliminar"]);
    // rutas roles (CRUD resource) con Query Builder
    Route::apiResource("role", RoleController::class);
    // rutas personas
    Route::apiResource("persona", PersonaController::class)->middleware('auth:sanctum');
    // rutas para usuarios
    Route::apiResource("usuario", UserController::class)->middleware('auth:sanctum');
    
    // rutas para productos
    Route::apiResource("producto", ProductoController::class);
});
