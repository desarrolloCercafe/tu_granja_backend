<?php

namespace App\Http\Controllers\API;

use App\insumos_servicios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class InsumosServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Insumos = insumos_servicios::all();
        return response()->json($Insumos, 200);
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
     * @param  \App\insumos_servicios  $insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function show(insumos_servicios $insumos_servicios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\insumos_servicios  $insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function edit(insumos_servicios $insumos_servicios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\insumos_servicios  $insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, insumos_servicios $insumos_servicios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\insumos_servicios  $insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function destroy(insumos_servicios $insumos_servicios)
    {
        //
    }
}