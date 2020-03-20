<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despachos extends Model
{
    protected $table = 'despachos';
    protected $fillable = [
        'idDespacho', 'FechaDespacho', 'OP', 'Dieta', 'Cantidad',
        'GranjaDestino', 'created_at', 'updated_at'
    ];
}