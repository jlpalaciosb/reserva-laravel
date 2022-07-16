<?php

namespace App\Http\Controllers;

use App\Models\HorarioRecurso;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HorarioRecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        // query param fecha
        $fecha = $request->input('fecha')
            ? new Carbon($request->input('fecha'))
            : Carbon::today();
        
        // query param offset es cantidad de dias a agregar a la fecha
        // a listar, sirve xq es mas facil sumar fechas en el backend con
        // carbon que en el frontend con js
        if ($request->input('offset')) {
            $fecha->addDays($request->input('offset'));
        }
        
        $lista = HorarioRecurso::with('horario', 'recurso', 'reservas')
            ->where('fecha', $fecha)
            ->get();

        return response()->json($lista);
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
     * Guardar horario-recurso
     * Esto crea o actualiza una instancia
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lista = $request->all();
        foreach ($lista as $hr_req) {
            $hr = HorarioRecurso::where('fecha', $hr_req['fecha'])
                ->where('id_horario', $hr_req['id_horario'])
                ->where('id_recurso', $hr_req['id_recurso'])
                ->first() ?: new HorarioRecurso;
            $hr->fill($hr_req);
            $hr->save();
        }
        return response()->json(['ok' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HorarioRecurso  $horarioRecurso
     * @return \Illuminate\Http\Response
     */
    public function show(HorarioRecurso $horarioRecurso)
    {
        return response()->json($horarioRecurso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HorarioRecurso  $horarioRecurso
     * @return \Illuminate\Http\Response
     */
    public function edit(HorarioRecurso $horarioRecurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HorarioRecurso  $horarioRecurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HorarioRecurso $horarioRecurso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HorarioRecurso  $horarioRecurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(HorarioRecurso $horarioRecurso)
    {
        //
    }
}
