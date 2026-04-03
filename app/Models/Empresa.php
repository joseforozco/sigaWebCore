<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Empresa extends Model
{
    protected $table = 'empresa';

    protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'nit',
        'digito_verificacion',
        'tipo_persona',
        'regimen_tributario',
        'responsable_iva',
        'usa_seriales',
        'actividad_ciiu',
        'direccion',
        'departamento_id',
        'ciudad_id',
        'pais',
        'telefono',
        'celular',
        'email',
        'email_documentos',
        'sitio_web',
        'logo',
        'pie_pagina',
        'notas_factura',
        'margen_ganancia_default',
        'margen_ganancia_minimo',
    ];

    protected $casts = [
        'responsable_iva' => 'boolean',
        'usa_seriales' => 'boolean',
        'digito_verificacion' => 'integer',
    ];

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function ciudad(): BelongsTo
    {
        return $this->belongsTo(Ciudad::class);
    }

    public static function actual(): ?self
    {
        return static::query()->first();
    }

    public static function usaSeriales(): bool
    {
        return (bool) optional(static::actual())->usa_seriales;
    }
}
