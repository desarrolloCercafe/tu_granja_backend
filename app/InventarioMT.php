<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioMT extends Model
{
    protected $table = 'inventario_mt';
    protected $fillable = ['id', 'codigo', 'descripcion'];
}
