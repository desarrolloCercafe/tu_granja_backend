<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosMT extends Model
{
    protected $table = 'saldos_mt';
    protected $fillable = ['id', 'codigo', 'descripcion' , 'cantidad', 'unidad', 'costo_unitario', 'costo_total', 'fecha', 'mv_mensual'];
}
