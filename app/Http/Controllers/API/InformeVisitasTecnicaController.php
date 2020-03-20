<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\VisitasTecnica;
use DB;

class InformeVisitasTecnicaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = DB::table('informe_visitas_tecnica')
        ->join('granjas', 'informe_visitas_tecnica.id_granja', '=', 'granjas.id')
        ->join('fuente_agua', 'informe_visitas_tecnica.id_fuente_agua', '=', 'fuente_agua.id')
        ->join('suministro_agua', 'informe_visitas_tecnica.id_suministro_agua', '=', 'suministro_agua.id')
        ->select('informe_visitas_tecnica.*', 'fuente_agua.fuente', 'suministro_agua.suminsitro', 'granjas.nombre_granja')
        ->get();
        return response($informe, 200);
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
        try {
            $informe = new VisitasTecnica();
            $informe->fecha = $request->fecha;
            $informe->id_granja = $request->granja;
            $granja = DB::select("SELECT id, nombre_granja FROM granjas WHERE id = '$request->granja'");
            $informe->granja_nombre = $granja[0]->nombre_granja;
            $informe->admin_granja = $request->admin_granja;
            $informe->asociado = $request->asociado;
            $informe->lugar = $request->lugar;
            $informe->id_fuente_agua = (int) $request->fuente_agua;
            $informe->id_suministro_agua = (int) $request->suministro_agua;
            $informe->medicion_accupoint_gestacion1 = $request->medicion_accupoint_gestacion1;
            $informe->medicion_accupoint_gestacion2 = $request->medicion_accupoint_gestacion2;
            $informe->medicion_accupoint_gestacion3 = $request->medicion_accupoint_gestacion3;
            $informe->medicion_accupoint_maternidad1 = $request->medicion_accupoint_maternidad1;
            $informe->medicion_accupoint_maternidad2 = $request->medicion_accupoint_maternidad2;
            $informe->medicion_accupoint_maternidad3 = $request->medicion_accupoint_maternidad3;
            $informe->medicion_accupoint_maternidad4 = $request->medicion_accupoint_maternidad4;
            $informe->sitio_muestra_gestacion1 = $request->sitio_muestra_gestacion1;
            $informe->sitio_muestra_gestacion2 = $request->sitio_muestra_gestacion2;
            $informe->sitio_muestra_gestacion3 = $request->sitio_muestra_gestacion3;
            $informe->sitio_muestra_maternidad1 = $request->sitio_muestra_maternidad1;
            $informe->sitio_muestra_maternidad2 = $request->sitio_muestra_maternidad2;
            $informe->sitio_muestra_maternidad3 = $request->sitio_muestra_maternidad3;
            $informe->sitio_muestra_maternidad4 = $request->sitio_muestra_maternidad4;
            $informe->observacion = $request->observacion;
            $informe->recomendaciones = $request->recomendaciones;
            $tipo_produccion = "";
            switch (count($request->tipo_produccion)) {
                case 1:
                    $tipo_produccion = $request->tipo_produccion[0]['tipo'];
                    break;
                case 2:
                    $tipo_produccion = $request->tipo_produccion[0]['tipo'] . ',' . $request->tipo_produccion[1]['tipo'];
                break;
                case 3:
                      $tipo_produccion = $request->tipo_produccion[0]['tipo'] . ',' . $request->tipo_produccion[1]['tipo'] . ',' . $request->tipo_produccion[2]['tipo'];
                break;
                default:
                    $tipo_produccion = "";
                    break;
            }
            $informe->tipo_produccion = $tipo_produccion;
            $informe->save();
            return response($informe, 201);
        } catch(Exception $ex) {
            return response()->json($ex->message, 500);
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
