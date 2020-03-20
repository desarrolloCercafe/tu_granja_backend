<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeMT extends Model
{
    protected $table = 'informe_mt';
    protected $fillable = ['id', 'ref', 'nombre_producto', 'saldo_geminus', 'cantidad', 'conteo', 'diferencia','costo_unitario','costo_total','costo_diferencia', 'mv_mensual', 'porcentaje_mv_diferencia','id_calendario', 'year', 'mes', 'fecha'];
}
