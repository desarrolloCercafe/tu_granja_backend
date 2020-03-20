<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BodegaDietas extends Model
{
    protected $table = 'bodega_dietas';
    protected $fillable = [
        'id', 'FechaBodega', 'Dieta', 'Cantidad',
        'created_at', 'updated_at'
    ];
}