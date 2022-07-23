<?php

use App\Http\Controllers\PasswordResetLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// retorna frontend compilado
Route::get('/', function () {
    return view('index');
});

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create']);
