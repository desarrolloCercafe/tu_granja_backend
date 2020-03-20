<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\VisitasTecnica;

class FilterVisitasTecnicasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $informe = DB::table('informe_visitas_tecnica')
        ->where('informe_visitas_tecnica.id', $request->id)
        ->join('granjas', 'informe_visitas_tecnica.id_granja', '=', 'granjas.id')
        ->join('fuente_agua', 'informe_visitas_tecnica.id_fuente_agua', '=', 'fuente_agua.id')
        ->join('suministro_agua', 'informe_visitas_tecnica.id_suministro_agua', '=', 'suministro_agua.id')
        ->select('informe_visitas_tecnica.*', 'fuente_agua.fuente', 'suministro_agua.suminsitro', 'granjas.nombre_granja')
        ->get();
        return response($informe, 200);
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
