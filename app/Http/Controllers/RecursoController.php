<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        if ($request->input('sub_index') == 'all_activos') {
            return $this->index_all_activos($request);
        } else { // normal index
            $length = 4;
            $query = Recurso::with([]);
            if ($request->input('nombre')) {
                $query->where('nombre', 'ilike', '%' . $request->input('nombre') . '%');
            }
            $query->orderBy('nombre');
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
        $recursos = Recurso::where('activo', true)
            ->orderBy('nombre')
            ->get();
        return response()->json($recursos);
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
            'nombre' => ['required', 'unique:App\Models\Recurso,nombre' ],
        ]);
        $recurso = new Recurso();
        $recurso->fill($request->all());
        $recurso->save();
        return response()->json($recurso);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Recurso::find($id));
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
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('App\Models\Recurso', 'nombre')->ignore($id),
            ],
        ]);
        $recurso = Recurso::find($id);
        $recurso->fill($request->all());
        $recurso->save();
        return response()->json($recurso);
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
