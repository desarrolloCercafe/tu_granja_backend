<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Celo extends Model
{
    protected $table = 'celos_cerda';
    protected $fillable = [
        'id', 'id_cerda', 'num_celo', 'fecha', 'created_at', 'updated_at'
    ];
}