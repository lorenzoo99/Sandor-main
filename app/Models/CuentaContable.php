<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaContable extends Model
{
    protected $table = 'CuentaContable';
    protected $primaryKey = 'id_cuenta';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo',
        'nivel',
        'estado'
    ];

    /**
     * Relación con detalles de asientos
     */
    public function detallesAsientos()
    {
        return $this->hasMany(DetalleAsiento::class, 'id_cuenta');
    }

    /**
     * Scope para cuentas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Scope por tipo de cuenta
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Obtener cuentas principales (nivel 1)
     */
    public function scopePrincipales($query)
    {
        return $query->where('nivel', 1);
    }
}
