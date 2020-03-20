<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\GranjasAsociadas;
use App\GranjasAsociadasCiclos;
use DB;

class GranjasAsociadasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $granjas = GranjasAsociadasCiclos::All();
        return response()->json($granjas, 200);
        //
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
        $permisos = GranjasAsociadas::where(array('granja_id' => $request->granja, 'user_id' => $request->user))->get();

        if(Count($permisos)){
            return response()->json("Existe", 200);
        }else{
            $permiso = new GranjasAsociadas();
            $permiso->granja_id = $request->granja;
            $permiso->user_id = $request->user;
            $permiso->save();
            return response()->json("OK", 200);
        }
        //return response()->json($data, 200, $headers);
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
        $permisos = GranjasAsociadas::find($id);
        $permisos->delete();
        return response()->json("OK", 200);
    }

    public function getAllGranjasAsociadas(){
        $granjas = DB::select(
            'SELECT ga.id, g.nombre_granja, u.nombre_completo 
                FROM granjas g 
                INNER JOIN granjas_asociadas ga ON ga.granja_id = g.id 
                INNER JOIN users u ON u.id = ga.user_id', []
        );

        return response()->json($granjas, 200);
    }
}
