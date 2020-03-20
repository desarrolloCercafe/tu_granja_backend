<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tolvas_planta extends Model
{
    protected $table = 'tolvas_planta';
    protected $fillable = [
        'id', 'nombre', 'capacidad', 'dieta_actual',
        'cantidad', 'created_at', 'updated_at'
    ];
}