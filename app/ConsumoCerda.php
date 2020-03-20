<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConsumoCerda extends Model
{
    protected $table = 'consumo_cerda';
    protected $fillable = [
        'id', 'id_peso', 'id_dieta', 
        'f_inicio', 'f_final', 
        'consumo', 'created_at', 
        'updated_at'
    ];
}
