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
        $fecha = $request->input('fecha')
            ? new Carbon($request->input('fecha'))
            : Carbon::today();
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
     * Store a newly created resource in storage.
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
