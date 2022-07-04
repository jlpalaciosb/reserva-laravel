<?php

namespace App\Http\Controllers;

use App\Models\HorarioRecurso;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
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
        $query = Reserva::with([]);
        $query->orderBy('id');
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
        $input = $request->all();
        $input['id_usuario'] = Auth::user()->id;
        $horarioRecurso = HorarioRecurso::with('reservas')
            ->find($input['id_horario_recurso']);
        
        // validate limit
        if (count($horarioRecurso->reservas) >= $horarioRecurso->limite) {
            return response()->json([
                'message' => 'Límite alcanzado!'
            ], 400);
        }

        // validate user
        $count = Reserva::where('id_usuario', $input['id_usuario'])
            ->where('id_horario_recurso', $input['id_horario_recurso'])
            ->count();
        if ($count > 0) {
            return response()->json([
                'message' => 'Usted ya reservó este lugar'
            ], 400);
        }

        // ok reservar
        $reserva = new Reserva;
        $reserva->fill($input);
        $reserva->save();
        return response()->json($reserva);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function show(Reserva $reserva)
    {
        return response()->json($reserva);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reserva  $reserva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reserva $reserva)
    {
        // TODO
    }
}
