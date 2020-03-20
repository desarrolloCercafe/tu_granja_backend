<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class macros_micros extends Model
{
    protected $table = 'macros_micros';
    protected $fillable = [
        'id', 'fecha', 'id_op', 'lote_azucar', 'lote_carbonato', 'lote_fosfato', 'lote_arroz', 'lote_hemoglobina',
        'lote_nucleo', 'lote_plasma', 'lote_sal', 'lote_otro', 'lote_aceite', 'macro_aceite', 'lote_gluten',
        'macro_gluten', 'lote_pescado', 'macro_pescado', 'lote_lactosuero', 'macro_lactosuero', 'lote_maiz',
        'macro_maiz', 'lote_mogolla', 'macro_mogolla', 'lote_palmiste', 'macro_palmiste', 'lote_salvado',
        'macro_salvado', 'lote_soya', 'macro_soya', 'created_at', 'updated_at'
    ];
}