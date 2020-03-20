<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AperturaLote extends Model
{
    protected $table = 'lote_cerdos';
    protected $fillable = [
        'id_lote', 'f_inicial', 'id_granja',
        'num_animales', 'consec_lote',
        'peso_ini', 'tipo_lactancia', 
        'created_at', 'updated_at'
    ];
}