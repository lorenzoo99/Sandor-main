<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TareaPendiente extends Model
{
    protected $table = 'TareaPendiente';
    protected $primaryKey = 'id_tarea';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'prioridad',
        'completada',
        'id_usuario',
        'fecha_creacion',
        'fecha_completada'
    ];

    protected $casts = [
        'completada' => 'boolean',
        'fecha_creacion' => 'datetime',
        'fecha_completada' => 'datetime'
    ];

    // Scope para tareas pendientes (no completadas)
    public function scopePendientes($query)
    {
        return $query->where('completada', false);
    }

    // Scope para tareas del usuario actual
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('id_usuario', $userId);
    }

    // Relación con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
