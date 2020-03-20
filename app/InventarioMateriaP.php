<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioMateriaP extends Model
{
    protected $table = 'inventario_materia_prima';
    protected $fillable = ['id', 'codigo', 'descripcion'];
}
