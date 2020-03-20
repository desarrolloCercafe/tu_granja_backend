<?php

namespace App\Http\Controllers\API;

use App\pedido_concentrados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PedidoConcentradosController extends Controller
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
     * @param  \App\pedido_concentrados  $pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Detalle = pedido_concentrados::select('pedido_concentrados.*', 'granjas.nombre_granja',
        'concentrados.nombre_concentrado')
        ->join('concentrados', 'concentrado_id', '=', 'concentrados.id')
        ->join('granjas', 'granja_id', '=', 'granjas.id')
        ->where('consecutivo_pedido', $id)->get();

        /* $Detalle = pedido_concentrados::select('pedido_concentrados.consecutivo_pedido', 'pedido_concentrados.granja_id',
        'granjas.nombre_granja', 'pedido_concentrados.concentrado_id', 'concentrados.nombre_concentrado',
        'pedido_concentrados.no_bultos', 'pedido_concentrados.no_kilos')
        ->join('concentrados', 'concentrado_id', '=', 'concentrados.id')
        ->join('granjas', 'granja_id', '=', 'granjas.id')
        ->where('consecutivo_pedido', $id)->get(); */

        return response()->json($Detalle, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pedido_concentrados  $pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function edit(pedido_concentrados $pedido_concentrados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pedido_concentrados  $pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pedido_concentrados $pedido_concentrados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pedido_concentrados  $pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function destroy(pedido_concentrados $pedido_concentrados)
    {
        //
    }
}