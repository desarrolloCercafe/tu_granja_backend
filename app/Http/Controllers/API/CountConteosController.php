<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CountConteosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $medicamentos = DB::select("SELECT COUNT(*) AS conteo FROM informe_medicamentos");
        //  $medicamentos = DB::table('informe_medicamentos')->selectRaw('*, count(*) as conteo')->groupBy('id');
        $calidad = DB::select("SELECT COUNT(*) AS conteo FROM informe_calidad");
        $mantenimiento = DB::select("SELECT COUNT(*) AS conteo FROM informe_mantenimiento");
        $dotacion = DB::select("SELECT COUNT(*) AS conteo FROM informe_dotacion");
        $desposte = DB::select('SELECT COUNT(*) AS conteo FROM informe_desposte');
        $mt = DB::select('SELECT COUNT(*) AS conteo FROM informe_mt');
        $pt = DB::select('SELECT COUNT(*) AS conteo FROM informe_pt');

        return response()->json([
            "medicamentos" => $medicamentos, 
            "calidad" => $calidad, 
            "mantenimiento" => $mantenimiento, 
            "dotacion" => $dotacion,
            "desposte" => $desposte,
            "mt" => $mt,
            "pt" => $pt
        ], 200);
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
