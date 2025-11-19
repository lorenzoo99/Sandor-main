<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsientoContable extends Model
{
    protected $table = 'AsientoContable';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;

    protected $fillable = [
        'fecha',
        'descripcion',
        'id_usuario',
        'total_debito',
        'total_credito'
    ];

    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    /**
     * Relación con detalles del asiento
     */
    public function detalles()
    {
        return $this->hasMany(DetalleAsiento::class, 'id_asiento');
    }

    /**
     * Verificar si el asiento está balanceado
     */
    public function estaBalanceado()
    {
        return abs($this->total_debito - $this->total_credito) < 0.01;
    }
}
