<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FechasSaldosDotacion;
use App\SaldosDotacion;
use App\ReferenciasDotacion;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class InventariosDotacionController extends Controller
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
        if($request->hasFile('myfile'))
        {
            $path = time().'.'. $request->file('myfile')->getClientOriginalExtension();
            $name = $request->file('myfile')->move('./../storage/app/', $path);
            $this->leer($name);
          } else {
              return response()->json("No se reconoce el archivo", 404);
          }
                $ProductosDotacion = ReferenciasDotacion::All();
                $f_final = null;

                for($i = 0; $i < count($ProductosDotacion); $i++ ) {
                    foreach ($this->excel as $row) {
                        for ($j=0; $j < Count($row); $j++) { 
                            if ($ProductosDotacion[$i]->codigo == $row[$j][0]) {
                                $SC = new SaldosDotacion();
                                $SC['codigo'] = $ProductosDotacion[$i]->codigo;
                                $SC['descripcion'] = $row[$j][1];
                                $SC['cantidad'] = $row[$j][2];
                                $SC['unidad'] = $row[$j][3];
                                $SC['costo_unitario'] = $row[$j][4];
                                $SC['total'] = $row[$j][5];
                                $fechaAlterada = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[$j][6]));
                                $SC['fecha'] = date($fechaAlterada);
                                //return response()->json($fechaAlterada, 200);
                                $fecha = $SC['fecha'];
                                $f_final =  date("Y-m-d", strtotime($fecha));
                                $SC->save();
                            }
                        }
                     }
                }

                   $calendario = DB::select("SELECT * FROM calendario WHERE fecha LIKE '%$f_final%'");
                        $fechasCalendario = new FechasSaldosDotacion;
                        $fechasCalendario->fecha = $calendario[0]->fecha;
                        $fechasCalendario->id_calendario = $calendario[0]->id;
                        $fechasCalendario->year = $calendario[0]->year;
                        $fechasCalendario->mes = $calendario[0]->nombre_mes;
                        $fechasCalendario->dia = $calendario[0]->dia_mes;
                        $fechasCalendario->save();
                return response()->json("Se proceso correctamente", 202);
    }

    private function leer($name)
    {
        $this->excel = Excel::toArray(new SaldosDotacion(), $name);
        return $this->excel;
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
