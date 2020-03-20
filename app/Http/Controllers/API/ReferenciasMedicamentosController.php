<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ReferenciasMedicamento;
use App\InformeMedicamento;
use DB;
class ReferenciasMedicamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referencias = ReferenciasMedicamento::all();
        return response()->json(["referencias" => $referencias], 200);
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
        $fecha_calendario = DB::table('calendario')
                            ->where('fecha', 'LIKE', "%$request->fecha_inventario%")
                            ->select('calendario.*')
                            ->get();

        //return $request->ref_producto;

        /*$saldo_geminus = DB::table('inventario_medicamentos')
                            ->where('fecha', 'LIKE', "%$request->fecha_inventario%", 'AND', 'codigo', '=', "$request->ref_producto")
                            ->select('inventario_medicamentos.*')
                            ->get();*/
        $saldo_geminus = DB::select('SELECT * FROM `inventario_medicamentos` WHERE fecha LIKE "%'.$request->fecha_inventario.'%" AND codigo = ?', [$request->ref_producto]);
        $registros = DB::select("SELECT * FROM informe_medicamentos WHERE ref = '$request->ref_producto' AND fecha = '$request->fecha_inventario'");
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
                $diferencia = ($sumaCant - $saldo_geminus[0]->cantidad);
                $informeMedicamentos = new InformeMedicamento();
                $informeMedicamentos->ref = $request->ref_producto;
                $informeMedicamentos->nombre_producto = $saldo_geminus[0]->descripcion;
                $informeMedicamentos->saldo_geminus = $saldo_geminus[0]->cantidad;
                $informeMedicamentos->cantidad = $sumaCant;
                $informeMedicamentos->conteo = $request->cantidad;
                $informeMedicamentos->diferencia = $diferencia;
                $informeMedicamentos->id_calendario = $fecha_calendario[0]->id;
                $informeMedicamentos->year = $fecha_calendario[0]->year;
                $informeMedicamentos->mes = $fecha_calendario[0]->nombre_mes;
                $informeMedicamentos->fecha = $fecha_calendario[0]->fecha;
                $informeMedicamentos->fecha_vencimiento = $request->fecha;
                $informeMedicamentos->observaciones = $request->observacion;
                $informeMedicamentos->costo_unitario = $saldo_geminus[0]->costo_unitario;
                $informeMedicamentos->costo_total = $saldo_geminus[0]->costo_total;
                $informeMedicamentos->costo_diferencia = ($informeMedicamentos->diferencia * $saldo_geminus[0]->costo_unitario);
                $informeMedicamentos->save();
            } else {
                $informeMedicamentos = new InformeMedicamento();
                $informeMedicamentos->ref = $request->ref_producto;
                $informeMedicamentos->nombre_producto = $saldo_geminus[0]->descripcion;
                $informeMedicamentos->saldo_geminus = $saldo_geminus[0]->cantidad;
                $informeMedicamentos->cantidad = $request->cantidad;
                $informeMedicamentos->conteo = $request->cantidad;
                $diferencia = ($request->cantidad - $saldo_geminus[0]->cantidad);
                $informeMedicamentos->diferencia = $diferencia;
                $informeMedicamentos->id_calendario = $fecha_calendario[0]->id;
                $informeMedicamentos->year = $fecha_calendario[0]->year;
                $informeMedicamentos->mes = $fecha_calendario[0]->nombre_mes;
                $informeMedicamentos->fecha = $fecha_calendario[0]->fecha;
                $informeMedicamentos->fecha_vencimiento = $request->fecha;
                $informeMedicamentos->observaciones = $request->observacion;
                $informeMedicamentos->costo_unitario = $saldo_geminus[0]->costo_unitario;
                $informeMedicamentos->costo_total = $saldo_geminus[0]->costo_total;
                $informeMedicamentos->costo_diferencia = ($informeMedicamentos->diferencia * $informeMedicamentos->costo_unitario);
                $informeMedicamentos->save();
            }
            return response()->json($informeMedicamentos, 200);
            //return $saldo_geminus[0]->descripcion;
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
