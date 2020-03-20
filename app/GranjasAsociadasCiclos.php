<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GranjasAsociadasCiclos extends Model
{
    protected $table = 'granjas_asociada_ciclos';
    protected $fillable = ['id', 'granja', 'tipo_ciclo'];
}
