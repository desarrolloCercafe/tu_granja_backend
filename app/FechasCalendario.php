<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasCalendario extends Model
{
    protected $table = 'fechas_inventarios';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
