<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPeso extends Model
{
    protected $table = 'registro_pesos';
    protected $fillable = [
        'id', 'id_cerda', 'apellido', 
        'lote', 'f_primer_servicio', 
        'num_celo', 'created_at', 
        'updated_at'
    ];
}
