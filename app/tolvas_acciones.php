<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tolvas_acciones extends Model
{
    protected $table = 'tolvas_acciones';
    protected $fillable = [
        'id', 'fecha', 'tolva', 'tipo', 'dieta', 'cantidad',
        'granja', 'created_at', 'updated_at'
    ];
}

/* protected $fillable = [
    'id', 'tolva', 'dieta', 'cantidad', 'created_at', 'updated_at'
]; */