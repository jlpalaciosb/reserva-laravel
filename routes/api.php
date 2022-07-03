<?php

use App\Http\Controllers\HorarioController;
use App\Http\Controllers\HorarioRecursoController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
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

// if (env('REDIRECT_HTTPS')) {
//     URL::forceScheme('https');
// }

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// grupo de rutas SIN autenticacion
// Route::middleware(['allow.origin.all'])->group(function () {
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
    // ruta para crear usuario
    Route::post('/registro', [UsuarioController::class, 'store']);
// });

// // grupo de rutas CON autenticacion
// Route::middleware(['auth:sanctum', 'allow.origin.all'])->group(function () {
    Route::get('/usuario', function (Request $request) {
        return $request->user();
    });
    Route::resource('/horarios', HorarioController::class);
    Route::resource('/recursos', RecursoController::class);
    Route::resource('/horariosRecursos', HorarioRecursoController::class);
    Route::resource('/reservas', ReservaController::class);
// });
