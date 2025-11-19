<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacturaCompra extends Model
{
    protected $table = 'FacturaCompra';
    protected $primaryKey = 'id_factura_compra';
    public $timestamps = false;

    protected $fillable = [
        'numero_factura',
        'id_proveedor',
        'fecha_emision',
        'subtotal',
        'iva',
        'total',
        'estado',
        'id_usuario'
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
