<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalificacionGranja extends Model
{
    protected $table = 'calificacion_granjas';
    protected $fillable = [
        'id', 'subproceso','suma_indicador_subproceso', 
        'calificacion_subproceso', 'porc_proceso_macro', 
        'calificacion_proceso_macro', 'promedio_proceso_macro', 
        'id_info_granja', 'id_proceso_macro'
    ];
}
