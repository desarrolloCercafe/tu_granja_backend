<?php

namespace App\Http\Controllers\API;

use App\duracionPreceboCeba;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class DuracionPreceboCebaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $duracion = duracionPreceboCeba::all();
        return response()->json($duracion, 200);
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
        $duracion = new duracionPreceboCeba();
        $duracion->id_granja = $request->id_granja;
        $duracion->etapas = $request->etapas;
        $duracion->precebo_origen = $request->precebo_origen;
        $duracion->precebo_destino = $request->precebo_destino;
        $duracion->cria_origen = $request->cria_origen;
        $duracion->tiempo_destete = $request->tiempo_destete;
        $duracion->dias_precebo = $request->dias_precebo;
        $duracion->dias_ceba = $request->dias_ceba;
        $duracion->dias_wtf = $request->dias_wtf;
        $duracion->save();

        return response()->json("OK", 200);
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\duracionPreceboCeba  $duracionPreceboCeba
     * @return \Illuminate\Http\Response
     */
    public function show(duracionPreceboCeba $duracionPreceboCeba)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\duracionPreceboCeba  $duracionPreceboCeba
     * @return \Illuminate\Http\Response
     */
    public function edit(duracionPreceboCeba $duracionPreceboCeba)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\duracionPreceboCeba  $duracionPreceboCeba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, duracionPreceboCeba $duracionPreceboCeba)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\duracionPreceboCeba  $duracionPreceboCeba
     * @return \Illuminate\Http\Response
     */
    public function destroy(duracionPreceboCeba $duracionPreceboCeba)
    {
        //
    }
}
