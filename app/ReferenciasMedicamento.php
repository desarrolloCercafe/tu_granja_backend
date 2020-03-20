<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciasMedicamento extends Model
{
    protected $fillable = ['id', 'ref_medicamento', 'nombre_medicamento', 'tipo_medicamento', 'precio_medicamento'];
}
