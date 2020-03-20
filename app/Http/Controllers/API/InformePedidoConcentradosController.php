<?php

namespace App\Http\Controllers\API;

use App\informe_pedido_concentrados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInforme;

class InformePedidoConcentradosController extends Controller
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

    public function downloadExcel($id){
        $excel = DB::table('consecutivos_concentrados')->where('id', $id)->get();
        /* return response()->json($excel, 200); */

        return Excel::download(
            new ExportInforme($excel, 'Concentrados'),
            'reporte.xlsx'
        );
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
     * @param  \App\informe_pedido_concentrados  $informe_pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function show(informe_pedido_concentrados $informe_pedido_concentrados)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\informe_pedido_concentrados  $informe_pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function edit(informe_pedido_concentrados $informe_pedido_concentrados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\informe_pedido_concentrados  $informe_pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, informe_pedido_concentrados $informe_pedido_concentrados)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\informe_pedido_concentrados  $informe_pedido_concentrados
     * @return \Illuminate\Http\Response
     */
    public function destroy(informe_pedido_concentrados $informe_pedido_concentrados)
    {
        //
    }
}
