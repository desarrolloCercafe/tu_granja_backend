<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concentrados extends Model
{
    protected $table = 'concentrados';
    protected $fillable = ['id', 'ref_concentrado', 'nombre_concentrado', 'tipo_concentrado', 'precio', 'kg', 'unidad_medida'];
}
