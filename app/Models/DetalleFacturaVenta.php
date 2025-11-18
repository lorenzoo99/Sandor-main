<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleFacturaVenta extends Model
{
    protected $table = 'DetalleFacturaVenta';
    protected $primaryKey = 'id_detalle';
    public $timestamps = false;

    protected $fillable = [
        'id_factura',
        'descripcion',
        'cantidad',
        'valor_unitario',
        'subtotal',
        'iva',
        'total'
    ];

    public function factura()
    {
        return $this->belongsTo(FacturaVenta::class, 'id_factura');
    }
}
