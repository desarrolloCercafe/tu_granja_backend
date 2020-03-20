<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Corral;
use App\HembraCorral;
use App\Hembras;
use App\Lote;
use DB;

class HembraCorralController extends Controller
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
    {}


    public function showHembras(Request $request){
        $hembras = DB::select(
            'SELECT rc.cod_cerda, ch.id_hembra as id, ch.sobrenombre, rc.f_servicio 
            FROM corral_hembra ch 
            INNER JOIN registro_cerda rc ON rc.id = ch.id_hembra 
            WHERE ch.id_corral = ? AND ch.id_lote = ? AND rc.estado = 0', 
            [$request['corral'], $request['lote']]
        );

        return response()->json($hembras, 200);
    }

    /* public function showHembras(Request $request){
        $hembras = DB::select(
            'SELECT rc.cod_cerda, ch.id_hembra as id, ch.sobrenombre, rc.f_servicio, max(cc.num_celo) as num_celo
            FROM corral_hembra ch
            JOIN celos_cerda cc
            INNER JOIN registro_cerda rc ON rc.id = ch.id_hembra
            WHERE ch.id_corral = ? AND ch.id_lote = ? AND rc.estado = 0
            AND ch.id_hembra = cc.id_cerda',
            [$request['corral'], $request['lote']]
        );
        return response()->json($hembras, 200); */

    public function update_corral_hembras(Request $request){
        
        foreach ($request["cerdas"] as $cerda) {
            
            //return response()->json($cerda, 200);

            $infoCerda = DB::select('SELECT * FROM corral_hembra WHERE id_hembra = ?', [$cerda["id"]]);

            //return response()->json($infoCerda, 200);

            DB::update(
                'UPDATE corral_hembra SET id_corral = ? WHERE id_hembra = ?', [
                    $request["corral"], $cerda["id"]
            ]);

            DB::insert(
                'INSERT INTO 
                    historico_cambio_corrales 
                    (id_hembra, fecha, corral_antiguo, corral_nuevo, observaciones) 
                    VALUES (?, ?, ?, ?, ?)', [
                        $cerda["id"], $request["fecha"], 
                        $infoCerda[0]->id_corral, $request["corral"],
                        $request['observacion']
            ]);

        }

        return response()->json("OK", 200);

        //return response()->json($request, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HembraCorral  $hembraCorral
     * @return \Illuminate\Http\Response
     */
    public function show(HembraCorral $hembraCorral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HembraCorral  $hembraCorral
     * @return \Illuminate\Http\Response
     */
    public function edit(HembraCorral $hembraCorral)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HembraCorral  $hembraCorral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HembraCorral  $hembraCorral
     * @return \Illuminate\Http\Response
     */
    public function destroy(HembraCorral $hembraCorral)
    {
        //
    }
}
