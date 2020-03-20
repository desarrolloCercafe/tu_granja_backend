<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ensaques_planta extends Model
{
    protected $table = 'ensaques_planta';
    protected $fillable = [
        'id', 'fecha', 'id_op', 'bultos_meta', 'bultos_reales', 'dieta',
        'cantidad_baches', 'observaciones', 'created_at', 'updated_at'
    ];
}