<?php

namespace App\Http\Controllers\API;

use App\bodegas_granjas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
/* use App\Granjas; */

class BodegasGranjasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $bodega = bodegas_granjas::select('bodegas_granjas.id_bodega', 'granjas.nombre_granja',
        'bodegas_granjas.nombre_bodega', 'bodegas_granjas.capacidad', 'concentrados.nombre_concentrado',
        'bodegas_granjas.unidad_medida', 'bodegas_granjas.cantidad')
        ->join('granjas', 'bodegas_granjas.id_granja', '=', 'granjas.id')
        ->join('concentrados', 'bodegas_granjas.dieta', '=', 'concentrados.id')
        ->get(); */

        $bodega = bodegas_granjas::select('bodegas_granjas.*', 'granjas.nombre_granja', 'concentrados.nombre_concentrado')
        ->join('granjas', 'bodegas_granjas.id_granja', '=', 'granjas.id')
        ->join('concentrados', 'bodegas_granjas.dieta', '=', 'concentrados.id')
        ->get();

        $i = 0;
        foreach($bodega as $bodegas){
            $divisor = 1;
            if ($bodega[$i]->unidad_medida == "ton"){
                $divisor = 1000;
            } elseif ($bodega[$i]->unidad_medida == "bul"){
                $divisor = 40;
            }
            $bodega[$i]->capacidad = $bodega[$i]->capacidad/$divisor;
            $bodega[$i]->cantidad = $bodega[$i]->cantidad/$divisor;
            $i++;
        }
        return response()->json($bodega, 200);

        /* Ejemplo
        $corrales = Corral::select('corral.id', 'corral.cod_corral', 'granjas.nombre_granja')
        ->join('granjas', 'corral.id_granja', '=', 'granjas.id')
        ->get(); */

        /* $bodega = bodegas_granjas::all();
        return response()->json($bodega, 200); */
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
        $unidad = 1;
        $bodega = new bodegas_granjas();
        $bodega->id_granja = $request->id_granja;
        $bodega->nombre_bodega = $request->nombre_bodega;
        $bodega->dieta = $request->dieta;
        if ($request->unidad_medida == 'bul'){
            $unidad = 40;
        } else if ($request->unidad_medida == 'ton'){
            $unidad = 1000;
        }
        $bodega->unidad_medida = $request->unidad_medida;
        $bodega->capacidad = $request->capacidad*$unidad;
        $bodega->cantidad = $request->cantidad*$unidad;

        $dieta = DB::select('SELECT dieta FROM bodegas_granjas WHERE dieta = ? AND id_granja = ?',
        [$request->dieta, $request->id_granja]);

        if (Count($dieta)){
            return response()->json("Doble", 200);
        } else {
            $bodega->save();
            return response()->json("OK", 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\bodegas_granjas  $bodegas_granjas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bodega = bodegas_granjas::select('bodegas_granjas.id_bodega', 'granjas.nombre_granja',
        'bodegas_granjas.nombre_bodega', 'bodegas_granjas.capacidad', 'concentrados.nombre_concentrado',
        'bodegas_granjas.unidad_medida', 'bodegas_granjas.cantidad')
        ->join('granjas', 'bodegas_granjas.id_granja', '=', 'granjas.id')
        ->join('concentrados', 'bodegas_granjas.dieta', '=', 'concentrados.id')
        ->where('id_bodega', $id)->get();

        $divisor = 1;

        if($bodega[0]->unidad_medida == "ton"){
            $divisor = 1000;
        }elseif($bodega[0]->unidad_medida == "bul"){
            $divisor = 40;
        }

        $bodega[0]->capacidad = $bodega[0]->capacidad/$divisor;
        $bodega[0]->cantidad = $bodega[0]->cantidad/$divisor;

        return response()->json($bodega[0], 200);

        /* $bodega = bodegas_granjas::where('id_bodega', $id)->get();
        return response()->json($bodega, 200); */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\bodegas_granjas  $bodegas_granjas
     * @return \Illuminate\Http\Response
     */
    public function edit(bodegas_granjas $bodegas_granjas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\bodegas_granjas  $bodegas_granjas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $multiplicador = 1;
        if ($request->unidad_medida == 'ton'){
            $multiplicador = 1000;            
        } elseif ($request->unidad_medida == 'bul'){
            $multiplicador = 40;
        }
        $bodega = DB::table('bodegas_granjas')
        ->where('id_bodega', $id)
        ->update([
            'nombre_bodega' => $request["nombre_bodega"],
            'dieta' => $request["dieta"],
            'unidad_medida' => $request["unidad_medida"],
            'capacidad' => $request["capacidad"]*$multiplicador,
            'cantidad' => $request["cantidad"]*$multiplicador,
            ]);
        return response()->json("OK", 200);

        /* $bodega = DB::table('bodegas_granjas')
        ->where('id_bodega', $id)
        ->update([
            'nombre_bodega' => $request["nombre_bodega"],
            'dieta' => $request["dieta"],
            'unidad_medida' => $request["unidad_medida"],
            'capacidad' => $request["capacidad"],
            'cantidad' => $request["cantidad"],
            ]);
        return response()->json("OK", 200); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\bodegas_granjas  $bodegas_granjas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('bodegas_granjas')->where('id_bodega', $id)->delete();
        return response()->json("OK", 200);
    }
}
