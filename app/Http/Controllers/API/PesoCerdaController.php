<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Carbon;
use App\PesoCerda;
use App\Hembras;
use App\Granjas;


class PesoCerdaController extends Controller
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
        foreach ($request["cerda"] as $cerda) {
            $fecha_id = DB::select(
                'SELECT id FROM calendario WHERE fecha = ?', [Carbon::parse($request["fecha"])]
            );

            $cerda_data = Hembras::where('id', $cerda["id"])->get();

            $f_nacimiento = Carbon::parse($cerda_data[0]["fecha_nacimiento"]);
            $f_pesaje = Carbon::parse($request["fecha"]);
            //return response()->json("1", 200);
            $diferencia_dias = $f_nacimiento->diffInDays(Carbon::parse($f_pesaje));
            //return response()->json("2", 200);
            $edad = $diferencia_dias;

            DB::insert(
                'INSERT INTO peso_cerda (id_hembra, f_pesaje, peso, edad) 
                VALUES (?, ?, ?, ?)', [$cerda["id"], $fecha_id[0]->id, $cerda["peso"], $edad]
            );
        }

        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PesoCerda  $pesoCerda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pesosRegistrados = DB::select(
            'SELECT 
                pc.id, c.fecha, pc.peso, g.nombre_granja as granja 
            FROM peso_cerda pc 
            INNER JOIN granjas g ON g.id = pc.id_granja 
            INNER JOIN registro_pesos rp ON rp.id = pc.id_registro 
            INNER JOIN calendario c ON c.id = pc.f_pesaje 
            WHERE rp.id_cerda = ?',
            [$id]
        );

        return response()->json($pesosRegistrados, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PesoCerda  $pesoCerda
     * @return \Illuminate\Http\Response
     */
    public function edit(PesoCerda $pesoCerda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PesoCerda  $pesoCerda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        for ($i = 0; $i < Count($request[0]); $i++) {
            if(isset($request[$i])){
                $campo = $request[$i]["campo"];
                $new_valor = $request[$i]["new_valor"];
                $id = $request[$i]["id"];
    
                if ($campo != "f_pesaje") {
                    DB::update(
                        'UPDATE peso_cerda 
                            SET ' . $campo . ' = ' . $new_valor . ' WHERE id =' . $id . '',
                        []
                    );
                } else {
                    $cerda = DB::select(
                        'SELECT rc.fecha_nacimiento 
                            FROM registro_cerda rc 
                            INNER JOIN registro_pesos rp ON rp.id_cerda = rc.id 
                            INNER JOIN peso_cerda pc ON pc.id_registro = rp.id 
                            WHERE pc.id = ?',
                        [$id]
                    );
    
                    $f_nacimiento = Carbon::parse($cerda[0]->fecha_nacimiento);
                    $f_pesaje = Carbon::parse($new_valor);
                    $diferencia_dias = $f_nacimiento->diffInDays($f_pesaje);
                    $edad = $diferencia_dias;
    
                    DB::update(
                        'UPDATE peso_cerda 
                            SET f_pesaje = (SELECT id FROM calendario WHERE fecha = ?), edad = ? 
                            WHERE id = ?',
                        [$f_pesaje, $edad, $id]
                    );
                }
            }else{
                continue;
            }
        }

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PesoCerda  $pesoCerda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::delete('DELETE FROM peso_cerda WHERE id = ?', [$id]);
        DB::delete('DELETE FROM consumo_cerda WHERE id_peso = ?', [$id]);

        return response()->json("OK", 200);
    }
}
