<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $per_page = $request->input('per_page') ?: 5;
        $query = Usuario::with([]);
        $query->orderBy('username');
        return $query->paginate($per_page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Se usa para el registro de usuarios.
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            $usu->is_admin = false; // TODO: authorize to admin users
        }
        $usu->save();
        return response()->json($usu);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(Usuario $usuario)
    {
        return response()->json($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(Usuario $usuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usuario  $usuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        // TODO
    }
}
