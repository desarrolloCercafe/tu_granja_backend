<?php

namespace App\Http\Controllers\API;

use App\ReporteCalidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ReporteCalidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $reporte = new ReporteCalidad();
        $reporte->fecha = $request->fecha;
        $reporte->op = $request->op;
        $reporte->turno = $request->turno;
        $reporte->num_bache = $request->numBache;
        $reporte->hora = $request->hora;
        $reporte->minutos = $request->minuto;
        $reporte->granulometria = $request->granulometria;
        $reporte->retencion = $request->retencion;
        $reporte->desv_estandar = $request->desviacionEstandar;
        $reporte->hum_terminado = $request->humedadTerminado;
        $reporte->finos = $request->finos;
        $reporte->durabilidad = $request->durabilidad;
        $reporte->temp_enfriadora = $request->tempEnfriadora;
        $reporte->temp_ambiente = $request->tempAmbiente;
        $reporte->dureza = $request->dureza;
        $reporte->hum_premezcla = $request->humedadPremezcla;
        $reporte->hum_acondicionado = $request->humedadAcondicionado;
        $reporte->carga = $request->carga;
        $reporte->temperatura = $request->temperatura;
        $reporte->amperaje1 = $request->amperaje1;
        $reporte->amperaje2 = $request->amperaje2;
        $reporte->vapor_linea = $request->vaporLinea;
        $reporte->vapor_reducido = $request->vaporReducido;
        $reporte->apertura_valvula = $request->aperturaValvula;
        $reporte->analista = $request->analista;
        $reporte->observacion = $request->observacion;
        $reporte->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ReporteCalidad  $reporteCalidad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reporte = DB::select(
            'SELECT rp.*,
                (CONCAT(SUBSTRING(rp.fecha,3,2), SUBSTRING(rp.fecha,6,2), SUBSTRING(rp.fecha,9,2))) as fechaL,
                c.ref_concentrado as dieta, op.consecutivo_dieta as consDieta, 
                op.consecutivo, u.nombre_completo as analista
            FROM reporte_calidad rp 
            INNER JOIN ordenes_produccion op ON op.id = rp.op 
            INNER JOIN concentrados c ON c.id = op.id_dieta
            INNER JOIN users u ON u.id = rp.analista WHERE rp.id = ?', [$id]);

        return response()->json($reporte[0], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ReporteCalidad  $reporteCalidad
     * @return \Illuminate\Http\Response
     */
    public function edit(ReporteCalidad $reporteCalidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ReporteCalidad  $reporteCalidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reporte = ReporteCalidad::find($id);
        $reporte->fecha = $request->fecha;
        $reporte->op = $request->op;
        $reporte->turno = $request->turno;
        $reporte->num_bache = $request->numBache;
        $reporte->hora = $request->hora;
        $reporte->minutos = $request->minuto;
        $reporte->granulometria = $request->granulometria;
        $reporte->retencion = $request->retencion;
        $reporte->desv_estandar = $request->desviacionEstandar;
        $reporte->hum_terminado = $request->humedadTerminado;
        $reporte->finos = $request->finos;
        $reporte->durabilidad = $request->durabilidad;
        $reporte->temp_enfriadora = $request->tempEnfriadora;
        $reporte->temp_ambiente = $request->tempAmbiente;
        $reporte->dureza = $request->dureza;
        $reporte->hum_premezcla = $request->humedadPremezcla;
        $reporte->hum_acondicionado = $request->humedadAcondicionado;
        $reporte->carga = $request->carga;
        $reporte->temperatura = $request->temperatura;
        $reporte->amperaje1 = $request->amperaje1;
        $reporte->amperaje2 = $request->amperaje2;
        $reporte->vapor_linea = $request->vaporLinea;
        $reporte->vapor_reducido = $request->vaporReducido;
        $reporte->apertura_valvula = $request->aperturaValvula;
        $reporte->analista = $request->analista;
        $reporte->observacion = $request->observacion;
        $reporte->save();

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ReporteCalidad  $reporteCalidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReporteCalidad $reporteCalidad)
    {
        //
    }
}
