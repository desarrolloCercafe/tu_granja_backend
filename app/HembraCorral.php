<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HembraCorral extends Model
{
    protected $table = 'corral_hembra';
    protected $fillable = [
        'id', 'id_corral', 'id_lote', 'sobrenombre'
    ];
}
