<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Producto';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'porcentaje_iva',
        'stock',
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'porcentaje_iva' => 'decimal:2',
        'stock' => 'integer',
        'estado' => 'integer'
    ];

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 1);
    }

    /**
     * Scope para productos con stock
     */
    public function scopeConStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Verificar si el producto está activo
     */
    public function estaActivo()
    {
        return $this->estado == 1;
    }

    /**
     * Calcular el valor del IVA
     */
    public function calcularIva()
    {
        return $this->precio * ($this->porcentaje_iva / 100);
    }

    /**
     * Calcular precio con IVA incluido
     */
    public function precioConIva()
    {
        return $this->precio + $this->calcularIva();
    }

    /**
     * Obtener el porcentaje de IVA formateado
     */
    public function getIvaFormateadoAttribute()
    {
        return number_format($this->porcentaje_iva, 0) . '%';
    }

    /**
     * Verificar si tiene stock suficiente
     */
    public function tieneStock($cantidad = 1)
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Reducir stock
     */
    public function reducirStock($cantidad)
    {
        if ($this->tieneStock($cantidad)) {
            $this->stock -= $cantidad;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Aumentar stock
     */
    public function aumentarStock($cantidad)
    {
        $this->stock += $cantidad;
        $this->save();
    }
}
