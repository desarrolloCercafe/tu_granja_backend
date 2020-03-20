<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class FilterDotacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $calendario = DB::select("SELECT id, fecha FROM calendario WHERE fecha = '$request->fecha'");
        if ($calendario) {
            $id_calendar = $calendario[0]->id;
            $registros = DB::select(
                "SELECT `ref`, `nombre_producto`, `saldo_geminus`, 
                        `costo_unitario`, `costo_total`, SUM(conteo) as conteo, 
                        (SUM(conteo)- saldo_geminus) as diferencia, 
                        ((SUM(conteo)-saldo_geminus) * costo_unitario) as costo_diferencia 
                FROM informe_dotacion 
                WHERE id_calendario = ? 
                GROUP BY ref", [$id_calendar]);

                return response()->json($registros, 200);
        } else {
            return response()->json("No hay datos");
        }
/*         if ($request->input('fecha1') && $request->input('fecha2')) {
            $registros = DB::select("SELECT * FROM informe_dotacion WHERE fecha BETWEEN '$request->fecha1' AND '$request->fecha2'");
            if ($registros) {
                $sumaCant = 0;
                $diferencia = 0;
                $datos = [];
                for ($i = 0; $i<count($registros); $i++) {
                    for ($j = $i + 1; $j < count($registros); $j++) {
                        if ($registros[$i]->ref === $registros[$j]->ref) {
                            $registros[$i]->conteo += $registros[$j]->conteo;
                            $registros[$i]->cantidad = ($registros[$i]->cantidad + $registros[$j]->cantidad);
                            $registros[$i]->saldo_geminus = ($registros[$i]->saldo_geminus + $registros[$j]->saldo_geminus);
                            $registros[$i]->diferencia = ($registros[$i]->conteo - $registros[$i]->saldo_geminus);
                            $registros[$i]->costo_unitario = ($registros[$i]->costo_unitario + $registros[$j]->costo_unitario);
                            $registros[$i]->costo_total = ($registros[$i]->costo_total + $registros[$j]->costo_total);
                            $registros[$i]->costo_diferencia = ($registros[$i]->diferencia * $registros[$i]->costo_unitario);

                        }

                    }
                    array_push($datos, $registros[$i]);
                    return response()->json($datos, 200);
                }

            } else {
                return response()->json("No hay datos");
            }
        }  else if  ($request->input('fecha') && !$request->input('mes') && !$request->input('year')) {
            $registros = DB::select("SELECT *   FROM informe_dotacion WHERE fecha =  '$request->fecha'");
            if (count($registros) >= 1) {
                $sumaCant = 0;
                $diferencia = 0;
                $datos = [];
                for ($i = 0; $i<count($registros); $i++) {
                    for ($j = $i + 1; $j < count($registros); $j++) {
                        if ($registros[$i]->ref === $registros[$j]->ref) {
                            $registros[$i]->conteo += $registros[$j]->conteo;
                            $registros[$i]->cantidad = ($registros[$i]->cantidad + $registros[$j]->cantidad);
                            $registros[$i]->saldo_geminus = $registros[$i]->saldo_geminus;
                            $registros[$i]->diferencia = ($registros[$i]->conteo - $registros[$i]->saldo_geminus);
                            $registros[$i]->costo_unitario = $registros[$j]->costo_unitario;
                            $registros[$i]->costo_total = $registros[$j]->costo_total;
                            $registros[$i]->costo_diferencia = ($registros[$i]->diferencia * $registros[$i]->costo_unitario);
                            $registros[$j]->conteo = 0;

                        }
                        array_push($datos, $registros[$j]);

                    }
                    array_push($datos, $registros[$i]);
                    return response()->json($datos, 200);
                }
            } else {
                return response()->json("No hay datos");
            }
        } */
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
