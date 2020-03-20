<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class FilterDesposteController extends Controller
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
                FROM informe_desposte 
                WHERE id_calendario = ? 
                GROUP BY ref", [$id_calendar]);

                return response()->json($registros, 200);
        } else {
            return response()->json("No hay datos");
        }
/*         if ($request->input('fecha1') && $request->input('fecha2')) {
            $registros = DB::select("SELECT * FROM informe_desposte WHERE fecha BETWEEN '$request->fecha1' AND '$request->fecha2'");
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

                                        $codigo = $registros[0]->ref;
                                        $saldos_geminus = DB::select("SELECT * FROM saldos_desposte WHERE codigo = '$codigo'");
                                        $sumVentasKg = 0;
                                        $sumaVentasValor = 0;
                                        if ($saldos_geminus) {
                                            foreach ($saldos_geminus as $item) {
                                                $sumVentasKg += (int) $item->ventas_kg;
                                                $sumaVentasValor += (int) $item->ventas_valor;
                                            }
                                        }else {
                                            return response()->json("No hay datos");
                                        }
                                        $registros[$i]->porc_merma_cant = ($registros[$i]->diferencia / ($registros[$i]->saldo_geminus + $sumVentasKg) * 100);
                                           $registros[$i]->porc_merma_valor = ($registros[$i]->diferencia / ($registros[$i]->costo_total + $sumaVentasValor) * 100);
                                            $registros[$i]->porc_merma_cant  = number_format($registros[$i]->porc_merma_cant , 2, '.', ', ');
               $registros[$i]->porc_merma_valor = number_format($registros[$i]->porc_merma_valor, 2, '.', ', ');

                                }

                        }
                                        array_push($datos, $registros[$i]);
                                          return response()->json($datos, 200);

                }

            } else {
                    return response()->json("No hay datos");
            }
    } else if  ($request->input('fecha') && !$request->input('mes') && !$request->input('year')) {
            $registros = DB::select("SELECT *   FROM informe_desposte WHERE fecha =  '$request->fecha'");
           if  (count($registros) >= 1) {
                       $sumaCant = 0;
                              $diferencia = 0;
                              $datos = [];

                for ($i = 0; $i<count($registros); $i++) {
                        for ($j = $i + 1; $j < count($registros); $j++) {
                                if ($registros[$i]->ref === $registros[$j]->ref) {
                         $codigo = $registros[$i]->ref;
                        $sumVentasKg = 0;
                       $sumaVentasValor = 0;
                       $saldos_geminus = DB::select("SELECT * FROM saldos_desposte WHERE codigo = '$codigo' AND fecha LIKE '%$request->fecha%'");
                                        $sumVentasKg = 0;
                                        $sumaVentasValor = 0;
                                        if ($saldos_geminus) {
                                            foreach ($saldos_geminus as $item) {
                                                $sumVentasKg += (int) $item->ventas_kg;
                                                $sumaVentasValor += (int) $item->ventas_valor;
                                            }
                                        }
                                        $registros[$i]->conteo += $registros[$j]->conteo;
                                        $registros[$i]->cantidad = ($registros[$i]->cantidad + $registros[$j]->cantidad);
                                        $registros[$i]->saldo_geminus = $registros[$i]->saldo_geminus;
                                        $registros[$i]->diferencia = ($registros[$i]->conteo - $registros[$i]->saldo_geminus);
                                        $registros[$i]->costo_unitario =+ $registros[$j]->costo_unitario;
                                        $registros[$i]->costo_total =  $registros[$j]->costo_total;
                                        $registros[$i]->costo_diferencia = ($registros[$i]->diferencia * $registros[$i]->costo_unitario);
                                        $registros[$i]->porc_merma_cant = ($registros[$i]->diferencia / ($registros[$i]->saldo_geminus + $sumVentasKg)) * 100;
                                        $registros[$i]->porc_merma_valor = ($registros[$i]->costo_diferencia / ($registros[$i]->costo_total +  $sumaVentasValor)) * 100;
                                            $registros[$i]->porc_merma_cant  = number_format($registros[$i]->porc_merma_cant , 2, '.', ', ');
               $registros[$i]->porc_merma_valor = number_format($registros[$i]->porc_merma_valor, 2, '.', ', ');
                                        $registros[$j]->conteo = 0;
                                }
                                     array_push($datos, $registros[$j]);
                        }
                            array_push($datos, $registros[$i]);
                            return response()->json($datos, 200);
                     }
            }else {
                    return response("No hay datos");
            }
    } else if  ($request->input('year') && $request->input('mes') && $request->input('fecha')) {
        $request->mes = strtolower($request->mes);
            $registros = DB::select("SELECT *   FROM informe_desposte WHERE year = '$request->year' AND mes = '$request->mes' AND fecha = '$request->fecha'");
            if ($registros) {
                return response($registros, 200);
            } else {
                return response()->json("No hay datos");
            }
        } else if ($request->input('year') && !$request->input('mes') && !$request->input('fecha')) {
           $registros = DB::select("SELECT * FROM informe_desposte WHERE year = '$request->year'");
            if ($registros) {
                return response($registros, 200);
            } else {
                return response()->json("No hay datos");
            }
    }   else if  (!$request->input('year') && $request->input('mes') && $request->input('fecha')) {
        $request->mes = strtolower($request->mes);
            $registros = DB::select("SELECT * FROM informe_desposte WHERE mes = '$request->mes' AND fecha = '$request->fecha'");
            if ($registros) {
                return response()->json($registros, 200);
            } else {
                return response()->json("No hay datos");
            }
    }  else if ($request->input('year') && $request->input('fecha') && !$request->input('mes')) {
            $registros = DB::select("SELECT * FROM informe_desposte WHERE year = '$request->year' AND fecha = '$request->fecha'");
            if  (count($registros) >= 1) {
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
                                        $registros[$i]->costo_unitario = ($registros[$i]->costo_unitario + $registros[$j]->costo_unitario);
                                        $registros[$i]->costo_total = ($registros[$i]->costo_total + $registros[$j]->costo_total);
                                        $registros[$i]->costo_diferencia = ($registros[$i]->diferencia * $registros[$i]->costo_unitario);
                                        $registros[$j]->conteo = 0;
                                }
                                     array_push($datos, $registros[$j]);
                        }
                            array_push($datos, $registros[$i]);
                            return response()->json($datos, 200);
                     }
            }else {
                    return response("No hay datos");
            }
    }  else if  ($request->input('mes') && $request->input('year') && !$request->input('fecha')) {
            $request->mes = strtolower($request->mes);
            $registros = DB::select("SELECT * FROM informe_desposte WHERE year = '$request->year' AND mes = '$request->mes'");
            if  ($registros) {
                return response($registros, 200);
            } else {
                return response()->json("No hay datos");
            }
    } else if  (!$request->input('year') && $request->input('mes') && !$request->input('fecha')) {
         $request->mes = strtolower($request->mes);
            $registros = DB::select("SELECT * FROM informe_desposte WHERE  mes = '$request->mes'");
            if  ($registros) {
                return response($registros, 200);
            } else {
                return response()->json("No hay datos");
            }

    } else if  (!$request->input('year') && !$request->input('mes') && !$request->input('fecha')) {
        return response()->json("No hay datos");
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
