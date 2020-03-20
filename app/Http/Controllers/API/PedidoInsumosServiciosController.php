<?php

namespace App\Http\Controllers\API;

use App\pedido_insumos_servicios;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PedidoInsumosServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\pedido_insumos_servicios  $pedido_insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Detalle = pedido_insumos_servicios::select('pedido_insumos_servicios.*', 'granjas.nombre_granja',
        'insumos_servicios.nombre_insumo')
        ->join('granjas', 'granja_id', '=', 'granjas.id')
        ->join('insumos_servicios', 'insumo_servicio_id', '=', 'insumos_servicios.id')
        ->where('consecutivo_pedido', $id)->get();

        return response()->json($Detalle, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pedido_insumos_servicios  $pedido_insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function edit(pedido_insumos_servicios $pedido_insumos_servicios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pedido_insumos_servicios  $pedido_insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pedido_insumos_servicios $pedido_insumos_servicios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pedido_insumos_servicios  $pedido_insumos_servicios
     * @return \Illuminate\Http\Response
     */
    public function destroy(pedido_insumos_servicios $pedido_insumos_servicios)
    {
        //
    }
}