<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'Empleado';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo_identificacion',
        'numero_identificacion',
        'cargo',
        'salario_base',
        'fecha_ingreso',
        'telefono',
        'correo',
        'direccion',
        'estado'
    ];

    protected $casts = [
        'salario_base' => 'decimal:2',
        'fecha_ingreso' => 'date',
        'estado' => 'integer'
    ];

    /**
     * Relación con nóminas
     */
    public function nominas()
    {
        return $this->hasMany(Nomina::class, 'id_empleado');
    }

    /**
     * Scope para empleados activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Verificar si el empleado está activo
     */
    public function estaActivo()
    {
        return $this->estado == 1;
    }

    /**
     * Calcular deducciones de salud (4%)
     */
    public function calcularSalud()
    {
        return $this->salario_base * 0.04;
    }

    /**
     * Calcular deducciones de pensión (4%)
     */
    public function calcularPension()
    {
        return $this->salario_base * 0.04;
    }

    /**
     * Calcular total deducciones
     */
    public function calcularTotalDeducciones()
    {
        return $this->calcularSalud() + $this->calcularPension();
    }

    /**
     * Calcular salario neto
     */
    public function calcularSalarioNeto()
    {
        return $this->salario_base - $this->calcularTotalDeducciones();
    }
}
