<?php

namespace App\Http\Controllers\API;

use App\tolvas_acciones;
use App\tolvas_planta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TolvasAccionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Acciones = tolvas_acciones::all();
        return response()->json($Acciones, 200);
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
        /* $tolva = DB::table('tolvas_planta')
        ->select('tolvas_planta.*')
        ->where('id', '=', '$request->tolva')
        ->get(); */
        $tolva = tolvas_planta::find($request->tolva);

        if ($tolva->cantidad > 0){
            if ($tolva->dieta_actual == $request->dieta){
                if ($request->tipo == 'ENTRADA'){
                    $tolva->cantidad += $request->cantidad;
                    $tolva->dieta_actual = $request->dieta;
                } else {
                    $tolva->cantidad -= $request->cantidad;
                }
            } else {
                return response()->json("Dietas no Coinciden", 200);
            }
        } else {
            if ($request->tipo == 'ENTRADA'){
                $tolva->cantidad += $request->cantidad;
                $tolva->dieta_actual = $request->dieta;
            } else {
                $tolva->cantidad -= $request->cantidad;
            }
        }
        $tolva->save();
        
        $acciones = new tolvas_acciones();
        $acciones->fecha = $request->fecha;
        $acciones->tolva = $request->tolva;
        $acciones->tipo = $request->tipo;
        $acciones->dieta = $request->dieta;
        $acciones->cantidad = $request->cantidad;
        $acciones->granja = $request->granja;
        $acciones->despachador = strtoupper($request->despachador);
        $acciones->save();

        return response()->json("OK", 200);
    }

    public function search(Request $request){

        /*$result = DB::table('acciones_tolva')
                    ->select('acciones_tolva.*', 'tolvas_planta.nombre', 'concentrados.nombre_concentrado', 'granjas.nombre_granja')
                    ->join('tolvas_planta', 'tolvas_planta.id', '=', 'acciones_tolva.tolva')
                    ->join('concentrados', 'acciones_tolva.dieta', '=', 'concentrados.id')
                    ->join('granjas', 'granjas.id', '=', 'acciones_tolva.granja')
                    ->whereBetween('acciones_tolva.fecha', [$request->fecha_inicial, $request->fecha_final])
                    ->where('acciones_tolva.tolva', '=', $request->tolva)
                    ->get();*/

        $response = [];

        $response['result'] = DB::select(
            'SELECT act.id, c.nombre_concentrado,
                SUM(if(act.tipo = "ENTRADA", act.cantidad, 0)) as entradas,
                SUM(if(act.tipo = "SALIDA", act.cantidad, 0)) as salidas
            FROM concentrados c
            INNER JOIN tolvas_acciones act ON c.id = act.dieta
            WHERE act.tolva = ? AND act.fecha BETWEEN ? AND ? GROUP BY c.id', [
                $request->tolva, $request->fecha_inicial, $request->fecha_final
            ]);

        $response['SumaEntradas'] = DB::select(
            'SELECT SUM(cantidad) as cantidad
            FROM tolvas_acciones
            WHERE tipo = "ENTRADA" AND tolva = ? AND fecha BETWEEN ? AND ? ',
            [$request->tolva, $request->fecha_inicial, $request->fecha_final]);

        $response['SumaSalidas'] = DB::select(
            'SELECT SUM(cantidad) as cantidad
            FROM tolvas_acciones
            WHERE tipo = "SALIDA" AND tolva = ? AND fecha BETWEEN ? AND ? ',
            [$request->tolva, $request->fecha_inicial, $request->fecha_final]);

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\tolvas_acciones  $tolvas_acciones
     * @return \Illuminate\Http\Response
     */
    public function show(tolvas_acciones $tolvas_acciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tolvas_acciones  $tolvas_acciones
     * @return \Illuminate\Http\Response
     */
    public function edit(tolvas_acciones $tolvas_acciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tolvas_acciones  $tolvas_acciones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tolvas_acciones $tolvas_acciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tolvas_acciones  $tolvas_acciones
     * @return \Illuminate\Http\Response
     */
    public function destroy(tolvas_acciones $tolvas_acciones)
    {
        //
    }
}