<?php

namespace App\Http\Controllers\API;

//use App\celo;
use App\Celo;
use App\Hembras;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Support\Carbon;

class ApiDataCercafeController extends Controller
{

    public function showConsumosHembra(){
        $consumos = DB::select(
            'SELECT 
                rc.cod_cerda, rc.cod_madre, rc.cod_padre, 
                rc.fecha_nacimiento, rc.peso_nacimiento, rc.peso_28, 
                rc.num_pezones_funcionales, rc.fecha_registro, rp.apellido,
                rp.lote, rp.f_primer_servicio, pc.f_pesaje, pc.peso, pc.edad,
                cc.f_inicio, cc.f_final, cc.consumo, c.nombre_concentrado as dieta,
                g.nombre_granja as granja
            FROM registro_cerda rc 
            INNER JOIN registro_pesos rp ON rp.id_cerda = rc.id 
            INNER JOIN peso_cerda pc ON pc.id_registro = rp.id
            INNER JOIN consumo_cerda cc ON cc.id_peso = pc.id
            INNER JOIN concentrados c ON c.id = cc.id_dieta
            INNER JOIN granjas g ON g.id = pc.id_granja
            GROUP BY cc.id', []);

        return response()->json($consumos, 200);
    }

    public function ShowCelosHembra(){
        $celos = DB::select(
            'SELECT 
                rc.cod_cerda, cc.num_celo, cc.fecha 
            FROM celos_cerda cc 
            INNER JOIN registro_cerda rc ON rc.id = cc.id_cerda', []);

        return response()->json($celos, 200);
    }

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
