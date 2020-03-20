<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InformeCalidad;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;

class InformeCalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = InformeCalidad::all();
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
                    FROM informe_calidad
                    WHERE id_calendario = ?
                    GROUP BY ref", [$id_calendar]);
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        } else {
            $calendario = DB::select("SELECT id, fecha FROM calendario WHERE fecha = '$fecha'");
            if ($calendario) {
                $id_calendar = $calendario[0]->id;
                $registros = DB::select(
                    "SELECT `ref`, `nombre_producto`, `saldo_geminus`,
                    `costo_unitario`, `costo_total`, SUM(conteo) as conteo,
                    (SUM(conteo)- saldo_geminus) as diferencia,
                    ((SUM(conteo)-saldo_geminus) * costo_unitario) as costo_diferencia
                    FROM informe_calidad
                    WHERE id_calendario = ?
                    GROUP BY ref", [$id_calendar]);
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }

        return Excel::download(
            new ExportInforme($registros, 'Calidad'),
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

        $codigo_producto = DB::select(
            'SELECT id, codigo_producto 
            FROM productos_calidad 
            WHERE codigo_producto = ?', [$request->ref_producto]);

        $id = $codigo_producto[0]->id;

        $saldo_geminus = DB::select(
            "SELECT * FROM saldos_calidad 
            WHERE fecha LIKE '%".$request->fecha_inventario."%' 
                AND producto_id = ?", [$id]);
                
        $registros = DB::select("SELECT * FROM informe_calidad WHERE ref = '$request->ref_producto' AND fecha = '$request->fecha_inventario'");
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
                $InformeCalidad = new InformeCalidad();
                $InformeCalidad->ref = $request->ref_producto;
                $InformeCalidad->nombre_producto = $saldo_geminus[0]->descripcion;
                $InformeCalidad->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                $InformeCalidad->cantidad = $sumaCant;
                $InformeCalidad->conteo = $request->cantidad;
                $InformeCalidad->diferencia = $diferencia;
                $InformeCalidad->id_calendario = $fecha_calendario[0]->id;
                $InformeCalidad->year = $fecha_calendario[0]->year;
                $InformeCalidad->mes = $fecha_calendario[0]->nombre_mes;
                $InformeCalidad->fecha = $fecha_calendario[0]->fecha;
                $InformeCalidad->fecha_vencimiento = $request->fecha;
                $InformeCalidad->observaciones = $request->observacion;
                $InformeCalidad->costo_unitario = (int)$saldo_geminus[0]->costo_unitario;
                $InformeCalidad->costo_total = (int)$saldo_geminus[0]->total;
                $InformeCalidad->costo_diferencia = ($InformeCalidad->diferencia * (int)$saldo_geminus[0]->costo_unitario);
                $InformeCalidad->save();
            } else {
                $InformeCalidad = new InformeCalidad();
                $InformeCalidad->ref = $request->ref_producto;
                $InformeCalidad->nombre_producto = $saldo_geminus[0]->descripcion;
                $InformeCalidad->saldo_geminus = (int)$saldo_geminus[0]->cantidad;
                $InformeCalidad->cantidad = $request->cantidad;
                $InformeCalidad->conteo = $request->cantidad;
                $diferencia = ($request->cantidad - (int)$saldo_geminus[0]->cantidad);
                $InformeCalidad->diferencia = $diferencia;
                $InformeCalidad->id_calendario = $fecha_calendario[0]->id;
                $InformeCalidad->year = $fecha_calendario[0]->year;
                $InformeCalidad->mes = $fecha_calendario[0]->nombre_mes;
                $InformeCalidad->fecha = $fecha_calendario[0]->fecha;
                $InformeCalidad->fecha_vencimiento = $request->fecha;
                $InformeCalidad->observaciones = $request->observacion;
                $InformeCalidad->costo_unitario = $saldo_geminus[0]->costo_unitario;
                $InformeCalidad->costo_total = (int)$saldo_geminus[0]->total;
                $InformeCalidad->costo_diferencia = ($InformeCalidad->diferencia * $InformeCalidad->costo_unitario);
                $InformeCalidad->save();
            }
            return response()->json($InformeCalidad, 200);
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
