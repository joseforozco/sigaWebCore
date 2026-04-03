<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
    use HasFactory;

    protected $table = 'auditorias';

    protected $fillable = [
        'usuario_id',
        'tabla',
        'operacion',
        'registro_id',
        'datos_anteriores',
        'datos_nuevos',
        'fecha_operacion',
    ];

    protected $casts = [
        'datos_anteriores' => 'json',
        'datos_nuevos' => 'json',
        'fecha_operacion' => 'datetime',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
