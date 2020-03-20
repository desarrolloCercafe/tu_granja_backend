<?php

namespace App\Http\Controllers\API;

use App\Lote;
use App\calendario;
use App\Corral;
use App\HembraCorral;
use App\Hembras;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Carbon;

class LoteController extends Controller
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
        //return response()->json($request->body[0]['corral'], 200);
        if($request->body[0]['corral'] != ""){
            $calendario = calendario::where('fecha', $request->header["f_apertura"])->get();

            $lote = new Lote();
            $lote->cod_lote = strtoupper(trim($request->header["lote"]));
            $lote->f_apertura = $calendario[0]->id;
            /* $lote->f_apertura = $request->header["f_apertura"]; */
            $lote->id_granja = $request->header["granja"];
            $lote->save();
    
            $lote = DB::table('lote')->where(array(
                'cod_lote' => strtoupper(trim($request->header["lote"])),
                'id_granja' => $request->header["granja"],
                'f_apertura' => $calendario[0]->id
                /* 'f_apertura' => $request->header["granja"] */
            ))->get();
    
            foreach ($request->body as $cerdasCorral) {
                $corral = Corral::where('cod_corral', $cerdasCorral["corral"])->get();
                DB::insert(
                    'INSERT INTO corral_hembra (id_corral, id_hembra, id_lote, sobrenombre) VALUES (?, ?, ?, ?)',
                    [$corral[0]->id, $cerdasCorral["id"], $lote[0]->id, $cerdasCorral["sobrenombre"]]
                );
            }
            return response()->json("OK", 200);
        } else {
            return response()->json("Faltan corrales", 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infoLote = Lote::where('id_granja', $id)->get();
        return response()->json($infoLote, 200);
    }

    public function getDataLote($id){
        //$infoLote = DB::select('SELECT g.nombre_granja, l.consec_lote, l.f_inicial, l.num_animales, l.edad_inicial, l.peso_ini', [1])
        $infoLote = DB::table('lote_cerdos')
                        ->join('granjas', 'lote_cerdos.id_granja', '=', 'granjas.id')
                        ->where('lote_cerdos.id_lote', '=', $id)
                        ->select('lote_cerdos.*', 'granjas.nombre_granja')
                        ->get();

        return response()->json($infoLote[0], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit(Lote $lote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lote $lote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lote $lote)
    {
        //
    }
}
