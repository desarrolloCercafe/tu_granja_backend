<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bodegas_granjas extends Model
{
    protected $table = 'bodegas_granjas';
    protected $fillable = [
        'id', 'id_granja', 'nombre_bodega', 'dieta', 'unidad_medida',
        'capacidad', 'cantidad', 'created_at', 'updated_at'
    ];
}