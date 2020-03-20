<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
      use HasApiTokens, Notifiable;

      public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_completo', 'name', 'email', 'password', 'documento', 'telefono', 'fecha_nacimiento', 'sexo',
        'agente', 'sede_id', 'area_id', 'cargo_id', 'rol_id', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
/*     protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */
}
