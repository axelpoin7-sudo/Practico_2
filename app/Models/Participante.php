<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participantes';

    protected $fillable = [
        'documento_identidad',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'direccion',
        'fecha_nacimiento',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Inscripciones realizadas por el participante.
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'participante_id');
    }

    /**
     * Paralelos a los que asiste el participante.
     */
    public function paralelos(): BelongsToMany
    {
        return $this->belongsToMany(Paralelo::class, 'inscripciones', 'participante_id', 'paralelo_id')
            ->withPivot(['id', 'codigo', 'fecha_inscripcion', 'monto_pagado', 'estado', 'metodo_pago'])
            ->withTimestamps();
    }

    /**
     * Nombre completo del participante.
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Obtiene los paralelos activos del participante (inscripciones vigentes).
     */
    public function paralelosActivos()
    {
        return $this->paralelos()
            ->wherePivotIn('estado', ['pendiente', 'pagada'])
            ->with('curso')
            ->get();
    }

    /**
     * Verifica si el participante ya tiene algún conflicto de horario con un nuevo paralelo.
     * Retorna el paralelo en conflicto si existe, o null si está libre.
     */
    public function obtenerConflictoConParalelo(Paralelo $nuevoParalelo): ?Paralelo
    {
        $paralelosActivos = $this->paralelosActivos();

        foreach ($paralelosActivos as $activo) {
            if ($activo->tieneConflictoHorarioCon($nuevoParalelo)) {
                return $activo;
            }
        }

        return null;
    }
}
