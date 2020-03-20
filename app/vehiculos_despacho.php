<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vehiculos_despacho extends Model
{
    protected $table = 'vehiculos_despacho';
    protected $fillable = [
        'id', 'placa', 'capacidad',
        'created_at', 'updated_at'
    ];
}