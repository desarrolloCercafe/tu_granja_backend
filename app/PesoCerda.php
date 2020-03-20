<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesoCerda extends Model
{
    protected $table = 'peso_cerda';
    protected $fillable = [
        'id', 'id_granja', 
        'f_pesaje', 'peso', 
        'edad', 'created_at', 
        'updated_at'
    ];
}
