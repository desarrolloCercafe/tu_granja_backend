<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioMedicamento extends Model
{
    protected $fillable = ['id', 'medicamento_id', 'cantidad', 'unidad', 'costo_unitario', 'costo_total', 'fecha'];
}
