<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'documento',
        'tipo_documento',
        'telefono',
        'email',
        'direccion1',
        'direccion2',
        'departamento_id',
        'ciudad_id',
        'saldo',
        'pais',
        'activo',
        'portal_acceso',
        'limite_credito',
        'dias_credito',
        'dias_pago',
        'contacto_principal',
        'sitio_web',
        'porcentaje_descuento',
        'usuario_id',
        'user_id_portal',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'saldo' => 'decimal:2',
        'limite_credito' => 'decimal:2',
        'portal_acceso' => 'string',  // enum: sin_acceso, pendiente, activo
    ];

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function portalUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id_portal');
    }

    /**
     * Calcula el precio con descuento para un producto.
     * Retorna precio_venta si no hay descuento.
     
    public function aplicarDescuento(float $precioVenta): float
    {
        if ($this->porcentaje_descuento > 0) {
            return round($precioVenta * (1 - $this->porcentaje_descuento / 100), 2);
        }

        return $precioVenta;
    }
    */
}
