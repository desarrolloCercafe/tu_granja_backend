<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Descarte;

class DescarteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $razones = Descarte::all();
        return response()->json($razones, 200);
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
     * @param  \App\Descarte  $descarte
     * @return \Illuminate\Http\Response
     */
    public function show(Descarte $descarte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Descarte  $descarte
     * @return \Illuminate\Http\Response
     */
    public function edit(Descarte $descarte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Descarte  $descarte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Descarte $descarte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Descarte  $descarte
     * @return \Illuminate\Http\Response
     */
    public function destroy(Descarte $descarte)
    {
        //
    }
}
