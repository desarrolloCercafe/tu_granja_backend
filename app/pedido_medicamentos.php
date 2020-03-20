<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pedido_medicamentos extends Model
{
    protected $table = 'pedido_medicamentos';
    protected $fillable = [
        'id', 'consecutivo_pedido', 'fecha_pedido', 'granja_id', 'medicamento_id',
        'estado_id', 'unidades', 'created_at', 'updated_at'
    ];
}