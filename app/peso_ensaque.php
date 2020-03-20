<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class peso_ensaque extends Model
{
    protected $table = 'peso_ensaque';
    protected $fillable = [
        'id', 'FechaPesoEnsaque', 'OP', 'TemperaturaPromedio', 'Densidad',
        'PesoE1', 'PesoA1', 'PesoE2', 'PesoA2', 'PesoE3', 'PesoA3',
        'PesoE4', 'PesoA4', 'PesoE5', 'PesoA5', 'PesoE6', 'PesoA6',
        'PesoE7', 'PesoA7', 'PesoE8', 'PesoA8', 'PesoE9', 'PesoA9',
        'PesoE10', 'PesoA10', 'created_at', 'updated_at'
    ];
}