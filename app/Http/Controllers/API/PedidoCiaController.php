<?php

namespace App\Http\Controllers\API;

use App\pedido_cia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PedidoCiaController extends Controller
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
     * @param  \App\pedido_cia  $pedido_cia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Detalle = pedido_cia::select('pedido_cia.*', 'granjas.nombre_granja',
        'productos_cia.nombre_producto_cia')
        ->join('productos_cia', 'producto_cia_id', '=', 'productos_cia.id')
        ->join('granjas', 'granja_id', '=', 'granjas.id')
        ->where('consecutivo_pedido', $id)->get();

        return response()->json($Detalle, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pedido_cia  $pedido_cia
     * @return \Illuminate\Http\Response
     */
    public function edit(pedido_cia $pedido_cia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pedido_cia  $pedido_cia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pedido_cia $pedido_cia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pedido_cia  $pedido_cia
     * @return \Illuminate\Http\Response
     */
    public function destroy(pedido_cia $pedido_cia)
    {
        //
    }
}
