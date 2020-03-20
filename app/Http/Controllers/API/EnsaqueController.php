<?php

namespace App\Http\Controllers\API;

use App\Ensaque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\ordenes_produccion;

class EnsaqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Ensaque = Ensaque::all();
        return response()->json($Ensaque, 200);
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
        $Ensaque = new Ensaque();
        $Ensaque->FechaEnsaque = $request->FechaEnsaque;
        $Ensaque->OP = $request->OP;
        $Ensaque->BultosMeta = $request->BultosMeta*40;
        $Ensaque->BultosReales = $request->BultosReales*40;

        $OP = DB::select('SELECT id_dieta, cantidad_baches FROM ordenes_produccion WHERE id = ?', [$request->OP]);
        /* return response()->json($OP, 200); */

        $Ensaque->Dieta = $OP[0]->id_dieta;
        $Ensaque->CantidadBaches = $OP[0]->cantidad_baches;

        $idDieta = DB::select('SELECT Dieta FROM bodega_dietas WHERE Dieta = ?', [$OP[0]->id_dieta]);

        if (Count($idDieta)){
            $Ensaque->save();
            DB::update(
                'UPDATE bodega_dietas SET Cantidad = (Cantidad + ?) WHERE Dieta = ?',
                [$request->BultosReales*40, $OP[0]->id_dieta]
            );
            return response()->json("OK", 200);
        } else {
            return response()->json("Doble", 200);
        }

        /* $Ensaque->save();
        DB::update(
            'UPDATE bodega_dietas SET Cantidad = (Cantidad + ?) WHERE Dieta = ?',
            [$request->BultosReales*40, $OP[0]->id_dieta]
        );
        return response()->json("OK", 200); */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ensaque  $ensaque
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $Ensaque = Ensaque::select('ensaque.id', 'ensaque.FechaEnsaque', 'ordenes_produccion.consecutivo',
        'ensaque.BultosReales', 'ensaque.CantidadBaches')
        ->join('ordenes_produccion', 'OP', '=', 'ordenes_produccion.id')
        ->where('Dieta', $id)->get();

        if (!Count($Ensaque)){
            return response()->json("Nada", 200);
        } else {
            return response()->json($Ensaque, 200);
        }

        
        /* BUENO
        $Ensaque = DB::select('SELECT * FROM ensaque WHERE Dieta = ?', [$id]);

        if (!Count($Ensaque)){
            return response()->json("Nada", 200);
        } else {
            return response()->json($Ensaque, 200);
        } */


        /* $Ensaque = DB::select('SELECT FechaEnsaque, OP, BultosReales, CantidadBaches
        FROM ensaque WHERE Dieta = ?', [$id]);
        return response()->json($Ensaque, 200); */

        /* $Ensaque = Ensaque::select('ensaque.FechaEnsaque', 'ensaque.OP', 'ensaque.BultosReales', 'ensaque.CantidadBaches')
        ->where('Dieta', $id)->get(); */
        

        /* $Ensaque = Ensaque::all();
        return response()->json($Ensaque, 200); */

        /* $Ensaque = new Ensaque();
        $Ensaque->FechaEnsaque = $request->FechaEnsaque;
        $Ensaque->OP = $request->OP;
        $Ensaque->BultosMeta = $request->BultosMeta;
        $Ensaque->BultosReales = $request->BultosReales;

        $OP = DB::select('SELECT id_dieta, cantidad_baches FROM ordenes_produccion WHERE id = ?', [$request->OP]);
        return response()->json($OP, 200);

        $Ensaque->Dieta = $OP[0]->id_dieta;
        $Ensaque->CantidadBaches = $OP[0]->cantidad_baches;

        $Ensaque->save();

        return response()->json("OK", 200); */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ensaque  $ensaque
     * @return \Illuminate\Http\Response
     */
    public function edit(Ensaque $ensaque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ensaque  $ensaque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ensaque $ensaque)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ensaque  $ensaque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ensaque $ensaque)
    {
        //
    }
}