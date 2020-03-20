<?php

namespace App\Http\Controllers\API;

use App\MateriasPrimas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MateriasPrimasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mat = MateriasPrimas::all();
        return response()->json($mat, 200);
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
    public function store(Request $request){
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MateriasPrimas  $materiasPrimas
     * @return \Illuminate\Http\Response
     */
    public function show(MateriasPrimas $materiasPrimas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MateriasPrimas  $materiasPrimas
     * @return \Illuminate\Http\Response
     */
    public function edit(MateriasPrimas $materiasPrimas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MateriasPrimas  $materiasPrimas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MateriasPrimas $materiasPrimas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MateriasPrimas  $materiasPrimas
     * @return \Illuminate\Http\Response
     */
    public function destroy(MateriasPrimas $materiasPrimas)
    {
        //
    }
}