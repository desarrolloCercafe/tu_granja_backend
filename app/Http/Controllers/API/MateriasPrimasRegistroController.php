<?php

namespace App\Http\Controllers\API;

use App\MateriasPrimasRegistro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MateriasPrimasRegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        $dataRegistro = array(
            'materia_prima' => $request->matPrima, 'lote_interno' => $request->l_interno,
            'fecha' => $request->fecha, 'proveedor' => $request->proveedor,
            'lote_proveedor' => $request->l_proveedor, 'placa' => $request->placa,
            'transportadora' => $request->transportadora, 'humedad' => $request->humedad,
            'responsable' => $request->responsable, 'observaciones' => $request->observaciones,
            'densidad' => $request->densidad,'soya_test' => $request->soyaTest,
            'piscina' => $request->piscina, 'efervescencia' => $request->efervescencia,
            'infestacion' => $request->infestacion, 'temp_bultos' => $request->tempBultos,
            'temp_ambiente' => $request->tempAmbiente, 'f_vencimiento' => $request->fVencimiento,
            'granulometria' => $request->granulometria, 'retencion' => $request->retencion,
            'cloruro' => $request->cloruro, 'acidez' => $request->acidez,
            'peroxidos' => $request->peroxidos, 'tanque_almacenamiento' => $request->tanqueAlmacenamiento,
            'adinox' => $request->adinox, 'temperatura' => $request->temperatura,
            'polvo' => $request->polvo, 'partido' => $request->partido,
            'danados' => $request->danado, 'impurezas' => $request->impurezas,
            'silo' => $request->silo, 'densidad_aparente' => $request->densidadAparente,
            'densidad_real' => $request->densidadReal, 'cantidad' => $request->cantidad,
        );
        MateriasPrimasRegistro::insert($dataRegistro);
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MateriasPrimasRegistro  $materiasPrimasRegistro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $materia = MateriasPrimasRegistro::find($id);
        return response()->json($materia, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MateriasPrimasRegistro  $materiasPrimasRegistro
     * @return \Illuminate\Http\Response
     */
    public function edit(MateriasPrimasRegistro $materiasPrimasRegistro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MateriasPrimasRegistro  $materiasPrimasRegistro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $materia = MateriasPrimasRegistro::find($id);
        $materia->materia_prima = $request->matPrima;
        $materia->lote_interno = $request->l_interno;
        $materia->fecha = $request->fecha;
        $materia->proveedor = $request->proveedor;
        $materia->lote_proveedor = $request->l_proveedor;
        $materia->placa = $request->placa;
        $materia->transportadora = $request->transportadora;
        $materia->humedad = $request->humedad;
        $materia->responsable = $request->responsable;
        $materia->observaciones = $request->observaciones;
        $materia->densidad = $request->densidad;
        $materia->soya_test = $request->soyaTest;
        $materia->piscina = $request->piscina;
        $materia->efervescencia = $request->efervescencia;
        $materia->infestacion = $request->infestacion;
        $materia->temp_bultos = $request->tempBultos;
        $materia->temp_ambiente = $request->tempAmbiente;
        $materia->f_vencimiento = $request->fVencimiento;
        $materia->granulometria = $request->granulometria;
        $materia->retencion = $request->retencion;
        $materia->cloruro = $request->cloruro;
        $materia->acidez = $request->acidez;
        $materia->peroxidos = $request->peroxidos;
        $materia->tanque_almacenamiento = $request->tanqueAlmacenamiento;
        $materia->adinox = $request->adinox;
        $materia->temperatura = $request->temperatura;
        $materia->polvo = $request->polvo;
        $materia->partido = $request->partido;
        $materia->danados = $request->danado; 
        $materia->impurezas = $request->impurezas;
        $materia->silo = $request->silo;
        $materia->densidad_aparente = $request->densidadAparente;
        $materia->densidad_real = $request->densidadReal; 
        $materia->cantidad = $request->cantidad;
        $materia->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MateriasPrimasRegistro  $materiasPrimasRegistro
     * @return \Illuminate\Http\Response
     */
    public function destroy(MateriasPrimasRegistro $materiasPrimasRegistro)
    {
        //
    }
}
