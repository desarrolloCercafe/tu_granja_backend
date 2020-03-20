<?php

namespace App\Http\Controllers\API;

use App\tolvas_planta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TolvasPlantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tolvas = tolvas_planta::select('tolvas_planta.*', 'concentrados.nombre_concentrado')
        ->leftJoin('concentrados', 'concentrados.id', '=', 'tolvas_planta.dieta_actual')
        ->get();
        return response()->json($tolvas, 200);
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
        $tolva = new tolvas_planta();
        $tolva->nombre = $request->nombre;
        $tolva->capacidad = $request->capacidad;
        if ($request->dieta == null){
            $tolva->dieta_actual = null;
            $tolva->cantidad = 0;
        } else {
            $tolva->dieta_actual = $request->dieta;
            if ($request->cantidad_inicial == null){
                $tolva->cantidad = 0;
            } else {
                $tolva->cantidad = $request->cantidad_inicial;
            }
        }
        $tolva->save();
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tolvas_planta  $tolvas_planta
     * @return \Illuminate\Http\Response
     */
    public function show(tolvas_planta $tolvas_planta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tolvas_planta  $tolvas_planta
     * @return \Illuminate\Http\Response
     */
    public function edit(tolvas_planta $tolvas_planta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tolvas_planta  $tolvas_planta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tolvas_planta $tolvas_planta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tolvas_planta  $tolvas_planta
     * @return \Illuminate\Http\Response
     */
    public function destroy(tolvas_planta $tolvas_planta)
    {
        //
    }
}