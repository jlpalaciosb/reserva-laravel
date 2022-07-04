<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\HorarioRecurso;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HorarioController extends Controller
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
        $query = Horario::with([]);
        if ($request->input('hora_desde')) {
            $query->where('hora_ini', '>=', $request->input('hora_desde'));
        }
        if ($request->input('hora_hasta')) {
            $query->where('hora_fin', '<=', $request->input('hora_hasta'));
        }
        if ($request->input('activo') === '0' || $request->input('activo') === '1') {
            $query->where('activo', (bool)$request->input('activo'));
        }
        $query->orderBy('hora_ini');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'unique:App\Models\Horario,nombre' ],
            'hora_ini' => ['required', 'before:hora_fin'],
            'hora_fin' => ['required'],
        ]);
        $horario = new Horario();
        $horario->fill($request->all());
        $horario->save();
        return response()->json($horario);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario)
    {
        return response()->json($horario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function edit(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('App\Models\Horario', 'nombre')->ignore($horario->id),
            ],
            'hora_ini' => ['required', 'before:hora_fin'],
            'hora_fin' => ['required'],
        ]);
        // validar que no se uso todavia (que es nuevo)
        $c = HorarioRecurso::where('id_horario', $horario->id)->count();
        if ($c > 0) {
            return response()->json([
                'message' => 'Solo se pueden editar los horarios nuevos.'
            ], 400);
        }
        // ok, update
        $horario->fill($request->all());
        $horario->save();
        return response()->json($horario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horario $horario)
    {
        try {
            $horario->delete();
            return response()->json([]); // ok
        } catch (Exception $ex) {
            if (str_contains($ex->getMessage(), 'Foreign key violation')) {
                return response()->json([
                    'message' => 'Ya tiene datos asociados!'
                ], 400);
            } else {
                throw $ex;
            }
        }
    }
}
