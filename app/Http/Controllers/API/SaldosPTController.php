<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\FechasSaldosPT;
use App\SaldosPT;
use App\InventarioPT;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Carbon;

class SaldosPTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productosSaldos = InventarioPT::All();
        return response($productosSaldos, 200);
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
        if($request->hasFile('my_file'))
        {
            $path = time().'.'. $request->file('my_file')->getClientOriginalExtension();
            $name = $request->file('my_file')->move('./../storage/app/', $path);
            $this->leer($name);
          } else {
              return response()->json("No se reconoce el archivo", 404);
          }

           $f_final = null;

                foreach ($this->excel as $row) {
                    for ($j=0; $j < Count($row); $j++) { 
                        if(isset($row[$j][1])){
                            $SC = new SaldosPT();
                            $SC['codigo'] = $row[$j][0];
                            $SC['descripcion'] = $row[$j][1];
                            $SC['cantidad'] = $row[$j][2];
                            $SC['unidad'] = $row[$j][3];
                            $SC['costo_unitario'] = $row[$j][4];
                            $SC['costo_total'] = $row[$j][5];
                            $fechaAlterada = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[$j][6]));
                            $SC['fecha'] = date($fechaAlterada);
                            $fecha = $SC['fecha'];
                            $f_final =  date("Y-m-d", strtotime($fecha));
                            $SC->save();
                        }
                    }
                 }

              $calendario = DB::select("SELECT * FROM calendario WHERE fecha LIKE '%$f_final%'");
                        $fechasCalendario = new FechasSaldosPT();
                        $fechasCalendario->fecha = $calendario[0]->fecha;
                        $fechasCalendario->id_calendario = $calendario[0]->id;
                        $fechasCalendario->year = $calendario[0]->year;
                        $fechasCalendario->mes = $calendario[0]->nombre_mes;
                        $fechasCalendario->dia = $calendario[0]->dia_mes;
                        $fechasCalendario->save();
                return response()->json("Se proceso correctamente", 202);
    }

    private function leer($name){
        $this->excel = Excel::toArray(new SaldosPT(), $name);
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
