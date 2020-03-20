<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InformeMantenimiento;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;

class InformeMantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = DB::table('informe_mantenimiento')
            ->select('informe_mantenimiento.*')
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($informe, 200);
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
                    FROM informe_mantenimiento 
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
                    FROM informe_mantenimiento 
                    WHERE id_calendario = ? 
                    GROUP BY ref", [$id_calendar]);
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }

        return Excel::download(
            new ExportInforme($registros, 'Mantenimiento'),
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha_calendario = DB::table('calendario')
            ->where('fecha', 'LIKE', "%$request->fecha_inventario%")
            ->select('calendario.*')
            ->get();

/*         $saldo_geminus = DB::table('saldos_inv_mantenimiento')
            ->where('fecha', 'LIKE', "%$request->fecha_inventario%", 'AND', 'codigo', '=', "$request->ref_producto")
            ->select('saldos_inv_mantenimiento.*')
            ->get(); */
            $saldo_geminus = DB::select('SELECT * FROM `saldos_inv_mantenimiento` WHERE fecha LIKE "%'.$request->fecha_inventario.'%" AND codigo = ?', [$request->ref_producto]);
        $registros = DB::select("SELECT * FROM informe_mantenimiento WHERE ref = '$request->ref_producto' AND fecha = '$request->fecha_inventario'");
        if ($saldo_geminus) {
            if (count($registros) >= 1) {
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
                $InformeMantenimiento = new InformeMantenimiento();
                $InformeMantenimiento->ref = $request->ref_producto;
                $InformeMantenimiento->nombre_producto = $saldo_geminus[0]->descripcion;
                $InformeMantenimiento->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                $InformeMantenimiento->cantidad = $sumaCant;
                $InformeMantenimiento->conteo = $request->cantidad;
                $InformeMantenimiento->diferencia = $diferencia;
                $InformeMantenimiento->id_calendario = $fecha_calendario[0]->id;
                $InformeMantenimiento->year = $fecha_calendario[0]->year;
                $InformeMantenimiento->mes = $fecha_calendario[0]->nombre_mes;
                $InformeMantenimiento->fecha = $fecha_calendario[0]->fecha;
                $InformeMantenimiento->fecha_vencimiento = $request->fecha;
                $InformeMantenimiento->observaciones = $request->observacion;
                $InformeMantenimiento->costo_unitario = (int)$saldo_geminus[0]->costo_unitario;
                $InformeMantenimiento->costo_total = (int)$saldo_geminus[0]->costo_total;
                $InformeMantenimiento->costo_diferencia = ($InformeMantenimiento->diferencia * (int)$saldo_geminus[0]->costo_unitario);
                $InformeMantenimiento->save();
            } else {
                $InformeMantenimiento = new InformeMantenimiento();
                $InformeMantenimiento->ref = $request->ref_producto;
                $InformeMantenimiento->nombre_producto = $saldo_geminus[0]->descripcion;
                $InformeMantenimiento->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                $InformeMantenimiento->cantidad = $request->cantidad;
                $InformeMantenimiento->conteo = $request->cantidad;
                $diferencia = ($request->cantidad - (int)$saldo_geminus[0]->cantidad);
                $InformeMantenimiento->diferencia = $diferencia;
                $InformeMantenimiento->id_calendario = $fecha_calendario[0]->id;
                $InformeMantenimiento->year = $fecha_calendario[0]->year;
                $InformeMantenimiento->mes = $fecha_calendario[0]->nombre_mes;
                $InformeMantenimiento->fecha = $fecha_calendario[0]->fecha;
                $InformeMantenimiento->fecha_vencimiento = $request->fecha;
                $InformeMantenimiento->observaciones = $request->observacion;
                $InformeMantenimiento->costo_unitario = $saldo_geminus[0]->costo_unitario;
                $InformeMantenimiento->costo_total = (int)$saldo_geminus[0]->costo_total;
                $InformeMantenimiento->costo_diferencia = ($InformeMantenimiento->diferencia * $InformeMantenimiento->costo_unitario);
                $InformeMantenimiento->save();
            }
            return response()->json($InformeMantenimiento, 200);
        } else {
            return response()->json("No hay datos");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
