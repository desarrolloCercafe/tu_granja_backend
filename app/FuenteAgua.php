<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuenteAgua extends Model
{
    protected $table = 'fuente_agua';
    protected $fillable = ['id', 'fuente'];
}
