<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Descarte;
use App\HembrasDescarte;
use App\Calendario;
use App\Hembras;
use Illuminate\Support\Carbon;


class HembrasDescarteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        $hembra = new HembrasDescarte();
        $hembra->id_hembra = $request["cerda"];
        $hembra->id_descarte = $request["items"]["descarte"];
        $hembra->f_descarte = $request["items"]["semana"];
        if(!empty($request["items"]["observacion"])){
            $hembra->observacion = $request["items"]["observacion"];
        }
        $hembra->save();

        $update = Hembras::find($request["cerda"]);
        $update->estado = 1;
        $update->save();


        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HembrasDescarte  $hembrasDescarte
     * @return \Illuminate\Http\Response
     */
    public function show(HembrasDescarte $hembrasDescarte)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HembrasDescarte  $hembrasDescarte
     * @return \Illuminate\Http\Response
     */
    public function edit(HembrasDescarte $hembrasDescarte)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HembrasDescarte  $hembrasDescarte
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HembrasDescarte $hembrasDescarte)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HembrasDescarte  $hembrasDescarte
     * @return \Illuminate\Http\Response
     */
    public function destroy(HembrasDescarte $hembrasDescarte)
    {
        //
    }
}
