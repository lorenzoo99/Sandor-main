<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Cliente';
    protected $primaryKey = 'id_cliente';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tipo_identificacion',
        'numero_identificacion',
        'direccion',
        'telefono',
        'correo',
        'fecha_registro',
        'codigo_municipio',
    ];

    public function facturas()
    {
        return $this->hasMany(FacturaVenta::class, 'id_cliente');
    }
}
