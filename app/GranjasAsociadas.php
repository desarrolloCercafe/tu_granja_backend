<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GranjasAsociadas extends Model
{
    protected $table = 'granjas_asociadas';
    protected $fillable = [
        'id', 'granja_id', 'user_id'
    ];
}
