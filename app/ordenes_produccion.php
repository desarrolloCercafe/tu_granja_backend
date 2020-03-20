<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ordenes_produccion extends Model
{
    protected $table = 'ordenes_produccion';
    protected $fillable = [
        'id', 'consecutivo', 'id_dieta', 'consecutivo_dieta',
        'cantidad_baches', 'cantidad_disponible', 'estado',
        'created_at', 'updated_at'
    ];
}