<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'codigo',
        'participante_id',
        'paralelo_id',
        'fecha_inscripcion',
        'monto_pagado',
        'estado',
        'metodo_pago',
        'comprobante',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'datetime',
        'monto_pagado' => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function ($inscripcion) {
            if (empty($inscripcion->codigo)) {
                $inscripcion->codigo = 'INS-' . date('Y') . '-' . strtoupper(Str::random(6));
            }
            if (empty($inscripcion->fecha_inscripcion)) {
                $inscripcion->fecha_inscripcion = now();
            }
        });
    }

    /**
     * Participante asociado a la inscripción.
     */
    public function participante(): BelongsTo
    {
        return $this->belongsTo(Participante::class, 'participante_id');
    }

    /**
     * Paralelo al que se inscribe el participante.
     */
    public function paralelo(): BelongsTo
    {
        return $this->belongsTo(Paralelo::class, 'paralelo_id');
    }

    /**
     * Scope para inscripciones pagadas.
     */
    public function scopePagadas($query)
    {
        return $query->where('estado', 'pagada');
    }

    /**
     * Scope para inscripciones pendientes.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para inscripciones anuladas.
     */
    public function scopeAnuladas($query)
    {
        return $query->where('estado', 'anulada');
    }

    /**
     * Scope para inscripciones vigentes (no anuladas).
     */
    public function scopeActivas($query)
    {
        return $query->whereIn('estado', ['pendiente', 'pagada']);
    }

    public function esPagada(): bool
    {
        return $this->estado === 'pagada';
    }

    public function esPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function esAnulada(): bool
    {
        return $this->estado === 'anulada';
    }
}
