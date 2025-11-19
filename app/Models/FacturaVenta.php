<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaVenta extends Model
{
    protected $table = 'FacturaVenta';
    protected $primaryKey = 'id_factura';
    public $timestamps = false;

    protected $fillable = [
        'numero_factura',
        'tipo_factura',
        'fecha_emision',
        'id_cliente',
        'subtotal',
        'iva',
        'total',
        'estado',
        'id_usuario',
        'prefijo',
        'numero_resolucion',
        'cufe',
        'medio_pago',
        'forma_pago',
        'moneda'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleFacturaVenta::class, 'id_factura');
    }
}
