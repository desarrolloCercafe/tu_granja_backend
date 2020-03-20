<?php

namespace App\Http\Controllers\API;

use App\vehiculos_despacho;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class VehiculosDespachoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos_despacho = vehiculos_despacho::all();
        return response()->json($vehiculos_despacho, 200);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vehiculos_despacho  $vehiculos_despacho
     * @return \Illuminate\Http\Response
     */
    public function show(vehiculos_despacho $vehiculos_despacho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vehiculos_despacho  $vehiculos_despacho
     * @return \Illuminate\Http\Response
     */
    public function edit(vehiculos_despacho $vehiculos_despacho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vehiculos_despacho  $vehiculos_despacho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehiculos_despacho $vehiculos_despacho)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vehiculos_despacho  $vehiculos_despacho
     * @return \Illuminate\Http\Response
     */
    public function destroy(vehiculos_despacho $vehiculos_despacho)
    {
        //
    }
}