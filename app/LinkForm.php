<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LinkForm extends Model
{
    protected $fillable = [
        'id', 'area_id', 'macro_id', 'enlace', 
        'nombre_documento', 'created_at', 'updated_at'
    ];
}
