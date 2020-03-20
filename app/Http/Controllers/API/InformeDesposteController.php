<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InformeDesposte;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;

class InformeDesposteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = DB::select("SELECT * FROM informe_desposte ORDER BY id DESC");
        return response()->json($informe, 200);
    }

    public function downloadExcel($fecha, $fecha2 = null){

        if(!is_null($fecha2)){
            $calendario = DB::select("SELECT id, fecha FROM calendario WHERE fecha BETWEEN'$fecha' AND '$fecha2'");
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
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }else{
            $calendario = DB::select("SELECT id, fecha FROM calendario WHERE fecha = '$fecha'");
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
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }

        return Excel::download(
            new ExportInforme($registros, 'Desposte'),
            '1.xlsx'
        );
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
        $fecha_calendario = DB::select("SELECT * FROM calendario WHERE fecha LIKE '%$request->fecha_inventario%'");
        $saldo_geminus = DB::select("SELECT * FROM saldos_desposte WHERE fecha LIKE '%$request->fecha_inventario%' AND codigo = '$request->ref_producto'");
         $registros = DB::select("SELECT * FROM informe_desposte WHERE ref = '$request->ref_producto' AND fecha = '$request->fecha_inventario'");
           if ($saldo_geminus) {
             if  (count($registros) >= 1) {
                $suma = 0;
                $sumaCant = 0;
                $diferencia = 0;
                $sumaCostoD = 0;
                foreach ($registros as $item) {
                    $suma += $item->cantidad;
                    $sumaCostoD += $item->diferencia;
                }
                        $sumaCant = ($suma + $request->cantidad);
                        $diferencia = ($sumaCant - (int)$saldo_geminus[0]->cantidad);
                        $InformeDesposte = new InformeDesposte();
                        $InformeDesposte->ref = $request->ref_producto;
                        $InformeDesposte->nombre_producto = $saldo_geminus[0]->descripcion;
                        $InformeDesposte->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                        $InformeDesposte->cantidad = $sumaCant;
                        $InformeDesposte->conteo = $request->cantidad;
                        $InformeDesposte->diferencia = $diferencia;
                        $InformeDesposte->porc_merma_cant = ($InformeDesposte->diferencia / ($InformeDesposte->saldo_geminus + (int)$saldo_geminus[0]->ventas_kg)) * 100;
                        $InformeDesposte->id_calendario = $fecha_calendario[0]->id;
                        $InformeDesposte->year = $fecha_calendario[0]->year;
                        $InformeDesposte->mes = $fecha_calendario[0]->nombre_mes;
                        $InformeDesposte->fecha = $fecha_calendario[0]->fecha;
                        $InformeDesposte->costo_unitario = (int)$saldo_geminus[0]->costo_unitario;
                        $InformeDesposte->costo_total = (int)$saldo_geminus[0]->costo_total;
                        $InformeDesposte->costo_diferencia = ($InformeDesposte->diferencia * (int) $saldo_geminus[0]->costo_unitario);
                        $InformeDesposte->porc_merma_valor = ($InformeDesposte->costo_diferencia / ($InformeDesposte->costo_total + (int) $saldo_geminus[0]->ventas_valor)) * 100;
                         $InformeDesposte->porc_merma_cant = number_format($InformeDesposte->porc_merma_cant, 2, '.', ', ');
               $InformeDesposte->porc_merma_valor = number_format($InformeDesposte->porc_merma_valor, 2, '.', ', ');
                        $InformeDesposte->save();
         } else {
            $InformeDesposte = new InformeDesposte();
            $InformeDesposte->ref = $request->ref_producto;
            $InformeDesposte->nombre_producto = $saldo_geminus[0]->descripcion;
            $InformeDesposte->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
            $InformeDesposte->cantidad = $request->cantidad;
            $InformeDesposte->conteo = $request->cantidad;
            $diferencia = ($request->cantidad - (int) $saldo_geminus[0]->cantidad);
            $InformeDesposte->diferencia = $diferencia;
            $InformeDesposte->id_calendario = $fecha_calendario[0]->id;
            $InformeDesposte->year = $fecha_calendario[0]->year;
            $InformeDesposte->mes = $fecha_calendario[0]->nombre_mes;
            $InformeDesposte->fecha = $fecha_calendario[0]->fecha;
            $InformeDesposte->costo_unitario = $saldo_geminus[0]->costo_unitario;
            $InformeDesposte->costo_total = (int)$saldo_geminus[0]->costo_total;
            $InformeDesposte->costo_diferencia =  ($InformeDesposte->diferencia * $InformeDesposte->costo_unitario);
               $InformeDesposte->porc_merma_cant = ($InformeDesposte->diferencia / ($InformeDesposte->saldo_geminus + (int)$saldo_geminus[0]->ventas_kg)) * 100;
                $InformeDesposte->porc_merma_valor = ($InformeDesposte->costo_diferencia / ($InformeDesposte->costo_total + (int) $saldo_geminus[0]->ventas_valor)) * 100;
              $InformeDesposte->porc_merma_cant = number_format($InformeDesposte->porc_merma_cant, 2, '.', ', ');
               $InformeDesposte->porc_merma_valor = number_format($InformeDesposte->porc_merma_valor, 2, '.', ', ');
            $InformeDesposte->save();
         }
         return response()->json($InformeDesposte, 200);
        } else {
            return response()->json("No hay datos");
        }
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
