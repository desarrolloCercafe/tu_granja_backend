<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pedido_cia extends Model
{
    protected $table = 'pedido_cia';
    protected $fillable = [
        'id', 'consecutivo_pedido', 'fecha_pedido', 'granja_id', 'producto_cia_id', 'estado_id',
        'dosis', 'fecha_estimada', 'fecha_entrega', 'created_at', 'updated_at'
    ];
}