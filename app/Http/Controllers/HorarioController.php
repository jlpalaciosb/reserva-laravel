<?php

namespace App\Http\Controllers;

use App\Models\Horario;
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
        if ($request->input('sub_index') == 'all_activos') {
            return $this->index_all_activos($request);
        } else { // normal index
            $length = 5;
            $query = Horario::with([]);
            if ($request->input('horaDesde')) {
                $query->where('hora_ini', '>=', $request->input('horaDesde'));
            }
            if ($request->input('horaHasta')) {
                $query->where('hora_fin', '<=', $request->input('horaHasta'));
            }
            $query->orderBy('hora_ini');
            return $query->paginate($length);
        }
    }

    /**
     * Display a listing of all activos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index_all_activos(Request $request) {
        $horarios = Horario::where('activo', true)
            ->orderBy('hora_ini')
            ->orderBy('hora_fin')
            ->get();
        return response()->json($horarios);
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
            'hora_ini' => ['required', 'lt:hora_fin'],
            'hora_fin' => ['required'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Horario::find($id));
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
