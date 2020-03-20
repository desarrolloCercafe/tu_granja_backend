<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Concentrados;
use App\IvaConcentrado;
use App\Iva;
use Illuminate\Support\Facades\Mail;


class ConcentradosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $concentrados = Concentrados::All();
        return response($concentrados, 200);
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
        try {
            $concentrado = new Concentrados();
           $concentrado->ref_concentrado = $request->ref_concentrado;
           $concentrado->nombre_concentrado = $request->nombre_concentrado;
           $concentrado->tipo_concentrado = $request->tipo_concentrado;
           $concentrado->precio = $request->precio_concentrado;
           $concentrado->kg = $request->kg;
           $concentrado->unidad_medida = $request->medida;
           $concentrado->save();
           $concentrados = Concentrados::all();
           $ult_concentrado = $concentrados->last();
           $new_iva_valor_concentrado = new IvaConcentrado();
           $new_iva_valor_concentrado->concentrado_id = $ult_concentrado->id;
           $new_iva_valor_concentrado->iva_id = $request->iva_id;
           $new_iva_valor_concentrado->save();
           $nombre = $request->nombre_concentrado;
           $iva = $request->iva_id;
           $valores_iva = Iva::find($iva);
           $emails = 'desarrollotic@cercafe.com.co';
           Mail::send('admin.messages.new_concentrado',['nombre' => $nombre, 'iva' => $valores_iva], function($msj) use($nombre, $valores_iva, $emails)
               {
                   $msj->to($emails)->subject('"Nuevo Concentrado"' . " " . 'Nombre: '. $nombre . " " . "Iva: " . $valores_iva->valor_iva);
               });
           return response()->json("Se creo correctamente", 201);
           }catch(Exception $ex) {
                   return response()->json($ex->message, 500);
           }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
