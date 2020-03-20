<?php

namespace App\Http\Controllers\API;

//use App\celo;
use App\Celo;
use App\Hembras;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Support\Carbon;

class CeloController extends Controller
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
        $id_fecha = DB::select('SELECT id FROM calendario WHERE fecha = ?', [$request->fecha]);

        DB::insert(
            'INSERT INTO celos_cerda 
                (id_cerda, fecha, num_celo) 
            VALUES (?, ?, ?)', [$request->cerda, $id_fecha[0]->id, $request->num_celo]);

        $cerda = DB::select(
                'SELECT MAX(cc.num_celo) as num_celo 
                FROM celos_cerda cc 
                INNER JOIN registro_cerda rc ON rc.id = cc.id_cerda 
                WHERE rc.id = ?', 
                    [$request->cerda]);

                return response()->json($cerda[0], 200);

        //return response()->json($request, 200);


/*         if(isset($request->celos)){

            foreach ($request->celos as $celos) {

                $id_fecha = DB::select('SELECT id FROM calendario WHERE fecha = ?', [$celos["fecha"]]);

                DB::insert(
                    'INSERT INTO celos_cerda 
                        (id_cerda, fecha, num_celo) 
                    VALUES (?, ?, ?)', [$celos["cerda"], $id_fecha[0]->id, $celos["num_celo"]]);
            }

            $cerda = DB::select(
                'SELECT MAX(cc.num_celo) as num_celo, MAX(cc.fecha) as fecha 
                FROM celos_cerda cc 
                INNER JOIN registro_cerda rc ON rc.id = cc.id_cerda 
                WHERE rc.cod_cerda = ?', 
                    [$request->celos[0]["cerda"]]);

            return response()->json($cerda[0], 200);
        }else{
            return response()->json("No sirve", 200);
        } */
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Celo  $celo
     * @return \Illuminate\Http\Response
     */
    public function show($codHembra)
    {
        $cerda = DB::select(
            'SELECT MAX(cc.num_celo) as num_celo, c.fecha as fecha 
                FROM celos_cerda cc 
                INNER JOIN registro_cerda rc ON rc.id = cc.id_cerda 
                INNER JOIN calendario c ON c.id = cc.fecha 
                WHERE rc.id = ?', 
                [$codHembra]);

        return response()->json($cerda[0], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Celo  $celo
     * @return \Illuminate\Http\Response
     */
    public function edit(Celo $celo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Celo  $celo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Celo $celo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Celo  $celo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Celo $celo)
    {
        //
    }
}
