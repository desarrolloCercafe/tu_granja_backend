<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventosLote extends Model
{
    protected $table = 'eventos_lote';
    protected $fillable = [
        'id', 'id_lote', 'semana', 'dia', 'fecha', 'tipo_evento',
        'cantidad', 'unidad_medida', 'dieta', 'op', 'peso', 'causa',
        'dosis', 'tipo_dosis', 'medicamento', 'observaciones', 'created_at',
        'updated_at' 
    ];
}
