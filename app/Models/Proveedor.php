<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';

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
        'limite_credito',
        'dias_credito',
        'dias_pago',
        'contacto_principal',
        'sitio_web',
        'usuario_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'saldo' => 'decimal:2',
        'limite_credito' => 'decimal:2',
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
}
