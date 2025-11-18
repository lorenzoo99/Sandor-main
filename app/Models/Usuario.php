<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'contraseña_hash',
        'rol',
        'fecha_creacion',
        'activo',
    ];

    protected $hidden = [
        'contraseña_hash',
        'remember_token',
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'activo' => 'boolean',
    ];

    public function getAuthPassword()
    {
        return $this->contraseña_hash;
    }
}
