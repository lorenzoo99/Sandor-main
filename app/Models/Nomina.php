<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nomina extends Model
{
    protected $table = 'Nomina';
    protected $primaryKey = 'id_nomina';
    public $timestamps = false;

    protected $fillable = [
        'id_empleado',
        'periodo',
        'fecha_pago',
        'salario_base',
        'deduccion_salud',
        'deduccion_pension',
        'total_deducciones',
        'salario_neto',
        'estado',
        'id_usuario'
    ];

    protected $casts = [
        'salario_base' => 'decimal:2',
        'deduccion_salud' => 'decimal:2',
        'deduccion_pension' => 'decimal:2',
        'total_deducciones' => 'decimal:2',
        'salario_neto' => 'decimal:2',
        'fecha_pago' => 'date'
    ];

    /**
     * Relación con empleado
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    /**
     * Relación con usuario que procesó
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Scope para nóminas pagadas
     */
    public function scopePagadas($query)
    {
        return $query->where('estado', 'PAGADA');
    }

    /**
     * Scope para nóminas pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'PENDIENTE');
    }

    /**
     * Verificar si está pagada
     */
    public function estaPagada()
    {
        return $this->estado === 'PAGADA';
    }
}
