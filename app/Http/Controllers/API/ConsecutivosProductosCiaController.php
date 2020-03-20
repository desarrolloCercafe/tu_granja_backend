<?php

namespace App\Http\Controllers\API;

use App\consecutivos_productos_cia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use App\pedido_cia;

class ConsecutivosProductosCiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidos = consecutivos_productos_cia::select('consecutivos_productos_cia.*', 'granjas.nombre_granja',
        'estados.nombre_estado')
        ->join('granjas', 'granjas.id', '=', 'consecutivos_productos_cia.granja_id')
        ->join('estados', 'estado_id', '=', 'estados.id')
        ->orderBy('consecutivos_productos_cia.consecutivo', 'desc')
        ->get();

        return response()->json($pedidos, 200);
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
        $consecutivo = consecutivos_productos_cia::max('consecutivo');

        $pedido = new consecutivos_productos_cia();
        $pedido->consecutivo = $consecutivo + 1;
        $pedido->fecha_creacion = $request->fecha_creacion;
        $pedido->granja_id = $request->granja;
        $pedido->estado_id = 1;
        $pedido->fecha_estimada = $request->fecha_estimada;
        $pedido->save();

        $Semen = array();
        foreach ($request->pedidos as $pedido) {
            $pedido = array(
                'consecutivo_pedido' => ($consecutivo + 1),
                'fecha_pedido' => $request->fecha_creacion,
                'granja_id' => $request->granja,
                'producto_cia_id' => $pedido['id'],
                'estado_id' => 1,
                'dosis' => $pedido['cantidad'],
                'fecha_estimada' => $request->fecha_estimada
            );
            pedido_cia::insert($pedido);
            $Nombre = DB::select('SELECT nombre_producto_cia FROM productos_cia WHERE id = ?', [$pedido['producto_cia_id']]);
            $pedido['estado_id'] = $Nombre[0]->nombre_producto_cia;
            $Granja = DB::select('SELECT nombre_granja FROM granjas WHERE id = ?', [$pedido['granja_id']]);
            $pedido['granja_id'] = $Granja[0]->nombre_granja;
            $Codigo = DB::select('SELECT ref_producto_cia FROM productos_cia WHERE id = ?', [$pedido['producto_cia_id']]);
            $pedido['producto_cia_id'] = $Codigo[0]->ref_producto_cia;
            array_push($Semen, $pedido);
        }

        /*-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/-/*/

        $consec = $consecutivo + 1;

        Mail::send('admin.messages.notificacion_pedido_medicamentos', ['cons' => $consec, 'semen' => $Semen],
        function($msj) use($consec, $Semen){
            $email = "intranet2.0@cercafe.com.co";
            $emails = ['jsj.creativo@gmail.com'];
            /* $emails = ['jsj.creativo@gmail.com', $email]; */
            $msj->to($emails)->from($email, 'Cercafe')
            ->subject('Pedido de Semen: ' . $Semen[0]['granja_id'] . ' | ' . 'Consecutivo: ' . 'PSE'.$consec);
        });

        return response()->json("OK", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\consecutivos_productos_cia  $consecutivos_productos_cia
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\consecutivos_productos_cia  $consecutivos_productos_cia
     * @return \Illuminate\Http\Response
     */
    public function edit(consecutivos_productos_cia $consecutivos_productos_cia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\consecutivos_productos_cia  $consecutivos_productos_cia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pedido = DB::table('consecutivos_productos_cia')
        ->where('id', $id)
        ->update([
            'fecha_entrega' => $request->fecha_entrega,
            'estado_id' => 2,
            ]);

        return response()->json("OK", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\consecutivos_productos_cia  $consecutivos_productos_cia
     * @return \Illuminate\Http\Response
     */
    public function destroy(consecutivos_productos_cia $consecutivos_productos_cia)
    {
        //
    }
}