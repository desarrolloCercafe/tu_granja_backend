<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ensaque extends Model
{
    protected $table = 'ensaque';
    protected $fillable = [
        'id', 'FechaEnsaque', 'OP', 'BultosMeta', 'BultosReales',
        'Dieta', 'CantidadBaches', 'created_at', 'updated_at'
    ];
}