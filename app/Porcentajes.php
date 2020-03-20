<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Porcentajes extends Model
{
    protected $table = 'porcentajes';
    protected $fillable = ['id', 'subproceso', 'porc_subproceso', 'porc_value_subproceso', 'etapa', 'created_at', 'updated_at'];
}
