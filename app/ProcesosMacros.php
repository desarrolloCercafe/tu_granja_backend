<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcesosMacros extends Model
{
    protected $table = 'procesos_macros';
    protected $fillable = ['id', 'proceso', 'porcentaje_macro', 'porcentaje_valor_macro'];
}
