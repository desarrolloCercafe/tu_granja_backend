<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class consecutivos_productos_cia extends Model
{
    protected $table = 'consecutivos_productos_cia';
    protected $fillable = [
        'id', 'consecutivo', 'fecha_creacion', 'granja_id', 'estado_id',
        'fecha_estimada', 'fecha_entrega', 'created_at', 'updated_at'
    ];
}