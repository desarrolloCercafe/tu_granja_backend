<?php

namespace App\Http\Controllers\API;

use App\Despachos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\bodegasGranjas;

class DespachosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Despachos = Despachos::select('despachos.idDespacho', 'despachos.FechaDespacho', 'despachos.OP',
        'ordenes_produccion.consecutivo', 'concentrados.nombre_concentrado', 'despachos.Cantidad', 'granjas.nombre_granja')
        ->join('granjas', 'despachos.GranjaDestino', '=', 'granjas.id')
        ->join('concentrados', 'despachos.Dieta', '=', 'concentrados.id')
        ->join('ordenes_produccion', 'OP', '=', 'ordenes_produccion.id')
        ->get();
        return response()->json($Despachos, 200);
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
        if ($request->Dieta == $request->DietaOP){
            $Despachos = new Despachos();
            $Despachos->FechaDespacho = $request->FechaDespacho;
            $Despachos->GranjaDestino = $request->GranjaDestino;
            $Despachos->Dieta = $request->Dieta;
            $Despachos->OP = $request->OP;
            /* $Despachos->LoteProduccion = $request->LoteProduccion; */
            $Despachos->Cantidad = $request->Cantidad*40;
            $Despachos->save();

            DB::update(
                'UPDATE bodegasgranjas SET cantidad = (cantidad + ?) WHERE id_granja = ? AND dieta = ?',
                [$request->Cantidad*40, $request->GranjaDestino, $request->Dieta]);
            DB::update(
                'UPDATE bodega_dietas SET Cantidad = (Cantidad - ?) WHERE Dieta = ?',
                [$request->Cantidad*40, $request->Dieta]);

            return response()->json("OK", 200);
        } else {
            return response()->json("Dieta", 200);
        }
        

        /* DB::update('bodegasgranjas')
        ->where('despachos.Dieta', '=', 'bodegasgranjas.dieta')
        ->where('despachos.GranjaDestino', '=', 'bodegasgranjas.id_granja')
        ->get(); */

        /* $cilo = bodegasGranjas::find($id);
        $cilo->cantidad = $cilo->cantidad + $request->Cantidad;
        $cilo->save(); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Despachos  $despachos
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Despachos = Despachos::select('despachos.idDespacho', 'despachos.FechaDespacho', 'ordenes_produccion.consecutivo',
        'concentrados.nombre_concentrado', 'despachos.Cantidad', 'granjas.nombre_granja')
        ->join('granjas', 'despachos.GranjaDestino', '=', 'granjas.id')
        ->join('concentrados', 'despachos.Dieta', '=', 'concentrados.id')
        ->join('ordenes_produccion', 'despachos.OP', '=', 'ordenes_produccion.id')
        ->where('idDespacho', $id)->get();
        return response()->json($Despachos[0], 200);
    }

    public function GetDietaByGranja($id)
    {
        $Dietas = DB::table('concentrados')
        ->join('bodegasgranjas', 'bodegasgranjas.dieta', '=', 'concentrados.id')
        ->select('concentrados.id', 'concentrados.nombre_concentrado')
        ->where('bodegasgranjas.id_granja', $id)->get();

        return response()->json($Dietas, 200);
    }

    public function GetDietaByOP($id)
    {
        /* $Dieta = DB::table('concentrados')
        ->join('ordenes_produccion', 'ordenes_produccion.id_dieta', '=', 'concentrados.id')
        ->select('concentrados.id', 'concentrados.nombre_concentrado', 'ordenes_produccion.cantidad_baches')
        ->where('concentrados.id', $id)->get(); */

        $Dieta = DB::select('SELECT c.id, c.nombre_concentrado, op.cantidad_baches
        FROM concentrados c JOIN ordenes_produccion op
        WHERE op.id = ? AND op.id_dieta = c.id', [$id]);

        return response()->json($Dieta, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Despachos  $despachos
     * @return \Illuminate\Http\Response
     */
    public function edit(Despachos $despachos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Despachos  $despachos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Despachos = DB::table('despachos')
        ->where('idDespacho', $id)
        ->update([
            'FechaDespacho' => $request['FechaDespacho'],
            'OP' => $request['OP'],
            'Dieta' => $request['Dieta'],
            /* 'LoteProduccion' => $request['LoteProduccion'], */
            'Cantidad' => $request['Cantidad'],
            'GranjaDestino' => $request['GranjaDestino'],
        ]);

        /* DB::update(
            'UPDATE bodegasgranjas SET cantidad = (cantidad + ?) WHERE id_granja = ? AND dieta = ?',
            [$request->Cantidad*40, $request->GranjaDestino, $request->Dieta]
        ); */

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Despachos  $despachos
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Dieta = despachos::select('Dieta', 'Cantidad', 'GranjaDestino')
        ->where('idDespacho', $id)->get();

        DB::update(
            'UPDATE bodegasgranjas SET cantidad = (cantidad - ?) WHERE id_granja = ? AND dieta = ?',
            [$Dieta[0]->Cantidad, $Dieta[0]->GranjaDestino, $Dieta[0]->Dieta]);
        DB::update(
            'UPDATE bodega_dietas SET Cantidad = (Cantidad + ?) WHERE Dieta = ?',
            [$Dieta[0]->Cantidad, $Dieta[0]->Dieta]);

        DB::table('despachos')->where('idDespacho', $id)->delete();
        
        return response()->json("OK", 200);
    }
}