<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class consecutivos_medicamentos extends Model
{
    protected $table = 'consecutivos_medicamentos';
    protected $fillable = [
        'id', 'consecutivo', 'fecha_creacion', 'granja_id', 'estado_id',
        'origen', 'tipo_pedido', 'created_at', 'updated_at'
    ];
}