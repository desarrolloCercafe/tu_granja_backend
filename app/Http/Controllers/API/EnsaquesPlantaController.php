<?php

namespace App\Http\Controllers\API;

use App\ensaques_planta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EnsaquesPlantaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ensaque = DB::select('SELECT ep.*, c.nombre_concentrado, op.consecutivo
        FROM ensaques_planta ep JOIN concentrados c, ordenes_produccion op
        WHERE c.id = ep.dieta AND ep.id_op = op.id
        ORDER BY ep.id DESC', []);

        /* $ensaque = ensaques_planta::all(); */
        return response()->json($ensaque, 200);
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
        $op = DB::select('SELECT id_dieta FROM ordenes_produccion op WHERE op.id = ?', [$request->id_op]);
        if ($op[0]->id_dieta == $request->dieta){
            $ensaque = new ensaques_planta();
            $ensaque->fecha = $request->fecha;
            $ensaque->id_op = $request->id_op;
            $ensaque->dieta = $request->dieta;
            $ensaque->bultos_meta = $request->bultos_meta*40;
            $ensaque->bultos_reales = $request->bultos_reales*40;
            $ensaque->observaciones = $request->observaciones;
            $ensaque->save();

            DB::update(
                'UPDATE ordenes_produccion SET cantidad_disponible = (cantidad_disponible + ?)
                WHERE id = ?', [$request->bultos_reales*40, $request->id_op]);

            return response()->json('OK', 200);
        } else {
            return response()->json('Dieta', 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ensaques_planta  $ensaques_planta
     * @return \Illuminate\Http\Response
     */
    public function show(ensaques_planta $ensaques_planta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ensaques_planta  $ensaques_planta
     * @return \Illuminate\Http\Response
     */
    public function edit(ensaques_planta $ensaques_planta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ensaques_planta  $ensaques_planta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ensaques_planta $ensaques_planta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ensaques_planta  $ensaques_planta
     * @return \Illuminate\Http\Response
     */
    public function destroy(ensaques_planta $ensaques_planta)
    {
        //
    }
}
