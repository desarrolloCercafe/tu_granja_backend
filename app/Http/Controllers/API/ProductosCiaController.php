<?php

namespace App\Http\Controllers\API;

use App\productos_cia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductosCiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Semen = productos_cia::all();
        return response()->json($Semen, 200);
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
     * @param  \App\productos_cia  $productos_cia
     * @return \Illuminate\Http\Response
     */
    public function show(productos_cia $productos_cia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\productos_cia  $productos_cia
     * @return \Illuminate\Http\Response
     */
    public function edit(productos_cia $productos_cia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\productos_cia  $productos_cia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, productos_cia $productos_cia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\productos_cia  $productos_cia
     * @return \Illuminate\Http\Response
     */
    public function destroy(productos_cia $productos_cia)
    {
        //
    }
}