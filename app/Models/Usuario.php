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

    // Accessors para compatibilidad con Breeze (inglés -> español)
    public function getNameAttribute()
    {
        return $this->nombre;
    }

    public function getEmailAttribute()
    {
        return $this->correo;
    }

    public function getAuthPassword()
    {
        return $this->contraseña_hash;
    }

    // Método para verificar si es superadmin
    public function isSuperAdmin()
    {
        return $this->rol === 'SUPERADMIN';
    }

    // Método para verificar si es cliente SaaS
    public function isClienteSaas()
    {
        return $this->rol === 'CLIENTE_SAAS';
    }

    // Método para verificar si tiene un rol específico
    public function hasRole($role)
    {
        return $this->rol === $role;
    }
}
