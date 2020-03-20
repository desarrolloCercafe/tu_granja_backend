<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosCalidad extends Model
{
    protected $table = 'productos_calidad';
    protected $fillable = ['id', 'codigo_producto', 'descripcion'];
}
