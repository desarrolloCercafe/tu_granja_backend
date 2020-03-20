<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productos_cia extends Model
{
    protected $table = 'productos_cia';
    protected $fillable = [
        'id', 'ref_producto_cia', 'nombre_producto_cia',
        'remember_token', 'created_at', 'updated_at'
    ];
}