<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FechasSaldosDesposte extends Model
{
    protected $table = 'fechas_saldos_desposte';
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
