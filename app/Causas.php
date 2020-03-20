<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Causas extends Model
{
    protected $table = 'tipo_descarte';
    protected $fillable = [
        'id', 'nombre', 'created_at',
        'updated_at' 
    ];
}
