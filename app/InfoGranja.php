<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InfoGranja extends Model
{
    protected $table = 'info_granjas';
    protected $fillable = ['id', 'fecha', 'granja', 'asociado', 'ubicacion', 'altura_mar'];
}
