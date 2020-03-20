<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InfoGranja;
use App\GranjasAsociadasCiclos;
use App\Http\Controllers\API\InformeAuditoriaController;
use DB;

class OfflineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $informe = new InformeAuditoriaController();

        $offline = [];

        $offline['informes'] = $informe->index();

        $offline['calificaciones'] = [];
        $offline['categorias'] = [];
        $offline['respuestas'] = [];

        foreach ($offline['informes']->original as $key) {

            $id = $key->id;

            $calificaciones['proceso_macro'] = DB::select(
                'SELECT SUM(`calificacion_subproceso`) as valor_macro, 
                    id_proceso_macro as proceso_macro 
                FROM `calificacion_granjas` 
                WHERE `id_info_granja` = ? GROUP BY id_proceso_macro', [$id]);

            $general = DB::select(
                'SELECT (SUM(cg.calificacion_subproceso) * procesos_macros.porcentaje_valor_macro) AS valor 
                FROM calificacion_granjas cg 
                INNER JOIN procesos_macros ON procesos_macros.id = cg.id_proceso_macro 
                WHERE id_info_granja = ? 
                GROUP BY cg.id_proceso_macro', [$id]);

            $registro_granja = InfoGranja::where('id', $id)->first();

            $granja = DB::select('SELECT nombre_granja FROM granjas where id = ?', [$registro_granja->granja]);

            $ciclos = GranjasAsociadasCiclos::where('granja',$granja[0]->nombre_granja)->first();

            $sumatoria = 0;

            foreach ($general as $item) {
                $sumatoria += $item->valor;
            }

            switch ($ciclos->tipo_ciclo) {
                case '1':
                    $sumatoria += 1.2;
                    break;
                case '2':
                    $sumatoria += 3.22;
                    break;
                case '3':
                    $sumatoria += 3.02;
                    break;
                case '1,2':
                    $sumatoria += 0.7;
                    break;
                case '1,3':
                    $sumatoria += 0.5;
                    break;
                case '2,3':
                    $sumatoria += 2.52;
                    break;
                default:
                    break;
            }

            $calificaciones['cercafe'] = DB::select(
                'SELECT AVG(suma_indicador_subproceso) as valor_macro, 
                    id_proceso_macro as proceso_macro 
                FROM `calificacion_granjas` 
                WHERE `id_info_granja` != ? 
                GROUP BY id_proceso_macro', [$id]);
            
            $calificaciones['general'] = $sumatoria;
            $calificaciones['ciclo'] = $ciclos->tipo_ciclo;
            $calificaciones['nombre_granja'] = $granja[0]->nombre_granja;
            $calificaciones['id'] = $id;


            array_push($offline['calificaciones'], $calificaciones);

            foreach ($calificaciones['proceso_macro'] as $value) {

                $macro = $value->proceso_macro;

                $response['calificacion_macro'] = DB::select(
                    'SELECT SUM(`calificacion_subproceso`) as valor_macro
                    FROM `calificacion_granjas` 
                    WHERE `id_info_granja` = ? AND calificacion_granjas.id_proceso_macro = ? 
                    GROUP BY id_proceso_macro', [$id , $macro]);
        
                $response['subprocesos'] = DB::select(
                    'SELECT cg.subproceso as nombre, 
                        cg.suma_indicador_subproceso as calificacion, p.id 
                    FROM calificacion_granjas cg, porcentajes p 
                    WHERE cg.id_info_granja = ? 
                        AND cg.id_proceso_macro = ? 
                        AND p.id_proceso_macro = cg.id_proceso_macro 
                    GROUP BY cg.subproceso', [$id, $macro]);

                $response['id'] = $id;
                $response['macro'] = $macro;

                array_push($offline['categorias'], $response);

                foreach ($response['subprocesos'] as $subprocesos) {

                    $subproceso = $subprocesos->id;

                    $respuestas['respuestas'] = DB::select(
                        'SELECT pg.criterio as preguntas, va.calificacion as respuestas 
                        FROM valores_auditorias va, preguntas pg 
                        WHERE id_porcentaje_subproceso = ? AND id_info_granja = ? 
                                AND pg.id = va.id_pregunta', 
                        [$subproceso, $id]
                    );

                    $respuestas['id'] = $id;
                    $respuestas['subproceso'] = $subproceso;

                    array_push($offline['respuestas'], $respuestas);
                }

            }

        }

        return response()->json($offline, 200);

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
