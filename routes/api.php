<?php

use App\Http\Controllers\HorarioRecursoController;
use App\Http\Controllers\ReservaController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// ruta para crear token
Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'username' => 'required',
        'password' => 'required',
        'device' => 'required',
    ]);
    $usu = Usuario::where('username', $request->username)->first();
    if (! $usu || ! Hash::check($request->password, $usu->password)) {
        throw ValidationException::withMessages([
            'username' => ['Las credenciales proveídas son incorrectas.'],
        ]);
    }
    return response()->json([
        'usuario' => $usu,
        'token' => $usu->createToken($request->device)->plainTextToken,
    ]);
});

// en este grupo con middleware van todas las rutas autenticadas
Route::middleware(['auth:sanctum', 'allow.origin.all'])->group(function () {
    Route::get('/usuario', function (Request $request) {
        return $request->user();
    });
    Route::resource('/horariosRecursos', HorarioRecursoController::class);
    Route::resource('/reservas', ReservaController::class);
});
