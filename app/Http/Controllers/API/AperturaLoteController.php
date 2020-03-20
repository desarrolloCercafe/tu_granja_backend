<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\AperturaLote;

class AperturaLoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lotes = DB::table('lote_cerdos')
                    ->join('granjas', 'lote_cerdos.id_granja', '=', 'granjas.id')
                    ->select('granjas.nombre_granja', 'lote_cerdos.*')
                    ->get();
        
        return response()->json($lotes, 200);
        /*$lotes = AperturaLote::all();
        return response()->json($lotes, 200);*/
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
        $lote =  new AperturaLote();
        $lote->id_lote =  $request->id_lote;
        $lote->f_inicial = $request->f_inicial;
        $lote->id_granja = $request->id_granja;
        $lote->num_animales = $request->num_animales;
        $lote->consec_lote =  $request->consec_lote;
        $lote->peso_ini = $request->peso_ini;
        $lote->tipo_lote = $request->tipo_lote;
        $lote->lote_precebo = $request->lote_precebo;
        $lote->tipo_lactancia = $request->tipo_lactancia;
        $lote->save();

        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AperturaLote  $aperturaLote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = [];
        $muertes = DB::select('SELECT SUM(cantidad) as muertos FROM eventos_lote WHERE id_lote = ? AND tipo_evento = ?', [$id, 'MORTALIDAD']);
        $peso_total_final = DB::select('SELECT SUM(peso) as cantidad FROM eventos_lote WHERE id_lote = ? AND tipo_evento IN (?,?)', [$id, 'MORTALIDAD', 'VENTA']);
        $dias_permamencia = DB::select(
            'SELECT 
                (SUM(DATEDIFF(ev.fecha, lc.f_inicial) * ev.cantidad)) / lc.num_animales
                as DiasPermanencia 
            FROM lote_cerdos lc 
            INNER JOIN eventos_lote ev ON ev.id_lote = lc.id_lote 
            WHERE lc.id_lote = ? AND ev.tipo_evento NOT IN (?, ?)', [$id, 'CONSUMO', 'MEDICAMENTO']);

        $peso_total_inicial = DB::select('SELECT peso_ini FROM lote_cerdos WHERE id_lote = ?', [$id]);

        $ganancia_peso_total = DB::select(
            'SELECT 
                (SUM(ev.peso) - lc.peso_ini)
                as GananciaTotal 
            FROM lote_cerdos lc 
            INNER JOIN eventos_lote ev ON ev.id_lote = lc.id_lote 
            WHERE lc.id_lote = ? AND ev.tipo_evento NOT IN (?, ?)', [$id, 'CONSUMO', 'MEDICAMENTO']);

        $num_animales = DB::select('SELECT num_animales FROM lote_cerdos WHERE id_lote = ?', [$id]);

        $ganancia_total_animal = $ganancia_peso_total[0]->GananciaTotal / $num_animales[0]->num_animales;
        $total_animal_dia = $ganancia_total_animal / $dias_permamencia[0]->DiasPermanencia;

        $kg = DB::select(
            'SELECT IF(SUM(cantidad) is NULL, 0, SUM(cantidad)) as cantidadKg 
                FROM eventos_lote 
                WHERE tipo_evento = "CONSUMO" 
                    AND unidad_medida = "kg" 
                    AND id_lote = ?', [$id]);

        $bultosInKg = DB::select(
            'SELECT IF(SUM(cantidad*40) is NULL, 0, SUM(cantidad*40)) as cantidadKg 
                FROM eventos_lote 
                WHERE tipo_evento = "CONSUMO" 
                    AND unidad_medida = "bul" 
                    AND id_lote = ?', [$id]);

        $cantidadKg = $bultosInKg[0]->cantidadKg + $kg[0]->cantidadKg;

        $consumo_animal = $cantidadKg / $num_animales[0]->num_animales;
        $consumo_animal_dia = $consumo_animal / $dias_permamencia[0]->DiasPermanencia;

        $conversion = $cantidadKg / $ganancia_peso_total[0]->GananciaTotal;

        $data['muertes'] = $muertes[0]->muertos;
        $data['peso_total_final'] = $peso_total_final[0]->cantidad;
        $data['peso_ini'] = $peso_total_inicial[0]->peso_ini;
        $data['dias_permanencia'] = $dias_permamencia[0]->DiasPermanencia;
        $data['ganancia_peso_total'] = $ganancia_peso_total[0]->GananciaTotal;
        $data['num_animales'] = $num_animales[0]->num_animales;
        $data['ganancia_total_animal'] = $ganancia_total_animal;
        $data['total_animal_dia'] = $total_animal_dia;
        $data['consumo_total'] = $cantidadKg;
        $data['consumo_animal'] = $consumo_animal;
        $data['consumo_animal_dia'] = $consumo_animal_dia;
        $data['conversion'] = $conversion;

        
        return response()->json($data, 200);
        //return response()->json($id, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AperturaLote  $aperturaLote
     * @return \Illuminate\Http\Response
     */
    public function edit(AperturaLote $aperturaLote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AperturaLote  $aperturaLote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AperturaLote $aperturaLote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AperturaLote  $aperturaLote
     * @return \Illuminate\Http\Response
     */
    public function destroy(AperturaLote $aperturaLote)
    {
        //
    }
}
