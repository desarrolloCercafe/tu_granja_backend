<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Causas;

class CausasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $causas = Causas::all();
        return response()->json($causas, 200);
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
     * @param  \App\Causas  $causas
     * @return \Illuminate\Http\Response
     */
    public function show(Causas $causas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Causas  $causas
     * @return \Illuminate\Http\Response
     */
    public function edit(Causas $causas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Causas  $causas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Causas $causas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Causas  $causas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Causas $causas)
    {
        //
    }
}
