<?php

namespace App\Http\Controllers\API;

use App\peso_ensaque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PesoEnsaqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $PesoEnsaque = peso_ensaque::all();
        return response()->json($PesoEnsaque, 200);
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
        $PesoEnsaque = new peso_ensaque();
        $PesoEnsaque->FechaPesoEnsaque = $request->FechaPesoEnsaque;
        $PesoEnsaque->OP = $request->OP;
        $PesoEnsaque->TemperaturaPromedio = $request->TemperaturaPromedio;
        $PesoEnsaque->Densidad = $request->Densidad;
        $PesoEnsaque->PesoE1 = $request->PesoE1;
        $PesoEnsaque->PesoA1 = $request->PesoA1;
        $PesoEnsaque->PesoE2 = $request->PesoE2;
        $PesoEnsaque->PesoA2 = $request->PesoA2;
        $PesoEnsaque->PesoE3 = $request->PesoE3;
        $PesoEnsaque->PesoA3 = $request->PesoA3;
        $PesoEnsaque->PesoE4 = $request->PesoE4;
        $PesoEnsaque->PesoA4 = $request->PesoA4;
        $PesoEnsaque->PesoE5 = $request->PesoE5;
        $PesoEnsaque->PesoA5 = $request->PesoA5;
        $PesoEnsaque->PesoE6 = $request->PesoE6;
        $PesoEnsaque->PesoA6 = $request->PesoA6;
        $PesoEnsaque->PesoE7 = $request->PesoE7;
        $PesoEnsaque->PesoA7 = $request->PesoA7;
        $PesoEnsaque->PesoE8 = $request->PesoE8;
        $PesoEnsaque->PesoA8 = $request->PesoA8;
        $PesoEnsaque->PesoE9 = $request->PesoE9;
        $PesoEnsaque->PesoA9 = $request->PesoA9;
        $PesoEnsaque->PesoE10 = $request->PesoE10;
        $PesoEnsaque->PesoA10 = $request->PesoA10;
        $PesoEnsaque->save();
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\peso_ensaque  $peso_ensaque
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $PesoEnsaque = DB::select('SELECT * FROM peso_ensaque WHERE id = ?', [$id]);
        return response()->json($PesoEnsaque[0], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\peso_ensaque  $peso_ensaque
     * @return \Illuminate\Http\Response
     */
    public function edit(peso_ensaque $peso_ensaque)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\peso_ensaque  $peso_ensaque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $PesoEnsaque = DB::table('peso_ensaque')
        ->where('id', $id)
        ->update([
            'FechaPesoEnsaque' => $request["FechaPesoEnsaque"],
            'OP' => $request["OP"],
            'TemperaturaPromedio' => $request["TemperaturaPromedio"],
            'Densidad' => $request["Densidad"],
            'PesoE1' => $request["PesoE1"],
            'PesoA1' => $request["PesoA1"],
            'PesoE2' => $request["PesoE2"],
            'PesoA2' => $request["PesoA2"],
            'PesoE3' => $request["PesoE3"],
            'PesoA3' => $request["PesoA3"],
            'PesoE4' => $request["PesoE4"],
            'PesoA4' => $request["PesoA4"],
            'PesoE5' => $request["PesoE5"],
            'PesoA5' => $request["PesoA5"],
            'PesoE6' => $request["PesoE6"],
            'PesoA6' => $request["PesoA6"],
            'PesoE7' => $request["PesoE7"],
            'PesoA7' => $request["PesoA7"],
            'PesoE8' => $request["PesoE8"],
            'PesoA8' => $request["PesoA8"],
            'PesoE9' => $request["PesoE9"],
            'PesoA9' => $request["PesoA9"],
            'PesoE10' => $request["PesoE10"],
            'PesoA10' => $request["PesoA10"],
            ]);
        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\peso_ensaque  $peso_ensaque
     * @return \Illuminate\Http\Response
     */
    public function destroy(peso_ensaque $peso_ensaque)
    {
        //
    }
}