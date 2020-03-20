<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\InventarioMedicamento;
use App\Http\Requests;
use  App\FechasCalendario;
use DB;
use Excel;
use Maatwebsite\Excel\HeadingRowImport;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Calendario;
use Exception;
use Maatwebsite\Excel\Facades\Excel as MaatwebsiteExcel;

class InventariosController extends Controller
{

    public $excel;

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
        /*$File = $request -> file('myfile'); //line 1
        $sub_path = 'files'; //line 2
        $real_name = $File -> getClientOriginalName(); //line 3
      
        $destination_path = public_path($sub_path);  //line 4
          
        $File->move($destination_path,  $real_name);  //line 5
        return response()->json('File Save');*/

        if ($request->hasFile('myfile')) {

            $path = time() . '.' . $request->file('myfile')->getClientOriginalExtension();
            $name = $request->file('myfile')->move('./../storage/app/', $path);
            $this->leer($name);

        } else {
            return response()->json("No se reconoce el archivo", 404);
        }

        $f_final = null;
        for ($i=1; $i < Count($this->excel[0]) ; $i++) {

            $firstCell = $this->excel[0];

            if($firstCell[$i][0] != null){
                $IM = new InventarioMedicamento();
                $IM['codigo'] = $firstCell[$i][0];
                $IM['descripcion'] = $firstCell[$i][1];
                $IM['cantidad'] = $firstCell[$i][2];
                $IM['unidad'] = $firstCell[$i][3];
                $IM['costo_unitario'] = $firstCell[$i][4];
                $IM['costo_total'] = $firstCell[$i][5];
                $IM['fecha'] = Date::excelToDateTimeObject($firstCell[$i][6]);
                $fecha = $IM['fecha'];
                $f_final = date_format($fecha, 'Y-m-d');
                $IM->save();
            } 
        }

        $calendario = DB::select("SELECT * FROM calendario WHERE fecha LIKE '%$f_final%'");
        $fechasCalendario = new FechasCalendario;
        $fechasCalendario->fecha = $calendario[0]->fecha;
        $fechasCalendario->id_calendario = $calendario[0]->id;
        $fechasCalendario->year = $calendario[0]->year;
        $fechasCalendario->mes = $calendario[0]->mes_year;
        $fechasCalendario->dia = $calendario[0]->dia_mes;
        $fechasCalendario->save();

        return response()->json("Se proceso correctamente", 202);
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

    private function leer($name)
    {
        //Excel::import($name, );
        
        /*Excel::load($name, function ($reader)
        {
            $this->excel = $reader->get();
            return $this->excel;

        });*/

        $this->excel = Excel::toArray(new InventarioMedicamento, $name);
        return $this->excel;
    }

    public function descargarFormato($file)
    {
    	return response()->download('../public/files/'.$file.'.xlsx');
    }

}
