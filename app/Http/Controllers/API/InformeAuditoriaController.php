<?php

namespace App\Http\Controllers\API;

use App\Granjas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Preguntas;
use App\Porcentajes;
use App\ProcesosMacros;
use App\ValoresAuditoria;
use App\InfoGranja;
use App\GranjasAsociadasCiclos;
use DB;

class InformeAuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $informe = DB::select(
            'SELECT ig.id, ig.fecha as fechaInicial, 
                    ig.fecha as fechaFinal, g.nombre_granja 
            FROM info_granjas ig 
            INNER JOIN granjas g ON g.id = ig.granja'
        );

        return response()->json($informe, 200);
    }

    public function showCalificaciones(Request $request){

        if($request){
            $calificaciones = [];

            $calificaciones['proceso_macro'] = DB::select(
                'SELECT SUM(`calificacion_subproceso`) as valor_macro, 
                    id_proceso_macro as proceso_macro 
                FROM `calificacion_granjas` 
                WHERE `id_info_granja` = ? GROUP BY id_proceso_macro', [$request[0]]);

            $general = DB::select(
                'SELECT (SUM(cg.calificacion_subproceso) * procesos_macros.porcentaje_valor_macro) AS valor FROM calificacion_granjas cg INNER JOIN procesos_macros ON procesos_macros.id = cg.id_proceso_macro WHERE id_info_granja = ? GROUP BY cg.id_proceso_macro', [$request[0]]);

            $registro_granja = InfoGranja::where('id', $request[0])->first();

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
                'SELECT AVG(`calificacion_subproceso`) as valor_macro, 
                    id_proceso_macro as proceso_macro 
                FROM `calificacion_granjas` 
                WHERE `id_info_granja` != ? 
                GROUP BY id_proceso_macro', [$request[0]]);
            
            $calificaciones['general'] = $sumatoria;
            $calificaciones['ciclo'] = $ciclos->tipo_ciclo;
            $calificaciones['nombre_granja'] = $granja[0]->nombre_granja;

            return response()->json($calificaciones, 200);
        }
    }

    public function showCategorias(Request $request){

        $response['calificacion_macro'] = DB::select(
            'SELECT SUM(`calificacion_subproceso`) as valor_macro
            FROM `calificacion_granjas` 
            WHERE `id_info_granja` = ? AND calificacion_granjas.id_proceso_macro = ? 
            GROUP BY id_proceso_macro', [$request->id , $request->macro]);

        $response['subprocesos'] = DB::select(
            'SELECT cg.subproceso as nombre, 
                cg.suma_indicador_subproceso as calificacion, p.id 
            FROM calificacion_granjas cg, porcentajes p 
            WHERE cg.id_info_granja = ? 
                AND cg.id_proceso_macro = ? 
                AND p.id_proceso_macro = cg.id_proceso_macro 
            GROUP BY cg.subproceso', [$request->id, $request->macro]);

        return response()->json($response, 200);

    }

    public function respuestasSubProceso(Request $request){

        $response['respuestas'] = DB::select(
            'SELECT pg.criterio as preguntas, va.calificacion as respuestas 
            FROM valores_auditorias va, preguntas pg 
            WHERE id_porcentaje_subproceso = ? AND id_info_granja = ? 
                    AND pg.id = va.id_pregunta', 
            [$request->subproceso, $request->granja]
        );

        return response()->json($response, 200);

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
        //return response()->json($request, 200);
        
        if ($request) {

            $infoGranja = DB::select(
                'SELECT id FROM info_granjas WHERE granja = ? AND fecha = ?', 
                [$request[0]["datosGranja"]["granja"], $request[0]["datosGranja"]["fecha"]]
            );

            //return response()->json($infoGranja, 200);

            if(count($infoGranja)){

                //return response()->json("ingresa", 200);
                
                for ($i=0; $i < count($request[0]["preguntas"]) ; $i++) {
                    //return response()->json($request[0]["preguntas"][$i]["id_pregunta"]);
                    DB::delete(
                        'DELETE FROM valores_auditorias WHERE id_pregunta = ? AND id_info_granja = ?', 
                        [$request[0]["preguntas"][$i]["id_pregunta"], $infoGranja[0]->id]
                    );
                }

            }else{
                $granja = new InfoGranja();
                $granja->fecha = $request[0]["datosGranja"]["fecha"];
                $granja->granja = $request[0]["datosGranja"]["granja"];
                $granja->asociado = $request[0]["datosGranja"]["asociado"];
                $granja->ubicacion = $request[0]["datosGranja"]["ubicacion"];
                $granja->altura_mar = $request[0]["datosGranja"]["altura"];
                $granja->save();

                $infoGranja = DB::select(
                    'SELECT id FROM info_granjas WHERE granja = ? AND fecha = ?', 
                    [$request[0]["datosGranja"]["granja"], $request[0]["datosGranja"]["fecha"]]
                );
            }

            $preguntas = $request[0]["preguntas"];
            $preguntas_db = [];
            for ($i=0; $i<count($preguntas); $i++) {
                    array_push($preguntas_db, DB::table('preguntas')
                    ->where('preguntas.id', $preguntas[$i]["id_pregunta"])
                    ->join('porcentajes', 'preguntas.id_porcentaje', '=', 'porcentajes.id')
                    ->join('porcentaje_preguntas', 'preguntas.id', '=', 'porcentaje_preguntas.id')
                    ->join('procesos_macros', 'porcentaje_preguntas.id_proceso_macro', '=', 'procesos_macros.id')
                    ->select('preguntas.*', 'porcentajes.*', 'porcentaje_preguntas.*', 'procesos_macros.*')
                    ->get());
            }
            $idGranja = $request[0]["datosGranja"]["granja"];
            $fecha = $request[0]["datosGranja"]["fecha"];
            $tmp = DB::select("SELECT * FROM info_granjas WHERE granja = '$idGranja' AND fecha = '$fecha'");
            for ($j=0; $j <count($preguntas_db); $j++) {
                $valoresAuditoria = new ValoresAuditoria();
                $valoresAuditoria->id_pregunta = $preguntas_db[$j][0]->id_pregunta;
                $valoresAuditoria->id_proceso_macro = $preguntas_db[$j][0]->id_proceso_macro;
                $valoresAuditoria->id_porcentaje_subproceso = $preguntas_db[$j][0]->id_porcentaje;
                $valoresAuditoria->id_info_granja = $tmp[0]->id;
                $valoresAuditoria->calificacion = $preguntas[$j]["calificacion"];
                $valoresAuditoria->indicador =  number_format(($valoresAuditoria->calificacion * $preguntas_db[$j][0]->porc_valor_pregunta), 2, '.', ',');
                $valoresAuditoria->max =  number_format((5 * $preguntas_db[$j][0]->porc_valor_pregunta), 2, '.', ',');
                $valoresAuditoria->diferencia =  $valoresAuditoria->max - $valoresAuditoria->indicador;
                $valoresAuditoria->promedio =  $valoresAuditoria->diferencia;
                if(isset($preguntas[$j]["observacion"])){
                    $valoresAuditoria->observacion = $preguntas[$j]["observacion"];
                }
                $valoresAuditoria->save();
            }
            
            return response()->json("Ok", 200);
            
        }else {
            return response()->json(["msg" => "No se encontro un cuerpo en la peticion"], 404);
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
