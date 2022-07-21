<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    /**
     * Registro de nuevos usuarios.
     * Store a newly created usuario in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registro(Request $request)
    {
        $request->validate([
            'username' => ['required', 'unique:App\Models\Usuario,username' ],
            'password' => 'required',
            'confirm' => ['required', 'same:password'],
            'nombre' => 'required',
            'apellido' => 'required',
            'email' => [ 'required', 'email', 'unique:App\Models\Usuario,email' ],
        ]);
        $usu = new Usuario;
        $usu->fill($request->all());
        $usu->password = Hash::make($usu->password); // hashear contraseña
        if (Usuario::count() == 0) {
            $usu->is_admin = true; // para q el 1er usuario sea admin
        } else {
            $usu->is_admin = false;
        }
        $usu->save();
        return response()->json($usu);
    }

    /**
     * Verifica las credenciales recibidas y crea un token de
     * acceso para el usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device' => 'required',
        ]);
        $usu = Usuario::where('username', $request->username)
            ->orWhere('email', $request->username)
            ->first();
        if (! $usu || ! Hash::check($request->password, $usu->password)) {
            throw ValidationException::withMessages([
                'username' => ['Las credenciales proveídas son incorrectas.'],
            ]);
        }
        return response()->json([
            'usuario' => $usu,
            'token' => $usu->createToken($request->device)->plainTextToken,
        ]);
    }

}
