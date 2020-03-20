<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use File;
use PDF;

class PdfInformeTecnicaController extends Controller
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
        $id_informe = $request[0]['id'];
        $registros =  DB::table('informe_visitas_tecnica')
        ->where('informe_visitas_tecnica.id', $id_informe)
        ->join('granjas', 'informe_visitas_tecnica.id_granja', '=', 'granjas.id')
        ->join('fuente_agua', 'informe_visitas_tecnica.id_fuente_agua', '=', 'fuente_agua.id')
        ->join('suministro_agua', 'informe_visitas_tecnica.id_suministro_agua', '=', 'suministro_agua.id')
        ->select('informe_visitas_tecnica.*', 'fuente_agua.fuente', 'suministro_agua.suminsitro', 'granjas.nombre_granja')
        ->get();
         $pdfInforme = PDF::loadView('admin.pdfInformeTecnica.informe', ['registros' => $registros]);
        define('BUDGETS_DIR', public_path('files/'));
        if (!is_dir(BUDGETS_DIR)){
            mkdir(BUDGETS_DIR, 0755, true);
        }
        $outputName = str_random(10);
        $pdfPath = BUDGETS_DIR.'/'.$outputName.'.pdf';
        File::put($pdfPath, PDF::loadView('admin.pdfInformeTecnica.informe', ['registros' => $registros])->output());
           $emails = [];
                for ($i = 0; $i < count($request[0]['emails']); $i++) {
                    array_push($emails, $request[0]['emails'][$i]['email']);
                }
        Mail::send('admin.messages.new_informe', ["registros" => $registros], function($message) use ($pdfPath, $emails) {
                    $message->to($emails)->subject("Pdf prueba");
                    $message->attach($pdfPath);
        });
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
