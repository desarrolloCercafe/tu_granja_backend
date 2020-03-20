<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ValoresAuditoria extends Model
{
    protected $table = 'valores_auditorias';
    protected $fillable = ['id', 'id_pregunta', 'id_proceso_macro', 'id_porcentaje_subproceso', 'calificacion', 'indicador', 'max', 'diferencia', 'promedio', 'observacion'];
}
