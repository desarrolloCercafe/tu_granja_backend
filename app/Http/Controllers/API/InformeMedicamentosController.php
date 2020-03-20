<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\InformeMedicamento;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;
use App\calendario;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromQuery;

class InformeMedicamentosController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informeMedicamentos = DB::table('informe_medicamentos')
            ->join('calendario', 'informe_medicamentos.id_calendario', '=', 'calendario.id')
            ->select('informe_medicamentos.id as id_informe', 'informe_medicamentos.ref', 'informe_medicamentos.nombre_producto', 'informe_medicamentos.saldo_geminus', 'informe_medicamentos.cantidad', 'informe_medicamentos.conteo', 'informe_medicamentos.diferencia', 'informe_medicamentos.id_calendario', 'calendario.fecha', 'calendario.id as id_calendario')
            ->orderBy('id_informe', 'DESC')
            ->get();
        ;
        return response()->json($informeMedicamentos, 200);
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
                    FROM informe_medicamentos 
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
                    FROM informe_medicamentos 
                    WHERE id_calendario = ? 
                    GROUP BY ref", [$id_calendar]);
            } else {
                $registros = ["ref" =>"No hay Datos"];
            }
        }

        return Excel::download(
            new ExportInforme($registros, 'Medicamentos'),
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
