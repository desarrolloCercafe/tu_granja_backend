<?php

namespace App\Http\Controllers\API;

use App\pedido_medicamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PedidoMedicamentosController extends Controller
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
     * @param  \App\pedido_medicamentos  $pedido_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Detalle = pedido_medicamentos::select('pedido_medicamentos.*', 'granjas.nombre_granja',
        'medicamentos.nombre_medicamento')
        ->join('medicamentos', 'medicamento_id', '=', 'medicamentos.id')
        ->join('granjas', 'granja_id', '=', 'granjas.id')
        ->where('consecutivo_pedido', $id)->get();

        return response()->json($Detalle, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\pedido_medicamentos  $pedido_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(pedido_medicamentos $pedido_medicamentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\pedido_medicamentos  $pedido_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pedido_medicamentos $pedido_medicamentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\pedido_medicamentos  $pedido_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(pedido_medicamentos $pedido_medicamentos)
    {
        //
    }
}
