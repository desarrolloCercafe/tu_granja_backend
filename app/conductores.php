<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conductores extends Model
{
    protected $table = 'conductores';
    protected $fillable = [
        'id', 'nombre', 'telefono',
        'created_at', 'updated_at'
    ];
}