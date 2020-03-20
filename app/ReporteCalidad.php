<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteCalidad extends Model
{
    protected $table = 'reporte_calidad';
    protected $fillable = [
        'id', 'fecha', 'op', 'turno', 
        'num_bache', 'hora', 'minutos', 
        'granulometria', 'retencion', 'desv_estandar',
        'hum_terminado', 'finos', 'durabilidad',
        'temp_enfriadora', 'temp_ambiente', 'dureza',
        'hum_premezcla', 'hum_acondicionado', 'carga',
        'temperatura', 'amperaje1', 'amperaje2', 
        'vapor_linea', 'vapor_reducido', 'apertura_valvula',
        'analista', 'observacion', 'created_at',
        'updated_at'
    ];
}
