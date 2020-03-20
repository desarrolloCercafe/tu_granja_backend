<?php

namespace App\Http\Controllers\API;

use App\ordenes_produccion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Concentrados;

class OrdenesProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $op = DB::table('ordenes_produccion')
        ->join('concentrados', 'ordenes_produccion.id_dieta', '=', 'concentrados.id')
        ->select('ordenes_produccion.*', 'concentrados.ref_concentrado')
        ->orderBY('consecutivo', 'DESC')
        ->get();
        return response()->json($op, 200);
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
        $op = new ordenes_produccion();
        $op->consecutivo = $request->numOp;
        $op->id_dieta =  $request->dieta;
        $op->consecutivo_dieta = $request->consDieta;
        $op->cantidad_baches = $request->numBaches;
        $op->cantidad_disponible = 0;
        $op->estado = 1;
        $op->save();
        return response()->json('OK', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ordenes_produccion  $ordenes_produccion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $op = ordenes_produccion::find($id);
        $dieta = Concentrados::find($op->id_dieta);
        $op['nombreDieta'] = $dieta->nombre_concentrado;
        return response()->json($op, 200);
    }

    public function DietaOP($id)
    {
        /* $Dieta = DB::table('concentrados')
        ->join('ordenes_produccion', 'ordenes_produccion.id_dieta', '=', 'concentrados.id')
        ->select('concentrados.id', 'concentrados.nombre_concentrado', 'ordenes_produccion.cantidad_baches')
        ->where('concentrados.id', $id)->get();
        return response()->json($Dieta, 200); */

        $dieta = DB::select('SELECT c.id, c.nombre_concentrado, op.cantidad_baches
        FROM concentrados c JOIN ordenes_produccion op
        WHERE op.id = ? AND op.id_dieta = c.id', [$id]);
        return response()->json($dieta, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ordenes_produccion  $ordenes_produccion
     * @return \Illuminate\Http\Response
     */
    public function edit(ordenes_produccion $ordenes_produccion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ordenes_produccion  $ordenes_produccion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $op = ordenes_produccion::find($id);
        $op->consecutivo = $request->numOp;
        $op->id_dieta =  $request->dieta;
        $op->consecutivo_dieta = $request->consDieta;
        $op->cantidad_baches = $request->numBaches;
        $op->save();
        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ordenes_produccion  $ordenes_produccion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ordenes_produccion $ordenes_produccion)
    {
        //
    }
}