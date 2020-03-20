<?php

namespace App\Http\Controllers\API;

use App\RegistroPeso;
use App\PesoCerda;
use App\ConsumoCerda;
use App\Hembras;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Exception;
use Illuminate\Support\Carbon;

class RegistroPesoController extends Controller
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

        $cerda = Hembras::where('cod_cerda', strtoupper($request->header["cod_hembra"]))->get();

        $registro = new RegistroPeso();
        $registro->id_cerda = $cerda[0]->id;
        $registro->apellido =  $request->header["sobrenombre"];
        $registro->lote = $request->header["lote"];

        if ($request->header["f_servicio"] != "") {
            //$id_fservicio = DB::select('SELECT id FROM calendario WHERE fecha = ?', [$request->header["f_servicio"]]);
            $registro->f_primer_servicio = $request->header["f_servicio"];
        } else {
            $registro->f_primer_servicio = "NULL";
        }

        $registro->save();

        $tabla_registro = DB::table('registro_pesos')
            ->select('id')
            ->where('id_cerda', $cerda[0]->id)
            ->get();

        $pesos = new PesoCerda();
        $consumo = new ConsumoCerda();

        foreach ($request->body as $peso_Frontend) {

            $f_nacimiento = Carbon::parse($cerda[0]["fecha_nacimiento"]);
            $f_pesaje = Carbon::parse($peso_Frontend["fecha"]);
            $diferencia_dias = $f_nacimiento->diffInDays($f_pesaje);
            $edad = $diferencia_dias;

            $id_fecha = DB::select('SELECT id FROM calendario WHERE fecha = ?', [$f_pesaje]);

            DB::insert(
                'INSERT INTO peso_cerda (id_registro, id_granja, f_pesaje, peso, edad) 
                                VALUES (?, ?, ?, ?, ?)',
                [
                    $tabla_registro[0]->id, $peso_Frontend["granja"],
                    $id_fecha[0]->id, $peso_Frontend["peso"], $edad
                ]
            );

            $peso_registrado = DB::select(
                'SELECT id 
                    FROM peso_cerda 
                    WHERE id_registro = ? AND f_pesaje = ? AND id_granja = ? AND peso = ?',
                [
                    $tabla_registro[0]->id, $id_fecha[0]->id, 
                    $peso_Frontend["granja"], $peso_Frontend["peso"]
                ]
            );

            //return response()->json($peso_registrado, 200);

            if (isset($request->footer)) {
                foreach ($request->footer as $consumos_Frontend) {
                    //return response()->json($consumos_Frontend, 200);
                    if ($consumos_Frontend["peso_asociado"] == $peso_Frontend["consecutivo"]) {

                        $id_finicial = DB::select('SELECT id FROM calendario WHERE fecha = ?', 
                            [$consumos_Frontend["consumo"]["f_inicial"]]
                        );

                        $id_ffinal = DB::select('SELECT id FROM calendario WHERE fecha = ?', 
                        [$consumos_Frontend["consumo"]["f_final"]]
                        );

                        DB::insert(
                            'INSERT INTO consumo_cerda 
                                            (id_peso, id_dieta, f_inicio, f_final, consumo) 
                                        VALUES (?, ?, ?, ?, ?)',
                            [
                                $peso_registrado[0]->id, $consumos_Frontend["consumo"]["dieta"],
                                $id_finicial[0]->id, $id_ffinal[0]->id,
                                $consumos_Frontend["consumo"]["consumo"]
                            ]
                        );
                    }
                }
            }
        }

        return response()->json("Ok", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegistroPeso  $registroPeso
     * @return \Illuminate\Http\Response
     */
    public function show(RegistroPeso $registroPeso)
    {
        //
    }

    public function searchApellido($idCerda){
        $response = DB::select(
            'SELECT apellido, lote FROM registro_pesos WHERE id_cerda = ?', 
            [$idCerda]
        );

        if(Count($response)){
            $data = ["apellido" => $response[0]->apellido, "lote" => $response[0]->lote, "status" => "Existe"];
            return response()->json($data, 200);
        }else{
            $data = ["content" => "", "status" => "No_existe"];
            return response()->json($data, 200);
        }
    }

    public function VerificarApellido($sobrenombre, $cod_Hembra){

        $cerda = Hembras::where('cod_cerda', strtoupper($cod_Hembra))->get();

        $query = DB::select(
            'SELECT id FROM registro_pesos WHERE apellido = ? AND id_cerda != ?', 
            [$sobrenombre, $cerda[0]->id]
        );

        if(Count($query)){
            return response()->json("Existe", 200);
        }else{
            return response()->json("No_existe", 200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegistroPeso  $registroPeso
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistroPeso $registroPeso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegistroPeso  $registroPeso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistroPeso $registroPeso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegistroPeso  $registroPeso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cerda = Hembras::find($request->id);
        $cerda->estado = 1;
        $cerda->save();

        return response()->json("OK", 200);
    }
}
