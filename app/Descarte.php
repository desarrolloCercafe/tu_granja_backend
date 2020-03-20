<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descarte extends Model
{
    protected $table = 'tipo_descarte';
    protected $fillable = [
        'id', 'nombre', 'updated_at', 'created_at'
    ];
}
