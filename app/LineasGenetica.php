<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineasGenetica extends Model
{
    protected $table = 'genetica_cerdas';
    protected $fillable = [
        'id', 'nombre', 'created_at', 'updated_at'
    ];
}