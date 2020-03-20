<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;
use App\InformePt;

class InformePtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = DB::select("SELECT * FROM informe_pt ORDER BY id DESC");
        return response()->json($informe);
    }

    public function downloadExcel($fecha, $fecha2 = null){

        if(!is_null($fecha2)){
            $calendario = DB::select("SELECT id, fecha FROM calendario WHERE fecha BETWEEN '$fecha' AND '$fecha2'");
            if ($calendario) {
                $id_calendar = $calendario[0]->id;
                $registros = DB::select(
                    "SELECT `ref`, `nombre_producto`, `saldo_geminus`, 
                            `costo_unitario`, `costo_total`, SUM(conteo) as conteo, 
                            (SUM(conteo)- saldo_geminus) as diferencia, 
                            ((SUM(conteo)-saldo_geminus) * costo_unitario) as costo_diferencia 
                    FROM informe_pt 
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
                    FROM informe_pt 
                    WHERE id_calendario = ? 
                    GROUP BY ref", [$id_calendar]);
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }

        return Excel::download(
            new ExportInforme($registros, 'Producto_Terminado'),
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
        $saldo_geminus = DB::select("SELECT * FROM saldos_pt WHERE fecha LIKE '%$request->fecha_inventario%' AND codigo = $request->ref_producto");
         $registros = DB::select("SELECT * FROM informe_pt WHERE ref = '$request->ref_producto' AND fecha = '$request->fecha_inventario'");
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
                        $InformePt = new InformePt();
                        $InformePt->ref = $request->ref_producto;
                        $InformePt->nombre_producto = $saldo_geminus[0]->descripcion;
                        $InformePt->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                        $InformePt->cantidad = $sumaCant;
                        $InformePt->conteo = $request->cantidad;
                        $InformePt->diferencia = $diferencia;
                        $InformePt->id_calendario = $fecha_calendario[0]->id;
                        $InformePt->year = $fecha_calendario[0]->year;
                        $InformePt->mes = $fecha_calendario[0]->nombre_mes;
                        $InformePt->fecha = $fecha_calendario[0]->fecha;
                        $InformePt->costo_unitario = (int)$saldo_geminus[0]->costo_unitario;
                        $InformePt->costo_total = (int)$saldo_geminus[0]->costo_total;
                        $InformePt->costo_diferencia = ($InformePt->diferencia * (int) $saldo_geminus[0]->costo_unitario);
                        $InformePt->save();
         } else {
            $InformePt = new InformePt();
            $InformePt->ref = $request->ref_producto;
            $InformePt->nombre_producto = $saldo_geminus[0]->descripcion;
            $InformePt->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
            $InformePt->cantidad = $request->cantidad;
            $InformePt->conteo = $request->cantidad;
            $diferencia = ($request->cantidad - (int) $saldo_geminus[0]->cantidad);
            $InformePt->diferencia = $diferencia;
            $InformePt->id_calendario = $fecha_calendario[0]->id;
            $InformePt->year = $fecha_calendario[0]->year;
            $InformePt->mes = $fecha_calendario[0]->nombre_mes;
            $InformePt->fecha = $fecha_calendario[0]->fecha;
            $InformePt->costo_unitario = $saldo_geminus[0]->costo_unitario;
            $InformePt->costo_total = (int)$saldo_geminus[0]->costo_total;
            $InformePt->costo_diferencia =  ($InformePt->diferencia * $InformePt->costo_unitario);
            $InformePt->save();
         }
         return response()->json($InformePt, 200);
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
