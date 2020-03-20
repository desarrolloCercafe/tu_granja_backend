<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\EventosLote;
use App\AperturaLote;
use Illuminate\Support\Carbon; 

class EventosLoteController extends Controller
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

        //$idLote = $request->data["id_lote"];
        $lote =  AperturaLote::where('id_lote', $request->data["id_lote"])->get();
        //return response()->json($lote[0]->f_inicial, 200);
        $fEnvio = new Carbon($lote[0]->f_inicial);
        $fEnvio->addDays(($request->data['semana'] * 7) + $request->data['dia']);
        //return response()->json($fEnvio, 200);
        /*$sumaSemanas = strtotime('+'.$request->data['semana'].' week', strtotime($lote[0]->f_inicial));
        $sumaDias = strtotime('+'.$request->data['dia'].' day', strtotime($sumaSemanas));*/
        /*$sumoSemanas = strtotime($lote[0]->f_inicial."+ ".$request->data['semana']." week");
        $fechaEvento = strtotime($sumoSemanas."+ ".$request->data['dia']." days");*/

        //return response()->json( date($sumaDias), 200);

        $lote = new EventosLote();
        $lote->id_lote = $request->data["id_lote"];
        $lote->semana = $request->data['semana'];
        $lote->dia = $request->data['dia'];
        $lote->fecha = $fEnvio;
        if($request->tipo != 'MORTALIDAD'){
            $lote->cantidad = $request->data["cantidad"];
        }

        $lote->observaciones = $request->data['observacion'];

        switch ($request->tipo) {
            case 'VENTAS':
                $lote->tipo_evento = 'VENTA';
                $lote->peso = $request->data["peso"];
                $lote->frigo = $request->data['frigo'];
                //DB::update('UPDATE lote_cerdos  SET num_animales = (num_animales - ?) WHERE id_lote = ?', [$request->data["cantidad"], $request->data["id_lote"]]);
                break;
            case 'CONSUMOS':
                $lote->tipo_evento = 'CONSUMO';
                $lote->dieta = $request->data["dieta"];
                $lote->unidad_medida = $request->data['unidadMedida'];
                $lote->op = $request->data["op"];

                $color = DB::select(
                    'SELECT color FROM concentrados WHERE nombre_concentrado = ?', [$request->data["dieta"]]
                );

                $lote->color =  $color[0]->color;

                break;
            case 'MORTALIDAD':
                $lote->tipo_evento = 'MORTALIDAD';
                $lote->cantidad = 1;
                $lote->peso = $request->data["peso"];
                $lote->causa = $request->data["causa"];

                //DB::update('UPDATE lote_cerdos  SET num_animales = (num_animales - ?) WHERE id_lote = ?', [1, $request->data["id_lote"]]);

                break;
            case 'MEDICAMENTOS':
                $lote->tipo_evento = 'MEDICAMENTO';
                $lote->dosis = $request->data["dosis"];
                $lote->tipo_dosis = $request->data['tipoDosis'];
                $lote->medicamento = $request->data["medicamento"];
            break;
            default:
                break;
        }

        $lote->save();

        return response()->json($request, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EventosLote  $eventosLote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $eventos = [];

        $sql = DB::select('SELECT * FROM eventos_lote WHERE id_lote = ?', [$id]);
        
        foreach ($sql as $result) {
            
            if(!isset($eventos['semana'.$result->semana])){
                $eventos['semana'.$result->semana] = [];
            }

            if(!isset($eventos['semana'.$result->semana]['dia'.$result->dia])){
                $eventos['semana'.$result->semana]['dia'.$result->dia] = [];
                $eventos['semana'.$result->semana]['dia'.$result->dia]['medicamento'] = 0;
                $eventos['semana'.$result->semana]['dia'.$result->dia]['mortalidad'] = 0;
                $eventos['semana'.$result->semana]['dia'.$result->dia]['consumo'] = 0;
                $eventos['semana'.$result->semana]['dia'.$result->dia]['venta'] = 0;
            }

            switch ($result->tipo_evento) {
                case 'MEDICAMENTO':
                    $eventos['semana'.$result->semana]['dia'.$result->dia]['medicamento'] += 1;
                    break;
                case 'MORTALIDAD':
                    $eventos['semana'.$result->semana]['dia'.$result->dia]['mortalidad'] += 1;
                    break;
                case 'CONSUMO':
                    $eventos['semana'.$result->semana]['dia'.$result->dia]['consumo'] += 1;
                    break;
                case 'VENTA':
                    $eventos['semana'.$result->semana]['dia'.$result->dia]['venta'] += 1;
                    break;
                default:
                    # code...
                    break;
            }
        }

        return response()->json($eventos, 200);
    }

    public function showEventsByDay(Request $request){
        $eventos = EventosLote::where([
            ['id_lote', $request->id],
            ['semana', $request->semana],
            ['dia', $request->dia]
        ])->get();
        return response()->json($eventos, 200);
    }


    public function paintedCells(Request $request){

        $detalleEventos = $request;
        $colores = [];

        //return response()->json($request, 200);

        foreach ($request->all() as $detalle) {
            $response = DB::select(
                'SELECT color FROM eventos_lote 
                    WHERE id_lote = ? AND semana = ? 
                    AND dia = ? AND tipo_evento = "CONSUMO"', 
                    [$detalle['lote'], $detalle['semana'], $detalle['dia']]
            );
            array_push($colores, [ "color" => $response[0]->color, "y" => $detalle['dia'], "x" => $detalle['semana']]);
        }

        return response()->json($colores, 200);
    }

    public function showStatsLote($id){
        $stats = [];
        for ($i=0; $i < 20; $i++) {
            
            /*$info = DB::select('SELECT * FROM eventos_lote WHERE id_lote = ? AND semana = ?', [$id, $i]);
            $contador = Count($info);

            if($contador){*/
                $eventos = [];
                
                $kg = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as cantidadKg 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "kg" 
                            AND id_lote = ? 
                            AND semana = ?', [$id, $i]);

                $bultos = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as cantidadBultos 
                FROM eventos_lote 
                WHERE tipo_evento = "CONSUMO" 
                    AND unidad_medida = "bul" 
                    AND id_lote = ? 
                    AND semana = ?', [$id, $i]);

                $kgInBultos = DB::select(
                    'SELECT IF(SUM(cantidad/40) is NULL, 0, SUM(cantidad/40)) as cantidadBultos 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "kg" 
                            AND id_lote = ? 
                            AND semana = ?', [$id, $i]);

                $bultosInKg = DB::select(
                    'SELECT IF(SUM(cantidad*40) is NULL, 0, SUM(cantidad*40)) as cantidadKg 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "bul" 
                            AND id_lote = ? 
                            AND semana = ?', [$id, $i]);


                $cantidadBultos = $kgInBultos[0]->cantidadBultos + $bultos[0]->cantidadBultos;
                $cantidadKg = $bultosInKg[0]->cantidadKg + $kg[0]->cantidadKg;


                $kgAcum = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as cantidadKg 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "kg" 
                            AND id_lote = ? 
                            AND semana <= ?', [$id, $i]);

                $bultosAcum = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as cantidadBultos 
                FROM eventos_lote 
                WHERE tipo_evento = "CONSUMO" 
                    AND unidad_medida = "bul" 
                    AND id_lote = ? 
                    AND semana <= ?', [$id, $i]);

                $kgInBultosAcum = DB::select(
                    'SELECT IF(SUM(cantidad/40) is NULL, 0, SUM(cantidad/40)) as cantidadBultos 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "kg" 
                            AND id_lote = ? 
                            AND semana <= ?', [$id, $i]);

                $bultosInKgAcum = DB::select(
                    'SELECT IF(SUM(cantidad*40) is NULL, 0, SUM(cantidad*40)) as cantidadKg 
                        FROM eventos_lote 
                        WHERE tipo_evento = "CONSUMO" 
                            AND unidad_medida = "bul" 
                            AND id_lote = ? 
                            AND semana <= ?', [$id, $i]);

                $cantidadBultosAcum = $kgInBultosAcum[0]->cantidadBultos + $bultosAcum[0]->cantidadBultos;
                $cantidadKgAcum = $bultosInKgAcum[0]->cantidadKg + $kgAcum[0]->cantidadKg;

                $numMuertos = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as numMuertos 
                        FROM `eventos_lote` 
                        WHERE tipo_evento = "MORTALIDAD" AND id_lote = ? AND semana = ?', [$id, $i]);
    
                $numMuertosAcum = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as numMuertosAcum 
                        FROM `eventos_lote` 
                        WHERE tipo_evento = "MORTALIDAD" AND id_lote = ? AND semana <= ?', [$id, $i]);
        
                $ventaCerdosAcum = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as ventaCerdosAcum 
                        FROM `eventos_lote` 
                        WHERE tipo_evento = "VENTA" AND id_lote = ? AND semana <= ?', [$id, $i]);
    
                $ventaCerdos = DB::select(
                    'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as ventaCerdos 
                        FROM `eventos_lote` 
                        WHERE tipo_evento = "VENTA" AND id_lote = ? AND semana = ?', [$id, $i]);

                $saldoC = DB::select(
                    'SELECT (num_animales - (? + ?)) as num_anim
                        FROM lote_cerdos 
                        WHERE id_lote = ?', [$numMuertosAcum[0]->numMuertosAcum, $ventaCerdosAcum[0]->ventaCerdosAcum, $id]);

                $porcentajeMuertes = $numMuertos[0]->numMuertos / $saldoC[0]->num_anim;

                $eventos['cantBultos'] = $cantidadBultos;
                $eventos['cantKg'] = $cantidadKg;
                $eventos['cantBultosAcum'] = $cantidadBultosAcum;
                $eventos['cantKgAcum'] = $cantidadKgAcum;
                $eventos['numMuertos'] = $numMuertos[0]->numMuertos;
                $eventos['numMuertosAcum'] = $numMuertosAcum[0]->numMuertosAcum;
                $eventos['ventaCerdos'] = $ventaCerdos[0]->ventaCerdos;
                $eventos['saldo'] = $saldoC[0]->num_anim;
                $eventos['porcentajeMuertes'] = $porcentajeMuertes;

                array_push($stats, $eventos);
            //}
        }

        return response()->json($stats, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EventosLote  $eventosLote
     * @return \Illuminate\Http\Response
     */
    public function edit(EventosLote $eventosLote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EventosLote  $eventosLote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventosLote $eventosLote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EventosLote  $eventosLote
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventosLote $eventosLote)
    {
        //
    }
}
