<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class duracionPreceboCeba extends Model
{
    protected $table = 'duracionPreceboCeba';
    protected $fillable = [
        'id', 'id_granja', 'etapas', 'precebo_origen',
        'precebo_destino', 'cria_origen', 'tiempo_destete',
        'dias_precebo', 'dias_ceba', 'dias_wtf', 'created_at',
        'updated_at'
    ];
}