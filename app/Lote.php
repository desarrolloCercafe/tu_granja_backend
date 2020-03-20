<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lote';
    protected $fillable = [
        'id', 'cod_lote', 'f_apertura', 'id_granja'
    ];
}
