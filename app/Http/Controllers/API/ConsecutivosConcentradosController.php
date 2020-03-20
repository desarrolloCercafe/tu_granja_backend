<?php

namespace App\Http\Controllers\API;

use App\consecutivos_concentrados;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\pedido_concentrados;
use Mail;
use Carbon\Carbon;

class ConsecutivosConcentradosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $pedido = consecutivos_concentrados::select('consecutivos_concentrados.id', 'consecutivos_concentrados.consecutivo',
        'consecutivos_concentrados.fecha_creacion', 'consecutivos_concentrados.fecha_estimada',
        'consecutivos_concentrados.granja_id', 'granjas.nombre_granja', 'consecutivos_concentrados.user_id',
        'consecutivos_concentrados.estado_id', 'estados.nombre_estado', 'consecutivos_concentrados.fecha_entrega',
        'consecutivos_concentrados.hora_entrega', 'consecutivos_concentrados.conductor_asignado',
        'consecutivos_concentrados.vehiculo_asignado')
        ->join('granjas', 'consecutivos_concentrados.granja_id', '=', 'granjas.id')
        ->join('estados', 'consecutivos_concentrados.estado_id', '=', 'estados.id')
        ->orderBy('consecutivos_concentrados.consecutivo', 'DESC')
        ->get(); */

        $pedido = DB::select('SELECT TIMESTAMPDIFF(DAY, c.fecha_creacion, c.fecha_estimada) AS dif_dias,
        c.id, c.consecutivo, c.fecha_creacion, c.fecha_estimada, c.granja_id, granjas.nombre_granja, c.user_id,
        c.estado_id, estados.nombre_estado, c.fecha_entrega, c.hora_entrega, c.conductor_asignado, c.vehiculo_asignado
        FROM consecutivos_concentrados c JOIN granjas, estados 
        WHERE (c.granja_id = granjas.id) AND (c.estado_id = estados.id)
        ORDER BY c.consecutivo DESC',[]);

        return response()->json($pedido, 200);
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
        $consecutivo = consecutivos_concentrados::max('consecutivo');

        $Pedido = new consecutivos_concentrados();
        $Pedido->consecutivo = $consecutivo + 1;
        $Pedido->fecha_creacion = $request->fecha_creacion;
        $Pedido->fecha_estimada = $request->fecha_estimada;
        $Pedido->granja_id = $request->granja_id;
        $Pedido->user_id = $request->user_id;
        $Pedido->estado_id = 1;
        $Pedido->conductor_asignado = 'Por verificar';
        $Pedido->vehiculo_asignado = 'Por verificar';
        $Pedido->save();

        $Concentrado = array();
        foreach ($request->pedidos as $Pedido){
            if ($Pedido['tipo'] == 'Bul'){
                $Bultos = $Pedido['cantidad'];
                $Kilos = $Pedido['cantidad'] * 40;
            } else {
                $Bultos = 0;
                $Kilos = $Pedido['cantidad'];
            }
            $Pedido = array(
                'consecutivo_pedido' => ($consecutivo + 1),
                'fecha_creacion' => $request->fecha_creacion,
                'tipo_documento' => 'PCT',
                'prefijo' => 'WEB',
                'granja_id' => $request->granja_id,
                'concentrado_id' => $Pedido['id'],
                'estado_id' => 1,
                'no_bultos' => $Bultos,
                'no_kilos' => $Kilos,
                'fecha_estimada' => $request->fecha_estimada
            );
            pedido_concentrados::insert($Pedido);
            $Nombre = DB::select('SELECT nombre_concentrado FROM concentrados WHERE id = ?', [$Pedido['concentrado_id']]);
            $Pedido['concentrado_id'] = $Nombre[0]->nombre_concentrado;
            $Granja = DB::select('SELECT nombre_granja FROM granjas WHERE id = ?', [$Pedido['granja_id']]);
            $Pedido['granja_id'] = $Granja[0]->nombre_granja;
            array_push($Concentrado, $Pedido);
        }
        /* return response()->json($Concentrado, 200); */
        
        /* -/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/ */

        /* $email = "intranet2.0@cercafe.com.co"; */
        $consec = $consecutivo + 1;

        $fechaCre = Carbon::parse($request->input('fecha_creacion'));
        $fechaEst = Carbon::parse($request->input('fecha_estimada'));
        $diasDiferencia = $fechaEst->diffInDays($fechaCre);

        if ($diasDiferencia < 7){
            Mail::send('admin.messages.notificacion_pedido_concentrado_adicional', ['cons' => $consec, 'concentrados' => $Concentrado],
            function($msj) use($consec, $Concentrado){
                $email = "intranet2.0@cercafe.com.co";
                $emails = ['jsj.creativo@gmail.com'];
                $msj->to($emails)->from($email, 'Cercafe')
                ->subject('Pedido Adicional de Concentrados: ' . $Concentrado[0]['granja_id'] . ' | ' . 'Consecutivo: ' . 'PCO'.$consec);
            });
        }

        Mail::send('admin.messages.notificacion_pedido_concentrado', ['cons' => $consec, 'concentrados' => $Concentrado],
        function($msj) use($consec, $Concentrado){
            /* $emails = ['jsj.creativo@gmail.com', $email]; */
            $email = "intranet2.0@cercafe.com.co";
            $emails = ['jsj.creativo@gmail.com'];
            $msj->to($emails)->from($email, 'Cercafe')
            ->subject('Pedido de Concentrados: ' . $Concentrado[0]['granja_id'] . ' | ' . 'Consecutivo: ' . 'PCO'.$consec);
        });
        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\consecutivos_concentrados  $consecutivos_concentrados
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\consecutivos_concentrados  $consecutivos_concentrados
     * @return \Illuminate\Http\Response
     */
    public function edit(consecutivos_concentrados $consecutivos_concentrados)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\consecutivos_concentrados  $consecutivos_concentrados
     * @return \Illuminate\Http\Response
     */
    /* public function update(Request $request, $id) */
    public function update(Request $request, $id)
    {
        if ($request['conductor'] == ''){
            $request['conductor'] = 'Por verificar';
        }
        if ($request['vehiculo'] == ''){
            $request['vehiculo'] = 'Por verificar';
        }
        $pedido = DB::table('consecutivos_concentrados')
        ->where('id', $id)
        ->update([
            'fecha_entrega' => $request["fecha_entrega"],
            'conductor_asignado' => $request["conductor"],
            'vehiculo_asignado' => $request["vehiculo"],
            'estado_id' => 2,
            ]);
        return response()->json("OK", 200);
    }
    /* 'concentrado_id' => $Pedido['id'], */

    /* 'fecha_entrega' => $request->fecha_entrega,
    'conductor_asignado' => $request->conductor,
    'vehiculo_asignado' => $request->vehiculo, */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\consecutivos_concentrados  $consecutivos_concentrados
     * @return \Illuminate\Http\Response
     */
    public function destroy(consecutivos_concentrados $consecutivos_concentrados)
    {
        //
    }
}
