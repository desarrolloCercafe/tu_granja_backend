<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioMant extends Model
{
   protected $table = 'inventario_mt';
   protected $fillable = ['id', 'codigo', 'descripcion'];
}
