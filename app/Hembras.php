<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hembras extends Model
{
    protected $table = 'registro_cerda';
    protected $fillable = [
        'id', 'cod_cerda', 'genetica', 'cod_madre', 
        'cod_padre', 'fecha_nacimiento',
        'peso_nacimiento', 'tipo_pesaje',
        'f_envio',
        'peso_28', 'granja_inicial', 
        'num_pezones_funcionales', 
        'fecha_registro', 'f_servicio', 'estado'
    ];
}
