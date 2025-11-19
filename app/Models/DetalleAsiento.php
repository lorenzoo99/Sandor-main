<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleAsiento extends Model
{
    protected $table = 'DetalleAsiento';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_asiento',
        'id_cuenta',
        'tipo_movimiento',
        'valor'
    ];

    /**
     * Relación con asiento contable
     */
    public function asiento()
    {
        return $this->belongsTo(AsientoContable::class, 'id_asiento');
    }

    /**
     * Relación con cuenta contable
     */
    public function cuenta()
    {
        return $this->belongsTo(CuentaContable::class, 'id_cuenta');
    }

    /**
     * Scope para débitos
     */
    public function scopeDebitos($query)
    {
        return $query->where('tipo_movimiento', 'DEBITO');
    }

    /**
     * Scope para créditos
     */
    public function scopeCreditos($query)
    {
        return $query->where('tipo_movimiento', 'CREDITO');
    }
}
