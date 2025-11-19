<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'Proveedor';
    protected $primaryKey = 'id_proveedor';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'nit',
        'direccion',
        'telefono',
        'correo',
        'fecha_registro'
    ];

    public function facturasCompra()
    {
        return $this->hasMany(FacturaCompra::class, 'id_proveedor');
    }
}
