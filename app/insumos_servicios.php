<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class insumos_servicios extends Model
{
    protected $table = 'insumos_servicios';
    protected $fillable = [
        'id', 'ref_insumo', 'nombre_insumo', 'tipo_insumo', 'disable',
        'proveedor_1', 'proveedor_2', 'proveedor_3', 'precio_insumo',
        'remember_token', 'created_at', 'updated_at'
    ];
}