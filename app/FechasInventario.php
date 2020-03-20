<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class FechasInventario extends Model
{
    protected $fillable = ['id', 'fecha', 'id_calendario', 'year', 'mes', 'dia'];
}
