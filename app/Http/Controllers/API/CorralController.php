<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Corral;
use DB;

class CorralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corrales = Corral::select('corral.id', 'corral.cod_corral', 'granjas.nombre_granja')
                            ->join('granjas', 'corral.id_granja', '=', 'granjas.id')
                            ->get();

        return response()->json($corrales, 200);
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
        //return response()->json($request);
        $corral = new Corral();
        $corral->cod_corral = $request["nombre_corral"];
        $corral->id_granja = $request["granja"];
        $corral->tipo_comedero = $request["tipo_comedero"];
        $corral->area_corral = $request["area_corral"];
        $corral->save();
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Corral  $corral
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* $corrales = Corral::where('id_granja', $id)->get();

        foreach ($corrales as $corral) {
            $cantidadH = DB::select('SELECT IF(COUNT(id) > 0, COUNT(id), 1) as cantidad FROM corral_hembra WHERE id_corral = ?',
            [$corral->id]);
            $corral->cantidadHembras = $cantidadH[0]->cantidad;
        } */

        /* $corrales = DB::select(
            'SELECT corral.*, id_corral FROM corral
            INNER JOIN corral_hembra
            ON corral.id = corral_hembra.id_corral
            INNER JOIN lote
            ON lote.id = corral_hembra.id_lote
            WHERE lote.id = ?
            GROUP BY corral.cod_corral', [$id]); */

            $corrales = DB::select(
                'SELECT * FROM corral_hembra
                INNER JOIN corral
                ON corral.id = corral_hembra.id_corral
                WHERE corral_hembra.id_lote = ?
                GROUP BY corral.cod_corral
                ', [$id]);
        
            return response()->json($corrales, 200);
    }

    public function ShowCorralesByUser($id){
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        $type = 0;

        if($user[0]->rol_id == 6 || $user[0]->rol_id == 10 || $user[0]->rol_id == 7){
            $type = 1;
            $granjas = DB::select(
                'SELECT g.* FROM granjas g 
                    INNER JOIN granjas_asociadas ga ON ga.granja_id = g.id 
                    INNER JOIN users u ON u.id = ga.user_id 
                    WHERE u.id = ?', [$id]);

            $corrales = [];

                foreach ($granjas as $granja) {

                    $corral = Corral::select('corral.*', 'granjas.nombre_granja')
                    ->join('granjas', 'corral.id_granja', '=', 'granjas.id')
                    ->where('corral.id_granja', '=', $granja->id)
                    ->get();

                    if(Count($corral)){
                        for ($i=0; $i < Count($corral) ; $i++) { 
                            array_push($corrales, $corral[$i]);
                        }
                    }
                }
        }else{
            $corrales = Corral::select('corral.*', 'granjas.nombre_granja')
            ->join('granjas', 'corral.id_granja', '=', 'granjas.id')
            ->get();
        }

        /*if($type != 0){
            return response()->json($corrales, 200);
            //return response($corrales, 200);
        }else{
            return response()->json($corrales, 200);
        }*/
        return response()->json($corrales, 200);

        //return response($corrales, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Corral  $corral
     * @return \Illuminate\Http\Response
     */
    public function edit(Corral $corral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Corral  $corral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corral $corral)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Corral  $corral
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $corral = Corral::find($id);
        $corral->delete();
        return response()->json("OK", 200);
    }
}
