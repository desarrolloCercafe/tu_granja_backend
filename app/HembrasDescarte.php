<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HembrasDescarte extends Model
{
    protected $table = 'cerda_descartada';
    protected $fillable = [
        'id', 'id_hembra', 'id_descarte', 'f_descarte',
        'observacion', 'created_at', 'updated_at'
    ];
}
