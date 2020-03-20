<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Granjas;
use DB;

class GranjasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granjas = Granjas::All();
        return response($granjas, 200);
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
        try{
            $granjas = Granjas::all();
            $granja =new Granjas;
            $granja->nombre_granja = $request->nombre_granja;
            $granja->descripcion_granja = $request->descripcion_granja;
            $granja->direccion_granja = $request->direccion_granja;
            $granja->numero_contacto_granja = $request->numero_contacto_granja;
            $granja->porcentaje_precebo = $request->porcentaje_precebo;
            $granja->porcentaje_ceba = $request->porcentaje_ceba;
            $granja->save();
            return response()->json("Se creo correctamente", 201);
        } catch (Exception $ex) {
            return response()->json($ex, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        if ($user[0]->rol_id == 6 || $user[0]->rol_id == 10 || $user[0]->rol_id == 7){
            $granjas = DB::select(
                'SELECT granjas.* FROM granjas
                INNER JOIN granjas_asociadas ON granjas_asociadas.granja_id = granjas.id
                INNER JOIN users ON users.id = granjas_asociadas.user_id
                WHERE users.id = ?', [$id]);
        } else {
            $granjas = Granjas::All(); }

        return response()->json($granjas, 200);
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
