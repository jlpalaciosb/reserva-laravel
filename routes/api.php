<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\HorarioRecursoController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// hacer esto con /api/usuarios?me=1
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// grupo de rutas SIN autenticacion
Route::middleware(['allow.origin.all'])->group(function () {
    Route::post('/registro', [AuthController::class, 'registro']);
    Route::post('/login', [AuthController::class, 'login']);
});

// grupo de rutas CON autenticacion
Route::middleware(['auth:sanctum', 'allow.origin.all'])->group(function () {
    Route::resource('/usuarios', UsuarioController::class);
    Route::resource('/horarios', HorarioController::class);
    Route::resource('/recursos', RecursoController::class);
    Route::resource('/horarioRecursos', HorarioRecursoController::class);
    Route::resource('/reservas', ReservaController::class);
});
