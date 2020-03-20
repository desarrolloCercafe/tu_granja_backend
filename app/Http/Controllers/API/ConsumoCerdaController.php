<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Corral;
use App\HembraCorral;

class ConsumoCerdaController extends Controller
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
        $cerda_corral = DB::table('corral_hembra')
                        ->select('corral_hembra.id_hembra')
                        ->join('registro_cerda', 'registro_cerda.id', '=', 'corral_hembra.id_hembra')
                        ->where([
                            ['registro_cerda.estado', 0],
                            ['corral_hembra.id_corral', $request["corral"]]
                        ])->get();
        //$cerda_corral = HembraCorral::where('id_corral', $request["corral"])->get();
        $cantidad_Cerdas = $cerda_corral->count();
        //return response()->json($cantidad_Cerdas, 200);
        for ($i=0; $i < $cantidad_Cerdas; $i++) { 

            $consumo = ($request["consumo"]["consumo"])/$cantidad_Cerdas;

            DB::insert(
                'INSERT INTO consumo_cerda (id_dieta, id_hembra, fInicial, fFinal, op, consumo) 
                    VALUES (?, ?, ?, ?, ?, ?)', 
                    [
                        $request["consumo"]["dieta"], $cerda_corral[$i]->id_hembra, 
                        $request["consumo"]["fInicial"], $request["consumo"]["fFinal"],
                        $request["consumo"]["Op"], $consumo
                    ]
            );
        }

        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConsumoCerda  $consumoCerda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $consumosRegistrados = DB::select(
            'SELECT 
                cc.id, (SELECT fecha FROM calendario WHERE id = cc.f_inicio) as f_inicio, 
                (SELECT fecha FROM calendario WHERE id = cc.f_final) as f_final, 
                c.nombre_concentrado 
            FROM consumo_cerda cc 
            INNER JOIN concentrados c ON cc.id_dieta = c.id 
            WHERE cc.id_peso = ?',
            [$id]
        );

        return response()->json($consumosRegistrados, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConsumoCerda  $consumoCerda
     * @return \Illuminate\Http\Response
     */
    public function edit(ConsumoCerda $consumoCerda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConsumoCerda  $consumoCerda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        for ($i = 0; $i < Count($request[0]); $i++) {
            if (isset($request[$i])) {
                $campo = $request[$i]["campo"];
                $new_valor = $request[$i]["new_valor"];
                $id = $request[$i]["id"];

                if($campo != "f_inicial_update" && $campo != "f_final_update"){
                    DB::update(
                        "UPDATE consumo_cerda 
                                SET " . $campo . " = ? 
                                WHERE id = ?",
                        [$new_valor, $id]
                    );
                }else{
                    DB::update(
                        "UPDATE consumo_cerda 
                            SET ".$campo." = (SELECT id FROM calendario WHERE fecha = ?) 
                            WHERE id = ?", [$new_valor, $id]);
                }
            }
        }

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConsumoCerda  $consumoCerda
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConsumoCerda $consumoCerda)
    {
        //
    }
}
