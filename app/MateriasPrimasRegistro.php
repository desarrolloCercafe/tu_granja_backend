<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MateriasPrimasRegistro extends Model
{
    protected $table = 'materias_primas_registro_calidad';
    protected $fillable = [
        'id', 'materia_prima', 'lote_interno',
        'fecha', 'proveedor', 'lote_proveedor',
        'placa', 'transportadora', 'humedad', 'responsable',
        'observaciones', 'densidad', 'soya_test', 'piscina',
        'efervescencia', 'infestacion', 'temp_bultos',
        'temp_ambiente', 'f_vencimiento', 'granulometria', 'retencion',
        'cloruro', 'acidez', 'peroxidos', 'tanque_almacenamiento',
        'adinox', 'temperatura', 'polvo', 'partido', 'danados',
        'impurezas', 'silo', 'densidad_aparente', 'densidad_real',
        'cantidad', 'created_at', 'updated_at'
    ];
}