<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Exception;
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
        $per_page = $request->input('per_page') ?: 5;
        $query = Recurso::with([]);
        if ($request->input('nombre')) {
            $query->where('nombre', 'ilike', '%' . $request->input('nombre') . '%');
        }
        if ($request->input('activo') === '0' || $request->input('activo') === '1') {
            $query->where('activo', (bool)$request->input('activo'));
        }
        $query->orderBy('nombre');
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
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function show(Recurso $recurso)
    {
        return response()->json($recurso);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function edit(Recurso $recurso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recurso $recurso)
    {
        $request->validate([
            'nombre' => [
                'required',
                Rule::unique('App\Models\Recurso', 'nombre')->ignore($recurso->id),
            ],
        ]);
        // ok, update
        $recurso->fill($request->all());
        $recurso->save();
        return response()->json($recurso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recurso  $recurso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recurso $recurso)
    {
        try {
            $recurso->delete();
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
