<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CalificacionGranja;
use DB;
use Illuminate\Support\Facades\Mail;

class CalificacionGranjaController extends Controller
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
        //return response()->json($request, 200);
        /*$ciclosGranja = $request[0]["ciclosGranja"][0]["ciclo"][0];*/

        $ciclosGranja = $request[0]["ciclosGranja"];
        $idGranja = $request[0]["datosGranja"]["granja"];
        $fecha = $request[0]["datosGranja"]["fecha"];
        $array = [];
        /*$infoGranja = DB::table('info_granjas')
        ->where('info_granjas.granja', $idGranja)
        ->select('info_granjas.id')
        ->get();*/
        $infoGranja = DB::select('SELECT id FROM info_granjas WHERE granja = ? AND fecha = ?', [$idGranja, $fecha]);
        // return response()->json($infoGranja, 200);

        //Anterior condicional: in_array("1", $ciclosGranja) && in_array("2", $ciclosGranja) && !in_array("3", $ciclosGranja)
        if ($ciclosGranja == '1,2') {

            //Cria precebo ciclo granja

             $idInfoGranja = $infoGranja[0]->id;
                    //Si llega a este punto se procede a sumar los tres subprocesos para sacar la calificacion de hembras de remplazo
                    $sumaSubprocesoRecepcion = 0;
                    $sumaSubprocesoManejoRC = 0;
                    $sumaSubprocesoMC = 0;
                    $sumaReproductoresCalen = 0;
                    $sumaEstimulacionDetecCa = 0;
                    $sumaInsemincacion = 0;
                    $sumaMReproHemC = 0;
                    $sumaManejoHC = 0;
                    $sumaManejoRegisC = 0;
                    $sumaAlimentacionHC = 0;
                    $sumaAntesParto = 0;
                    $sumaHembraParto = 0;
                    $sumaLechonParto = 0;
                    $sumaAlimentacionC = 0;
                    $sumaManejoCerdadL = 0;
                    $sumaManejoLechonesC = 0;
                    $sumaPracticasAseo = 0;
                    $sumaRegistrosC = 0;
                    $sumaAguaPrecebo = 0;
                    $sumaAlimentacionPrecebo = 0;
                    $sumaManejoPrecebo = 0;
                    $sumaAlojamientoPrecebo = 0;
                    $sumaRegistrosPrecebo = 0;
                    $sumaBodegaG = 0;
                    $sumaBioseguridadG = 0;
                    $sumaSeguridadIndG = 0;
                    $sumaManejoAmbientalG = 0;
                    $sumaOficinaG = 0;
                    $sumaBienestartG = 0;

                      $recepcionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 1 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCria);
                            $manejoReproductivoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 2 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproductivoC);
                            $manejoCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 3 AND id_info_granja = ' $idInfoGranja'");
                            array_push($array, $manejoCria);
                            $reproductoresCalentadores = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 4 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $reproductoresCalentadores);
                            $estimulacionDetecCalor = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 5 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $estimulacionDetecCalor);
                            $inseminacion = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 6 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $inseminacion);

                            $manejoReproHCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 7 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproHCria);
                             $manejoHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 8 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoHembrasC);
                            $manejoRegistrosC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 9 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoRegistrosC);
                            $alimentacionHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 10 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionHembrasC);
                            $antesDelPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 11 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $antesDelPartoC);
                            $hembraPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 12 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $hembraPartoC);
                            $lechoPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 13 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $lechoPartoC);
                            $alimentacionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 14 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionCria);
                             $manejoCerdaLactanciaC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 15 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoCerdaLactanciaC);
                             $manejoDeLechonesC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 16 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoDeLechonesC);
                             $practicasAseoManejoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 17 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $practicasAseoManejoC);
                            $registrosCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 18 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $registrosCria);
                                $bodegaG = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 27 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bodegaG);
                                    $aguaPrecebo = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 19 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $aguaPrecebo);

                                $alimentacionPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 20 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $alimentacionPrecebo);

                                $manejoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 21 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoPrecebo);

                                $alojamientoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 22 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $alojamientoPrecebo);
                                $registrosPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 23 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $registrosPrecebo);
                                $bioseguridad = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 28 AND id_info_granja = $idInfoGranja");
                                array_push($array, $bioseguridad);
                                $seguridadIndustrial = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 29 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $seguridadIndustrial);
                                $manejoAmbiental = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 30 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoAmbiental);
                                $oficinaGeneral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 31 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $oficinaGeneral);
                                $bienestarLaboral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 32 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bienestarLaboral);

                    for ($i=0; $i <count($array); $i++) {
                        $calificacion = new CalificacionGranja();
                            foreach ($array[$i] as $item) {
                                  if ($item->id_porcentaje_subproceso == 19) {
                                    $sumaAguaPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Agua_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAguaPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.2 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 20) {
                                    $sumaAlimentacionPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 21) {
                                    $sumaManejoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 22) {
                                    $sumaAlojamientoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alojamiento_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlojamientoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }  else if ($item->id_porcentaje_subproceso == 23) {
                                    $sumaRegistrosPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Registros_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }
                               else  if  ($item->id_porcentaje_subproceso == 1) {
                                    $sumaSubprocesoRecepcion += $item->indicador;
                                    $calificacion->subproceso = 'Recepcion Cria';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoRecepcion;
                                    $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                    $calificacion->id_info_granja = $idInfoGranja;
                                    $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 2) {
                                     $sumaSubprocesoManejoRC += $item->indicador;
                                     $calificacion->subproceso = 'Manejo reproductivo';
                                     $calificacion->suma_indicador_subproceso = $sumaSubprocesoManejoRC;
                                      $calificacion->calificacion_subproceso = number_format((0.5 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                      $calificacion->id_info_granja = $idInfoGranja;
                                      $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 3) {
                                    $sumaSubprocesoMC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoMC;
                                     $calificacion->calificacion_subproceso = number_format((0.4 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 4) {
                                    $sumaReproductoresCalen += $item->indicador;
                                    $calificacion->subproceso = 'Reproductores calentadores';
                                    $calificacion->suma_indicador_subproceso = $sumaReproductoresCalen;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 2;
                                } else if ($item->id_porcentaje_subproceso == 5) {
                                    $sumaEstimulacionDetecCa += $item->indicador;
                                    $calificacion->subproceso = 'Estimulación y detección de calores_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaEstimulacionDetecCa;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 6) {
                                    $sumaInsemincacion += $item->indicador;
                                    $calificacion->subproceso = 'Inseminación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaInsemincacion;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 7) {
                                    $sumaMReproHemC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo Reproductivo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaMReproHemC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 8) {
                                    $sumaManejoHC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoHC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                else if ($item->id_porcentaje_subproceso == 9) {
                                    $sumaManejoRegisC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoRegisC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }   else if ($item->id_porcentaje_subproceso == 10) {
                                    $sumaAlimentacionHC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionHC;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                 else if ($item->id_porcentaje_subproceso == 11) {
                                    $sumaAntesParto += $item->indicador;
                                    $calificacion->subproceso = 'Antes del Parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAntesParto;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                }  else if ($item->id_porcentaje_subproceso == 12) {
                                    $sumaHembraParto += $item->indicador;
                                    $calificacion->subproceso = 'Hembra en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaHembraParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 13) {
                                    $sumaLechonParto += $item->indicador;
                                    $calificacion->subproceso = 'Lechon en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaLechonParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 14) {
                                    $sumaAlimentacionC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionC;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 15) {
                                    $sumaManejoCerdadL += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de la cerda en lactancia_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCerdadL;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 16) {
                                    $sumaManejoLechonesC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de los lechones_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoLechonesC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 17) {
                                    $sumaPracticasAseo += $item->indicador;
                                    $calificacion->subproceso = 'Practicas de aseo y manejo_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaPracticasAseo;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 18) {
                                    $sumaRegistrosC += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 27) {
                                    $sumaBodegaG += $item->indicador;
                                    $calificacion->subproceso = 'BODEGA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBodegaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 7;
                                } else if ($item->id_porcentaje_subproceso == 28) {
                                    $sumaBioseguridadG += $item->indicador;
                                    $calificacion->subproceso = 'BIOSEGURIDAD_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBioseguridadG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 8;
                                } else if ($item->id_porcentaje_subproceso == 29) {
                                    $sumaSeguridadIndG += $item->indicador;
                                    $calificacion->subproceso = 'SEGURIDAD INDUSTRIAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaSeguridadIndG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 9;
                                }  else if ($item->id_porcentaje_subproceso == 30) {
                                    $sumaManejoAmbientalG += $item->indicador;
                                    $calificacion->subproceso = 'MANEJO AMBIENTAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoAmbientalG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 10;
                                }  else if ($item->id_porcentaje_subproceso == 31) {
                                    $sumaOficinaG += $item->indicador;
                                    $calificacion->subproceso = 'OFICINA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaOficinaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 11;
                                } else if ($item->id_porcentaje_subproceso == 32) {
                                    $sumaBienestartG+= $item->indicador;
                                    $calificacion->subproceso = 'BIENESTAR LABORAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBienestartG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 12;
                                }

                                $calificacion->save();
                            }
                        }
                        //$this->sendCorreo($idGranja, $fecha);
                        return response()->json(["msg" => "Procesado correctamente"], 200);

            //Anterior condicional: in_array("1", $ciclosGranja) && !in_array("2", $ciclosGranja) && !in_array("3", $ciclosGranja)
        } else if  ($ciclosGranja == '1') {
            //Si cumple con esta condicion es porque el cicilo de la granja es solo cria.
               //Si el request ciclosGranja en la posicion 0 es igual a 1 esto quiere decir que es solo cria, y se procede a tomar como el 100% de la calificacion
            //Calificacion hembras de remplazo
                  $idInfoGranja = $infoGranja[0]->id;
                    //Si llega a este punto se procede a sumar los tres subprocesos para sacar la calificacion de hembras de remplazo
                    $sumaSubprocesoRecepcion = 0;
                    $sumaSubprocesoManejoRC = 0;
                    $sumaSubprocesoMC = 0;
                    $sumaReproductoresCalen = 0;
                    $sumaEstimulacionDetecCa = 0;
                    $sumaInsemincacion = 0;
                    $sumaMReproHemC = 0;
                    $sumaManejoHC = 0;
                    $sumaManejoRegisC = 0;
                    $sumaAlimentacionHC = 0;
                    $sumaAntesParto = 0;
                    $sumaHembraParto = 0;
                    $sumaLechonParto = 0;
                    $sumaAlimentacionC = 0;
                    $sumaManejoCerdadL = 0;
                    $sumaManejoLechonesC = 0;
                    $sumaPracticasAseo = 0;
                    $sumaRegistrosC = 0;
                    $sumaBodegaG = 0;
                    $sumaBioseguridadG = 0;
                    $sumaSeguridadIndG = 0;
                    $sumaManejoAmbientalG = 0;
                    $sumaOficinaG = 0;
                    $sumaBienestartG = 0;

                      $recepcionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 1 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCria);
                            $manejoReproductivoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 2 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproductivoC);
                            $manejoCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 3 AND id_info_granja = ' $idInfoGranja'");
                            array_push($array, $manejoCria);
                            $reproductoresCalentadores = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 4 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $reproductoresCalentadores);
                            $estimulacionDetecCalor = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 5 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $estimulacionDetecCalor);
                            $inseminacion = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 6 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $inseminacion);

                            $manejoReproHCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 7 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproHCria);
                             $manejoHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 8 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoHembrasC);
                            $manejoRegistrosC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 9 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoRegistrosC);
                            $alimentacionHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 10 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionHembrasC);
                            $antesDelPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 11 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $antesDelPartoC);
                            $hembraPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 12 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $hembraPartoC);
                            $lechoPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 13 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $lechoPartoC);
                            $alimentacionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 14 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionCria);
                             $manejoCerdaLactanciaC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 15 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoCerdaLactanciaC);
                             $manejoDeLechonesC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 16 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoDeLechonesC);
                             $practicasAseoManejoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 17 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $practicasAseoManejoC);
                            $registrosCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 18 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $registrosCria);
                                $bodegaG = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 27 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bodegaG);
                                $bioseguridad = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 28 AND id_info_granja = $idInfoGranja");
                                array_push($array, $bioseguridad);
                                $seguridadIndustrial = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 29 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $seguridadIndustrial);
                                $manejoAmbiental = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 30 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoAmbiental);
                                $oficinaGeneral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 31 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $oficinaGeneral);
                                $bienestarLaboral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 32 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bienestarLaboral);


                    for ($i=0; $i <count($array); $i++) {
                        $calificacion = new CalificacionGranja();
                            foreach ($array[$i] as $item) {
                                if  ($item->id_porcentaje_subproceso == 1) {
                                    $sumaSubprocesoRecepcion += $item->indicador;
                                    $calificacion->subproceso = 'Recepcion Cria';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoRecepcion;
                                    $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                    $calificacion->id_info_granja = $idInfoGranja;
                                    $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 2) {
                                     $sumaSubprocesoManejoRC += $item->indicador;
                                     $calificacion->subproceso = 'Manejo reproductivo';
                                     $calificacion->suma_indicador_subproceso = $sumaSubprocesoManejoRC;
                                      $calificacion->calificacion_subproceso = number_format((0.5 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                      $calificacion->id_info_granja = $idInfoGranja;
                                      $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 3) {
                                    $sumaSubprocesoMC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoMC;
                                     $calificacion->calificacion_subproceso = number_format((0.4 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 4) {
                                    $sumaReproductoresCalen += $item->indicador;
                                    $calificacion->subproceso = 'Reproductores calentadores';
                                    $calificacion->suma_indicador_subproceso = $sumaReproductoresCalen;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 2;
                                } else if ($item->id_porcentaje_subproceso == 5) {
                                    $sumaEstimulacionDetecCa += $item->indicador;
                                    $calificacion->subproceso = 'Estimulación y detección de calores_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaEstimulacionDetecCa;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 6) {
                                    $sumaInsemincacion += $item->indicador;
                                    $calificacion->subproceso = 'Inseminación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaInsemincacion;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 7) {
                                    $sumaMReproHemC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo Reproductivo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaMReproHemC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 8) {
                                    $sumaManejoHC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoHC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                else if ($item->id_porcentaje_subproceso == 9) {
                                    $sumaManejoRegisC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoRegisC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }   else if ($item->id_porcentaje_subproceso == 10) {
                                    $sumaAlimentacionHC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionHC;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                 else if ($item->id_porcentaje_subproceso == 11) {
                                    $sumaAntesParto += $item->indicador;
                                    $calificacion->subproceso = 'Antes del Parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAntesParto;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                }  else if ($item->id_porcentaje_subproceso == 12) {
                                    $sumaHembraParto += $item->indicador;
                                    $calificacion->subproceso = 'Hembra en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaHembraParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 13) {
                                    $sumaLechonParto += $item->indicador;
                                    $calificacion->subproceso = 'Lechon en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaLechonParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 14) {
                                    $sumaAlimentacionC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionC;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 15) {
                                    $sumaManejoCerdadL += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de la cerda en lactancia_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCerdadL;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 16) {
                                    $sumaManejoLechonesC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de los lechones_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoLechonesC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 17) {
                                    $sumaPracticasAseo += $item->indicador;
                                    $calificacion->subproceso = 'Practicas de aseo y manejo_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaPracticasAseo;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 18) {
                                    $sumaRegistrosC += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 27) {
                                    $sumaBodegaG += $item->indicador;
                                    $calificacion->subproceso = 'BODEGA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBodegaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 7;
                                } else if ($item->id_porcentaje_subproceso == 28) {
                                    $sumaBioseguridadG += $item->indicador;
                                    $calificacion->subproceso = 'BIOSEGURIDAD_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBioseguridadG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 8;
                                } else if ($item->id_porcentaje_subproceso == 29) {
                                    $sumaSeguridadIndG += $item->indicador;
                                    $calificacion->subproceso = 'SEGURIDAD INDUSTRIAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaSeguridadIndG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 9;
                                }  else if ($item->id_porcentaje_subproceso == 30) {
                                    $sumaManejoAmbientalG += $item->indicador;
                                    $calificacion->subproceso = 'MANEJO AMBIENTAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoAmbientalG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 10;
                                }  else if ($item->id_porcentaje_subproceso == 31) {
                                    $sumaOficinaG += $item->indicador;
                                    $calificacion->subproceso = 'OFICINA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaOficinaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 11;
                                } else if ($item->id_porcentaje_subproceso == 32) {
                                    $sumaBienestartG+= $item->indicador;
                                    $calificacion->subproceso = 'BIENESTAR LABORAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBienestartG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 12;
                                }

                                $calificacion->save();
                            }
                        }
                        //$this->sendCorreo($idGranja, $fecha);
                        return response()->json(["msg" => "Procesado correctamente"], 200);

            //Anterior condicional: in_array("1", $ciclosGranja) && in_array("2", $ciclosGranja) && in_array("3", $ciclosGranja)
        } else if ($ciclosGranja == '1,2,3') {

            //Ciclo completo granjas
            //1. Cria
                    $idInfoGranja = $infoGranja[0]->id;
                    //Si llega a este punto se procede a sumar los tres subprocesos para sacar la calificacion de hembras de remplazo
                    $sumaSubprocesoRecepcion = 0;
                    $sumaSubprocesoManejoRC = 0;
                    $sumaSubprocesoMC = 0;
                    $sumaReproductoresCalen = 0;
                    $sumaEstimulacionDetecCa = 0;
                    $sumaInsemincacion = 0;
                    $sumaMReproHemC = 0;
                    $sumaManejoHC = 0;
                    $sumaManejoRegisC = 0;
                    $sumaAlimentacionHC = 0;
                    $sumaAntesParto = 0;
                    $sumaHembraParto = 0;
                    $sumaLechonParto = 0;
                    $sumaAlimentacionC = 0;
                    $sumaManejoCerdadL = 0;
                    $sumaManejoLechonesC = 0;
                    $sumaPracticasAseo = 0;
                    $sumaRegistrosC = 0;
                    $sumaAguaPrecebo = 0;
                    $sumaAlimentacionPrecebo = 0;
                    $sumaManejoPrecebo = 0;
                    $sumaAlojamientoPrecebo = 0;
                    $sumaRegistrosPrecebo = 0;
                    $sumaRecepcionCeba = 0;
                    $sumaManejoCeba = 0;
                    $sumaRegistrosCeba = 0;
                    $sumaBodegaG = 0;
                    $sumaBioseguridadG = 0;
                    $sumaSeguridadIndG = 0;
                    $sumaManejoAmbientalG = 0;
                    $sumaOficinaG = 0;
                    $sumaBienestartG = 0;

                      $recepcionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 1 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCria);
                            $manejoReproductivoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 2 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproductivoC);
                            $manejoCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 3 AND id_info_granja = ' $idInfoGranja'");
                            array_push($array, $manejoCria);
                            $reproductoresCalentadores = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 4 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $reproductoresCalentadores);
                            $estimulacionDetecCalor = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 5 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $estimulacionDetecCalor);
                            $inseminacion = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 6 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $inseminacion);

                            $manejoReproHCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 7 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoReproHCria);
                             $manejoHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 8 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoHembrasC);
                            $manejoRegistrosC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 9 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoRegistrosC);
                            $alimentacionHembrasC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 10 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionHembrasC);
                            $antesDelPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 11 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $antesDelPartoC);
                            $hembraPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 12 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $hembraPartoC);
                            $lechoPartoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 13 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $lechoPartoC);
                            $alimentacionCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 14 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $alimentacionCria);
                             $manejoCerdaLactanciaC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 15 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoCerdaLactanciaC);
                             $manejoDeLechonesC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 16 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $manejoDeLechonesC);
                             $practicasAseoManejoC = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 17 AND id_info_granja = '$idInfoGranja'");
                             array_push($array, $practicasAseoManejoC);
                            $registrosCria = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 18 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $registrosCria);


                                $aguaPrecebo = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 19 AND id_info_granja = '$idInfoGranja'");
                        array_push($array, $aguaPrecebo);

                        $alimentacionPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 20 AND id_info_granja = '$idInfoGranja'");
                        array_push($array, $alimentacionPrecebo);

                        $manejoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 21 AND id_info_granja = '$idInfoGranja'");
                        array_push($array, $manejoPrecebo);

                        $alojamientoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 22 AND id_info_granja = '$idInfoGranja'");
                        array_push($array, $alojamientoPrecebo);

                        $registrosPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 23 AND id_info_granja = '$idInfoGranja'");
                        array_push($array, $registrosPrecebo);

                        $recepcionCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 24 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCeba);
                            $manejoCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 25 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoCeba);
                            $registrosCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 26 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $registrosCeba);
                                $bodegaG = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 27 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bodegaG);
                                $bioseguridad = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 28 AND id_info_granja = $idInfoGranja");
                                array_push($array, $bioseguridad);
                                $seguridadIndustrial = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 29 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $seguridadIndustrial);
                                $manejoAmbiental = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 30 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoAmbiental);
                                $oficinaGeneral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 31 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $oficinaGeneral);
                                $bienestarLaboral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 32 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bienestarLaboral);


                    for ($i=0; $i <count($array); $i++) {
                        $calificacion = new CalificacionGranja();
                            foreach ($array[$i] as $item) {
                                if  ($item->id_porcentaje_subproceso == 1) {
                                    $sumaSubprocesoRecepcion += $item->indicador;
                                    $calificacion->subproceso = 'Recepcion Cria';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoRecepcion;
                                    $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                    $calificacion->id_info_granja = $idInfoGranja;
                                    $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 2) {
                                     $sumaSubprocesoManejoRC += $item->indicador;
                                     $calificacion->subproceso = 'Manejo reproductivo';
                                     $calificacion->suma_indicador_subproceso = $sumaSubprocesoManejoRC;
                                      $calificacion->calificacion_subproceso = number_format((0.5 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                      $calificacion->id_info_granja = $idInfoGranja;
                                      $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 3) {
                                    $sumaSubprocesoMC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo';
                                    $calificacion->suma_indicador_subproceso = $sumaSubprocesoMC;
                                     $calificacion->calificacion_subproceso = number_format((0.4 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 1;
                                } else if ($item->id_porcentaje_subproceso == 4) {
                                    $sumaReproductoresCalen += $item->indicador;
                                    $calificacion->subproceso = 'Reproductores calentadores';
                                    $calificacion->suma_indicador_subproceso = $sumaReproductoresCalen;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 2;
                                } else if ($item->id_porcentaje_subproceso == 5) {
                                    $sumaEstimulacionDetecCa += $item->indicador;
                                    $calificacion->subproceso = 'Estimulación y detección de calores_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaEstimulacionDetecCa;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 6) {
                                    $sumaInsemincacion += $item->indicador;
                                    $calificacion->subproceso = 'Inseminación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaInsemincacion;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 7) {
                                    $sumaMReproHemC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo Reproductivo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaMReproHemC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                } else if ($item->id_porcentaje_subproceso == 8) {
                                    $sumaManejoHC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoHC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                else if ($item->id_porcentaje_subproceso == 9) {
                                    $sumaManejoRegisC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoRegisC;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }   else if ($item->id_porcentaje_subproceso == 10) {
                                    $sumaAlimentacionHC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación de hembras _CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionHC;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 3;
                                }
                                 else if ($item->id_porcentaje_subproceso == 11) {
                                    $sumaAntesParto += $item->indicador;
                                    $calificacion->subproceso = 'Antes del Parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAntesParto;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                }  else if ($item->id_porcentaje_subproceso == 12) {
                                    $sumaHembraParto += $item->indicador;
                                    $calificacion->subproceso = 'Hembra en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaHembraParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 13) {
                                    $sumaLechonParto += $item->indicador;
                                    $calificacion->subproceso = 'Lechon en el parto_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaLechonParto;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 14) {
                                    $sumaAlimentacionC += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionC;
                                     $calificacion->calificacion_subproceso = number_format((0.25 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 15) {
                                    $sumaManejoCerdadL += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de la cerda en lactancia_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCerdadL;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 16) {
                                    $sumaManejoLechonesC += $item->indicador;
                                    $calificacion->subproceso = 'Manejo de los lechones_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoLechonesC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 17) {
                                    $sumaPracticasAseo += $item->indicador;
                                    $calificacion->subproceso = 'Practicas de aseo y manejo_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaPracticasAseo;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 18) {
                                    $sumaRegistrosC += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CRÍA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosC;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 4;
                                } else if ($item->id_porcentaje_subproceso == 19) {
                                    $sumaAguaPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Agua_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAguaPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.2 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 20) {
                                    $sumaAlimentacionPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 21) {
                                    $sumaManejoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 22) {
                                    $sumaAlojamientoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alojamiento_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlojamientoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }  else if ($item->id_porcentaje_subproceso == 23) {
                                    $sumaRegistrosPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Registros_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }
                                   else  if  ($item->id_porcentaje_subproceso == 24) {
                                    $sumaRecepcionCeba += $item->indicador;
                                    $calificacion->subproceso = 'Recepción_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRecepcionCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 25) {
                                    $sumaManejoCeba += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.6 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 26) {
                                    $sumaRegistrosCeba += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    }
                                else if ($item->id_porcentaje_subproceso == 27) {
                                    $sumaBodegaG += $item->indicador;
                                    $calificacion->subproceso = 'BODEGA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBodegaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 7;
                                } else if ($item->id_porcentaje_subproceso == 28) {
                                    $sumaBioseguridadG += $item->indicador;
                                    $calificacion->subproceso = 'BIOSEGURIDAD_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBioseguridadG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 8;
                                } else if ($item->id_porcentaje_subproceso == 29) {
                                    $sumaSeguridadIndG += $item->indicador;
                                    $calificacion->subproceso = 'SEGURIDAD INDUSTRIAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaSeguridadIndG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 9;
                                }  else if ($item->id_porcentaje_subproceso == 30) {
                                    $sumaManejoAmbientalG += $item->indicador;
                                    $calificacion->subproceso = 'MANEJO AMBIENTAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoAmbientalG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 10;
                                }  else if ($item->id_porcentaje_subproceso == 31) {
                                    $sumaOficinaG += $item->indicador;
                                    $calificacion->subproceso = 'OFICINA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaOficinaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 11;
                                } else if ($item->id_porcentaje_subproceso == 32) {
                                    $sumaBienestartG+= $item->indicador;
                                    $calificacion->subproceso = 'BIENESTAR LABORAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBienestartG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 12;
                                }
                                $calificacion->save();
                            }
                        }
                        //$this->sendCorreo($idGranja, $fecha);
                        return response()->json(["msg" => "Procesado correctamente"], 200);

            //Anterior condicional: !in_array("1", $ciclosGranja) && in_array("2", $ciclosGranja) && in_array("3", $ciclosGranja)
        } else if ($ciclosGranja == '2,3') {

            //Cilo granja precebo-ceba
            $idInfoGranja = $infoGranja[0]->id;
            $sumaAguaPrecebo = 0;
            $sumaAlimentacionPrecebo = 0;
            $sumaManejoPrecebo = 0;
            $sumaAlojamientoPrecebo = 0;
            $sumaRegistrosPrecebo = 0;
            $sumaRecepcionCeba = 0;
             $sumaManejoCeba = 0;
            $sumaRegistrosCeba = 0;
            $sumaBodegaG = 0;
             $sumaBioseguridadG = 0;
             $sumaSeguridadIndG = 0;
            $sumaManejoAmbientalG = 0;
             $sumaOficinaG = 0;
             $sumaBienestartG = 0;


             $aguaPrecebo = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 19 AND id_info_granja = '$idInfoGranja'");
             array_push($array, $aguaPrecebo);

             $alimentacionPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 20 AND id_info_granja = '$idInfoGranja'");
             array_push($array, $alimentacionPrecebo);

             $manejoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 21 AND id_info_granja = '$idInfoGranja'");
             array_push($array, $manejoPrecebo);

             $alojamientoPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 22 AND id_info_granja = '$idInfoGranja'");
             array_push($array, $alojamientoPrecebo);

             $registrosPrecebo =  DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 23 AND id_info_granja = '$idInfoGranja'");
             array_push($array, $registrosPrecebo);

              $recepcionCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 24 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCeba);
                            $manejoCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 25 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoCeba);
                            $registrosCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 26 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $registrosCeba);
                            $bodegaG = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 27 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bodegaG);
                                $bioseguridad = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 28 AND id_info_granja = $idInfoGranja");
                                array_push($array, $bioseguridad);
                                $seguridadIndustrial = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 29 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $seguridadIndustrial);
                                $manejoAmbiental = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 30 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoAmbiental);
                                $oficinaGeneral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 31 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $oficinaGeneral);
                                $bienestarLaboral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 32 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bienestarLaboral);

                                for ($i=0; $i <count($array) ; $i++) {
                                        foreach ($array[$i] as $item) {
                                    $calificacion = new CalificacionGranja();

                                   if ($item->id_porcentaje_subproceso == 19) {
                                    $sumaAguaPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Agua_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAguaPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.2 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 20) {
                                    $sumaAlimentacionPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alimentación_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlimentacionPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 21) {
                                    $sumaManejoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.15 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   } else if ($item->id_porcentaje_subproceso == 22) {
                                    $sumaAlojamientoPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Alojamiento_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaAlojamientoPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }  else if ($item->id_porcentaje_subproceso == 23) {
                                    $sumaRegistrosPrecebo += $item->indicador;
                                    $calificacion->subproceso = 'Registros_PRECEBO';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosPrecebo;
                                     $calificacion->calificacion_subproceso = number_format((0.05 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 5;
                                   }
                                   else  if  ($item->id_porcentaje_subproceso == 24) {
                                    $sumaRecepcionCeba += $item->indicador;
                                    $calificacion->subproceso = 'Recepción_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRecepcionCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 25) {
                                    $sumaManejoCeba += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.6 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 26) {
                                    $sumaRegistrosCeba += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    }
                                    else if ($item->id_porcentaje_subproceso == 27) {
                                    $sumaBodegaG += $item->indicador;
                                    $calificacion->subproceso = 'BODEGA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBodegaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 7;
                                } else if ($item->id_porcentaje_subproceso == 28) {
                                    $sumaBioseguridadG += $item->indicador;
                                    $calificacion->subproceso = 'BIOSEGURIDAD_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBioseguridadG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 8;
                                } else if ($item->id_porcentaje_subproceso == 29) {
                                    $sumaSeguridadIndG += $item->indicador;
                                    $calificacion->subproceso = 'SEGURIDAD INDUSTRIAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaSeguridadIndG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 9;
                                }  else if ($item->id_porcentaje_subproceso == 30) {
                                    $sumaManejoAmbientalG += $item->indicador;
                                    $calificacion->subproceso = 'MANEJO AMBIENTAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoAmbientalG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 10;
                                }  else if ($item->id_porcentaje_subproceso == 31) {
                                    $sumaOficinaG += $item->indicador;
                                    $calificacion->subproceso = 'OFICINA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaOficinaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 11;
                                } else if ($item->id_porcentaje_subproceso == 32) {
                                    $sumaBienestartG+= $item->indicador;
                                    $calificacion->subproceso = 'BIENESTAR LABORAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBienestartG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 12;
                                  }
                               }
                                        $calificacion->save();
                                }
                                //$this->sendCorreo($idGranja, $fecha);
                                return response()->json(["msg" => "Procesado correctamente"], 200);

            //Anterior condicional: !in_array("1", $ciclosGranja) && !in_array("2", $ciclosGranja) && in_array("3", $ciclosGranja)
        } else if  ($ciclosGranja == '3') {

            //El proceso de la granja es solo ceba
                //return response()->json($infoGranja[0]->id, 200);
                    $idInfoGranja = $infoGranja[0]->id;
                    $sumaRecepcionCeba = 0;
                    $sumaManejoCeba = 0;
                    $sumaRegistrosCeba = 0;
                    $sumaBodegaG = 0;
                    $sumaBioseguridadG = 0;
                    $sumaSeguridadIndG = 0;
                    $sumaManejoAmbientalG = 0;
                    $sumaOficinaG = 0;
                    $sumaBienestartG = 0;

                         $recepcionCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 24 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $recepcionCeba);
                            $manejoCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 25 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $manejoCeba);
                            $registrosCeba = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 26 AND id_info_granja = '$idInfoGranja'");
                            array_push($array, $registrosCeba);
                            $bodegaG = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 27 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bodegaG);
                                $bioseguridad = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 28 AND id_info_granja = $idInfoGranja");
                                array_push($array, $bioseguridad);
                                $seguridadIndustrial = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 29 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $seguridadIndustrial);
                                $manejoAmbiental = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 30 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $manejoAmbiental);
                                $oficinaGeneral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 31 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $oficinaGeneral);
                                $bienestarLaboral = DB::select("SELECT * FROM valores_auditorias WHERE id_porcentaje_subproceso = 32 AND id_info_granja = '$idInfoGranja'");
                                array_push($array, $bienestarLaboral);
                                for ($i=0; $i <count($array) ; $i++) {
                                        foreach ($array[$i] as $item) {
                                    $calificacion = new CalificacionGranja();
                                    if  ($item->id_porcentaje_subproceso == 24) {
                                    $sumaRecepcionCeba += $item->indicador;
                                    $calificacion->subproceso = 'Recepción_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRecepcionCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.3 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 25) {
                                    $sumaManejoCeba += $item->indicador;
                                    $calificacion->subproceso = 'Manejo_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.6 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    } else  if  ($item->id_porcentaje_subproceso == 26) {
                                    $sumaRegistrosCeba += $item->indicador;
                                    $calificacion->subproceso = 'Registros_CEBA';
                                    $calificacion->suma_indicador_subproceso = $sumaRegistrosCeba;
                                     $calificacion->calificacion_subproceso = number_format((0.1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 6;
                                    }
                                    else if ($item->id_porcentaje_subproceso == 27) {
                                    $sumaBodegaG += $item->indicador;
                                    $calificacion->subproceso = 'BODEGA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBodegaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 7;
                                } else if ($item->id_porcentaje_subproceso == 28) {
                                    $sumaBioseguridadG += $item->indicador;
                                    $calificacion->subproceso = 'BIOSEGURIDAD_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBioseguridadG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 8;
                                } else if ($item->id_porcentaje_subproceso == 29) {
                                    $sumaSeguridadIndG += $item->indicador;
                                    $calificacion->subproceso = 'SEGURIDAD INDUSTRIAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaSeguridadIndG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 9;
                                }  else if ($item->id_porcentaje_subproceso == 30) {
                                    $sumaManejoAmbientalG += $item->indicador;
                                    $calificacion->subproceso = 'MANEJO AMBIENTAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaManejoAmbientalG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 10;
                                }  else if ($item->id_porcentaje_subproceso == 31) {
                                    $sumaOficinaG += $item->indicador;
                                    $calificacion->subproceso = 'OFICINA_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaOficinaG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 11;
                                } else if ($item->id_porcentaje_subproceso == 32) {
                                    $sumaBienestartG+= $item->indicador;
                                    $calificacion->subproceso = 'BIENESTAR LABORAL_GENERAL 2';
                                    $calificacion->suma_indicador_subproceso = $sumaBienestartG;
                                     $calificacion->calificacion_subproceso = number_format((1 * $calificacion->suma_indicador_subproceso), 2, '.', ',');
                                     $calificacion->id_info_granja = $idInfoGranja;
                                     $calificacion->id_proceso_macro = 12;
                                  }
                               }
                                        $calificacion->save();
                                }

                                //$this->sendCorreo($idGranja, $fecha);
                                return response()->json(["msg" => "Procesado correctamente"], 200);
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
