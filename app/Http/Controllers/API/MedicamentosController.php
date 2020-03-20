<?php

namespace App\Http\Controllers\API;

use App\medicamentos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MedicamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Medicamentos = medicamentos::all();
        return response()->json($Medicamentos, 200);
        /* $Medicamentos = DB::select('SELECT * FROM medicamentos WHERE tipo_medicamento = ? OR tipo_medicamento = ?',
        ['MEDICAMENTOS', 'BIOLOGICO']); */
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
     * @param  \App\medicamentos  $medicamentos
     * @return \Illuminate\Http\Response
     */
    public function show(medicamentos $medicamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\medicamentos  $medicamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(medicamentos $medicamentos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\medicamentos  $medicamentos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, medicamentos $medicamentos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\medicamentos  $medicamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(medicamentos $medicamentos)
    {
        //
    }
}