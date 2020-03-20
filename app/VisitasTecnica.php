<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitasTecnica extends Model
{
    protected $table = 'informe_visitas_tecnica';
    protected $fillable = ['id', 'fecha', 'id_granja', 'granja_nombre', 'asociado', 'lugar', 'admin_granja', 'tipo_produccion', 'id_fuente_agua', 'id_suministro_agua', 'sitio_muestra_gestacion1', 'medicion_accupoint_gestacion1', 'sitio_muestra_gestacion2', 'medicion_accupoint_gestacion2', 'sitio_muestra_gestacion3', 'medicion_accupoint_gestacion3','sitio_muestra_maternidad1', 'medicion_accupoint_maternidad1', 'sitio_muestra_maternidad2', 'medicion_accupoint_maternidad2', 'sitio_muestra_maternidad3', 'medicion_accupoint_maternidad3', 'sitio_muestra_maternidad4', 'medicion_accupoint_maternidad4', 'observacion', 'recomendaciones'];
}
