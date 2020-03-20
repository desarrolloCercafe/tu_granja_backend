<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class medicamentos extends Model
{
    protected $table = 'medicamentos';
    protected $fillable = [
        'id', 'ref_medicamento', 'nombre_medicamento', 'tipo_medicamento', 'disable',
        'proveedor_1', 'proveedor_2', 'proveedor_3', 'proveedor_4', 'precio_medicamento',
        'remember_token', 'created_at', 'updated_at'
    ];
}