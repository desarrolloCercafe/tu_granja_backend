<?php

namespace App\Http\Controllers\API;

use App\BodegaDietas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class BodegaDietasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Bodega = BodegaDietas::select('bodega_dietas.id', 'bodega_dietas.FechaBodega',
        'bodega_dietas.Dieta', 'concentrados.nombre_concentrado', 'bodega_dietas.Cantidad')
        ->join('concentrados', 'bodega_dietas.Dieta', '=', 'concentrados.id')
        ->get();
        return response()->json($Bodega, 200);
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
        $Bodega = new BodegaDietas();
        $Bodega->FechaBodega = $request->FechaBodega;
        $Bodega->Dieta = $request->Dieta;
        if ($request->Cantidad == null){
            $request->Cantidad = 0;
        }
        $Bodega->Cantidad = $request->Cantidad*40;

        $idDieta = DB::select('SELECT Dieta FROM bodega_dietas WHERE Dieta = ?', [$request->Dieta]);
        /* return response()->json($idDieta, 200); */

        if (Count($idDieta)){
            return response()->json("Doble", 200);
        } else {
            $Bodega->save();
            return response()->json("OK", 200);
        }
        /* $OP = DB::select('SELECT id_dieta, cantidad_baches FROM ordenes_produccion WHERE id = ?', [$request->OP]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BodegaDietas  $bodegaDietas
     * @return \Illuminate\Http\Response
     */
    public function show(BodegaDietas $bodegaDietas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BodegaDietas  $bodegaDietas
     * @return \Illuminate\Http\Response
     */
    public function edit(BodegaDietas $bodegaDietas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BodegaDietas  $bodegaDietas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BodegaDietas $bodegaDietas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BodegaDietas  $bodegaDietas
     * @return \Illuminate\Http\Response
     */
    public function destroy(BodegaDietas $bodegaDietas)
    {
        //
    }
}