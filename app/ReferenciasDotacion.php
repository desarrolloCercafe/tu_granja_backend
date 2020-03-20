<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenciasDotacion extends Model
{
    protected $table = 'referencias_dotacion';
    protected $fillable = ['id', 'codigo', 'descripcion'];
}
