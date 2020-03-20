<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriasPrimas extends Model
{
    protected $table = 'materias_primas_calidad';
    protected $fillable = [
        'id', 'nombre',  
        'created_at', 'updated_at'
    ];
}
