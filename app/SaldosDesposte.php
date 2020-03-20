<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosDesposte extends Model
{
    protected $table = 'saldos_desposte';
    protected $fillable = ['id', 'codigo', 'descripcion', 'cantidad', 'unidad', 'costo_unitario', 'costo_total', 'fecha', 'ventas_kg', 'ventas_valor', 'created_at'];
}
