<?php

namespace App\Http\Controllers\API;

use App\Hembras;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Carbon;

class HembrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cerdas = DB::select(
            'SELECT g.nombre_granja as granja, rc.id, rc.cod_cerda, rc.cod_madre, rc.cod_padre,
            rc.fecha_nacimiento, rc.num_pezones_funcionales as pezones, rc.peso_nacimiento,
            rc.peso_28 as peso, rc.estado, rc.tipo_pesaje, rc.fecha_registro
            FROM registro_cerda rc 
            INNER JOIN granjas g ON g.id = rc.granja_inicial', []);

        return response()->json($cerdas, 200);

        /* $cerdas = Hembras::all();
        return response()->json($cerdas, 200); */
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
        $nombre = DB::select('SELECT * FROM registro_cerda WHERE cod_cerda = ?', [strtoupper($request->codigo)]);

        if (count($nombre)){
            return response()->json("Nombre", 200);
        } else {
            $cerda = new Hembras();
            $cerda->cod_cerda = strtoupper($request->codigo);
            $cerda->genetica = strtoupper($request->genetica);
            $cerda->cod_madre = strtoupper($request->cod_madre);
            $cerda->cod_padre = strtoupper($request->cod_padre);
            $cerda->fecha_nacimiento =  $request->fecha;
            $cerda->peso_nacimiento = $request->peso_nacimiento;
            $cerda->tipo_pesaje = $request->tipo_pesaje;
            $cerda->f_envio = $request->f_envio;
            $cerda->peso_28 = $request->peso;
            $cerda->granja_inicial = $request->granja;
            $cerda->num_pezones_funcionales = $request->pezones;
            $cerda->fecha_registro = $request->fecha_registro;
            $cerda->estado = 0;
            $cerda->save();
            return response()->json("OK", 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hembras  $hembras
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        if($user[0]->rol_id == 6 || $user[0]->rol_id == 10 || $user[0]->rol_id == 7){
            $cerdas = DB::select(
                'SELECT g.nombre_granja as granja, rc.id, rc.cod_cerda, rc.cod_madre, rc.cod_padre,
                rc.fecha_nacimiento, rc.num_pezones_funcionales as pezones, rc.peso_nacimiento,
                rc.peso_28 as peso, rc.estado, rc.tipo_pesaje, rc.fecha_registro
                FROM registro_cerda rc
                INNER JOIN granjas g ON g.id = rc.granja_inicial

                INNER JOIN granjas_asociadas ON granjas_asociadas.granja_id = g.id
                INNER JOIN users ON users.id = granjas_asociadas.user_id
                WHERE users.id = ?', [$id]);
        } else {
            $cerdas = Hembras::All();
        }
        return response()->json($cerdas, 200);
    }

    public function searchHembra(Request $request){

        switch ($request["type"]) {
            case '1':
                $hembra = DB::table('registro_cerda')->where(array(
                    'cod_cerda' => strtoupper(trim($request["content"])),
                    'granja_inicial' => $request["granja"]
                ))->get();
                break;
            case '2':
                $hembra = DB::table('registro_cerda')->where(array(
                    'f_envio' => Carbon::parse($request["content"]),
                    'granja_inicial' => $request["granja"]
                ))->get();
            break;
            default:
            $hembra = DB::table('registro_cerda')->where(array(
                'cod_cerda' => strtoupper(trim($request["content"]["hembra"])),
                'f_envio' => Carbon::parse($request["content"]["f_nacimiento"]),
                'granja_inicial' => $request["granja"]
            ))->get();
                break;
        }

        return response()->json($hembra, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hembras  $hembras
     * @return \Illuminate\Http\Response
     */
    public function edit(Hembras $hembras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hembras  $hembras
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hembra =  Hembras::find($id);
        $hembra->f_servicio = $request["fecha"];
        $hembra->save();
        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hembras  $hembras
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hembras $hembras)
    {
        //
    }
}