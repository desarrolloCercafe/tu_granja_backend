<?php

namespace App\Http\Controllers\API;

use App\LineasGenetica;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LineasGeneticaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genetica = LineasGenetica::all();
        return response()->json($genetica, 200);
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
     * @param  \App\LineasGenetica  $lineasGenetica
     * @return \Illuminate\Http\Response
     */
    public function show(LineasGenetica $lineasGenetica)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LineasGenetica  $lineasGenetica
     * @return \Illuminate\Http\Response
     */
    public function edit(LineasGenetica $lineasGenetica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LineasGenetica  $lineasGenetica
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LineasGenetica $lineasGenetica)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LineasGenetica  $lineasGenetica
     * @return \Illuminate\Http\Response
     */
    public function destroy(LineasGenetica $lineasGenetica)
    {
        //
    }
}
