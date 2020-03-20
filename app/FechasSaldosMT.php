<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasSaldosMT extends Model
{
    protected $table = 'fechas_saldos_mt';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
