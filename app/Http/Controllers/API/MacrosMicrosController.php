<?php

namespace App\Http\Controllers\API;

use App\macros_micros;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MacrosMicrosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $MacroMicro = macros_micros::all();
        return response()->json($MacroMicro, 200);
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
        $MacroMicro = new macros_micros();
        $MacroMicro->fecha = $request->FechaMacroMicro;
        $MacroMicro->id_op = $request->OP;
        $MacroMicro->lote_azucar = $request->LoteAzucar;
        $MacroMicro->lote_carbonato = $request->LoteCarbonato;
        $MacroMicro->lote_fosfato = $request->LoteFosfato;
        $MacroMicro->lote_arroz = $request->LoteArroz;
        $MacroMicro->lote_hemoglobina = $request->LoteHemoglobina;
        $MacroMicro->lote_nucleo = $request->LoteNucleo;
        $MacroMicro->lote_plasma = $request->LotePlasma;
        $MacroMicro->lote_sal = $request->LoteSal;
        $MacroMicro->lote_otro = $request->LoteOtro;
        $MacroMicro->lote_aceite = $request->LoteAceite;
        $MacroMicro->macro_aceite = $request->MacroAceite;
        $MacroMicro->lote_gluten = $request->LoteGluten;
        $MacroMicro->macro_gluten = $request->MacroGluten;
        $MacroMicro->lote_pescado = $request->LotePescado;
        $MacroMicro->macro_pescado = $request->MacroPescado;
        $MacroMicro->lote_lactosuero = $request->LoteLactosuero;
        $MacroMicro->macro_lactosuero = $request->MacroLactosuero;
        $MacroMicro->lote_maiz = $request->LoteMaiz;
        $MacroMicro->macro_maiz = $request->MacroMaiz;
        $MacroMicro->lote_mogolla = $request->LoteMogolla;
        $MacroMicro->macro_mogolla = $request->MacroMogolla;
        $MacroMicro->lote_palmiste = $request->LotePalmiste;
        $MacroMicro->macro_palmiste = $request->MacroPalmiste;
        $MacroMicro->lote_salvado = $request->LoteSalvado;
        $MacroMicro->macro_salvado = $request->MacroSalvado;
        $MacroMicro->lote_soya = $request->LoteSoya;
        $MacroMicro->macro_soya = $request->MacroSoya;
        $MacroMicro->save();
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\macros_micros  $macros_micros
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $MacroMicro = DB::select('SELECT * FROM macros_micros WHERE id = ?', [$id]);
        return response()->json($MacroMicro[0], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\macros_micros  $macros_micros
     * @return \Illuminate\Http\Response
     */
    public function edit(macros_micros $macros_micros)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\macros_micros  $macros_micros
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $MacroMicro = DB::table('macros_micros')
        ->where('id', $id)
        ->update([
            'fecha' => $request["FechaMacroMicro"],
            'id_op' => $request["OP"],
            'lote_azucar' => $request["LoteAzucar"],
            'lote_carbonato' => $request["LoteCarbonato"],
            'lote_fosfato' => $request["LoteFosfato"],
            'lote_arroz' => $request["LoteArroz"],
            'lote_hemoglobina' => $request["LoteHemoglobina"],
            'lote_nucleo' => $request["LoteNucleo"],
            'lote_plasma' => $request["LotePlasma"],
            'lote_sal' => $request["LoteSal"],
            'lote_otro' => $request["LoteOtro"],
            'lote_aceite' => $request["LoteAceite"],
            'macro_aceite' => $request["MacroAceite"],
            'lote_gluten' => $request["LoteGluten"],
            'macro_gluten' => $request["MacroGluten"],
            'lote_pescado' => $request["LotePescado"],
            'macro_pescado' => $request["MacroPescado"],
            'lote_lactosuero' => $request["LoteLactosuero"],
            'macro_lactosuero' => $request["MacroLactosuero"],
            'lote_maiz' => $request["LoteMaiz"],
            'macro_maiz' => $request["MacroMaiz"],
            'lote_mogolla' => $request["LoteMogolla"],
            'macro_mogolla' => $request["MacroMogolla"],
            'lote_palmiste' => $request["LotePalmiste"],
            'macro_palmiste' => $request["MacroPalmiste"],
            'lote_salvado' => $request["LoteSalvado"],
            'macro_salvado' => $request["MacroSalvado"],
            'lote_soya' => $request["LoteSoya"],
            'macro_soya' => $request["MacroSoya"],
            ]);
        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\macros_micros  $macros_micros
     * @return \Illuminate\Http\Response
     */
    public function destroy(macros_micros $macros_micros)
    {
        //
    }
}