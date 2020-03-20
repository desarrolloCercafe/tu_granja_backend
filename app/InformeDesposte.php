<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InformeDesposte extends Model
{
    
    protected $table = 'informe_desposte';
    protected $fillable = ['id', 'ref', 'nombre_producto', 'saldo_geminus', 'cantidad', 'conteo', 'diferencia','costo_unitario','costo_total','costo_diferencia', 'porc_merma_cant', 'porc_merma_valor','id_calendario', 'year', 'mes', 'fecha'];
}
