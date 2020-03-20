<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosDotacion extends Model
{
    protected $table = 'saldos_dotacion';
    protected $fillable = ['id', 'codigo', 'descripcion', 'cantidad', 'unidad', 'costo_unitario', 'total', 'fecha'];
}
