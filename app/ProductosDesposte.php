<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosDesposte extends Model
{
    protected $table = 'referencias_desposte';
    protected $fillable = ['id', 'producto', 'descripcion', 'created_at'];
}
