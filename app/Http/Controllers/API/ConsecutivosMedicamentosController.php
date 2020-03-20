<?php

namespace App\Http\Controllers\API;

use App\consecutivos_medicamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use App\pedido_medicamentos;
use App\pedido_insumos_servicios;

class ConsecutivosMedicamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $Pedidos = DB::select('SELECT * FROM consecutivos_medicamentos ORDER BY consecutivo DESC',[]); */

        $Pedidos = DB::select('SELECT cm.*, granjas.nombre_granja, estados.nombre_estado
        FROM consecutivos_medicamentos cm JOIN granjas, estados
        WHERE (cm.granja_id = granjas.id) AND (cm.estado_id = estados.id)
        ORDER BY cm.consecutivo DESC',[]);

        return response()->json($Pedidos, 200);
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
        $consecutivo = consecutivos_medicamentos::max('consecutivo');

        $Pedido = new consecutivos_medicamentos();
        $Pedido->consecutivo = $consecutivo + 1;
        $Pedido->fecha_creacion = $request->fecha_creacion;
        $Pedido->granja_id = $request->granja;
        $Pedido->estado_id = 1;
        $Pedido->origen = $request->origen;
        $Pedido->tipo_pedido = $request->tipo_pedido;
        $Pedido->save();

        if ($request->origen == 1){
            $Medicamentos = array();
            foreach ($request->pedidos as $pedido){
                $pedido = array(
                    'consecutivo_pedido' => ($consecutivo + 1),
                    'fecha_pedido' => $request->fecha_creacion,
                    'granja_id' => $request->granja,
                    'medicamento_id' => $pedido['id'],
                    'estado_id' => 1,
                    'unidades' => $pedido['cantidad']
                );
                pedido_medicamentos::insert($pedido);
            }
        } else {
            $Insumos = array();
            foreach ($request->pedidos as $pedido){
                $pedido = array(
                    'consecutivo_pedido' => ($consecutivo + 1),
                    'fecha_pedido_insumo' => $request->fecha_creacion,
                    'granja_id' => $request->granja,
                    'insumo_servicio_id' => $pedido['id'],
                    'estado_id' => 1,
                    'unidades' => $pedido['cantidad']
                );
                pedido_insumos_servicios::insert($pedido);
            }
        }
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\consecutivos_medicamentos  $consecutivos_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function show(consecutivos_medicamentos $consecutivos_medicamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\consecutivos_medicamentos  $consecutivos_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $id)
    {
        /* $pedido = DB::table('consecutivos_medicamentos')
        ->where('id', $id)
        ->update([
            'estado_id' => 2,
            ]);
        return response()->json("OK", 200); */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\consecutivos_medicamentos  $consecutivos_medicamentos
     * @return \Illuminate\Http\Response
     */
    /* public function update(Request $id) */
    public function update(Request $request, $id)
    {
        $pedido = DB::table('consecutivos_medicamentos')
        ->where('id', $id)
        ->update([
            'estado_id' => 2,
            ]);
        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\consecutivos_medicamentos  $consecutivos_medicamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(consecutivos_medicamentos $consecutivos_medicamentos)
    {
        //
    }
}
