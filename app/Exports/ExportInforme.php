<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportInforme implements FromView
{

    public function __construct($data, $name)
    {
        $this->data = $data;
        $this->nombre_informe = $name;
    }

    public function view(): View
    {
        switch ($this->nombre_informe) {
            case 'Medicamentos':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Dotacion':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Materia_Prima':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Producto_Terminado':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Desposte':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Mantenimiento':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Calidad':
                return view('admin.exports.informe_medicamentos', [
                    'registros' => $this->data
                ]);
                break;
            case 'Concentrados':
                return view('admin.exports.informe_concentrados', [
                    'registros' => $this->data
                ]);
                break;
            default:
                # code...
                break;
        }
    }
}