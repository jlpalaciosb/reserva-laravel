<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveHorarioRequest;
use App\Models\Horario;
use App\Models\HorarioRecurso;
use Exception;
use Illuminate\Http\Request;

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
     * @param  SaveHorarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveHorarioRequest $request)
    {
        $input = $request->validated();
        $horario = new Horario();
        $horario->fill($input);
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
     * @param  SaveHorarioRequest  $request
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function update(SaveHorarioRequest $request, Horario $horario)
    {
        $input = $request->validated();
        $horario->fill($input);
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
