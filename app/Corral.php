<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Corral extends Model
{
    protected $table = 'corral';
    protected $fillable = [
        'id', 'cod_corral', 'id_granja',
        'tipo_comedero', 'area_corral'
    ];
}
