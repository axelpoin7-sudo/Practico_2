<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paralelo extends Model
{
    use HasFactory;

    protected $table = 'paralelos';

    protected $fillable = [
        'curso_id',
        'instructor_id',
        'codigo',
        'nombre',
        'aula',
        'fecha_inicio',
        'fecha_fin',
        'dias',
        'dias_semana',
        'hora_inicio',
        'hora_fin',
        'cupo_maximo',
        'estado',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'cupo_maximo' => 'integer',
    ];

    /**
     * El paralelo pertenece a un curso.
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    /**
     * Instructor asignado al paralelo (puede ser el titular o un adjunto).
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * Inscripciones realizadas en este paralelo.
     */
    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class, 'paralelo_id');
    }

    /**
     * Participantes inscritos a través de la tabla de inscripciones.
     */
    public function participantes(): BelongsToMany
    {
        return $this->belongsToMany(Participante::class, 'inscripciones', 'paralelo_id', 'participante_id')
            ->withPivot(['id', 'codigo', 'fecha_inscripcion', 'monto_pagado', 'estado', 'metodo_pago'])
            ->withTimestamps();
    }

    /**
     * Cuenta la cantidad de cupos actualmente ocupados (inscripciones no anuladas).
     */
    public function getCuposOcupadosAttribute(): int
    {
        if ($this->relationLoaded('inscripciones')) {
            return $this->inscripciones->whereIn('estado', ['pendiente', 'pagada'])->count();
        }

        return $this->inscripciones()->whereIn('estado', ['pendiente', 'pagada'])->count();
    }

    /**
     * Calcula los cupos libres restantes.
     */
    public function getCuposDisponiblesAttribute(): int
    {
        return max(0, $this->cupo_maximo - $this->cupos_ocupados);
    }

    /**
     * Porcentaje de ocupación actual.
     */
    public function getPorcentajeOcupacionAttribute(): float
    {
        if ($this->cupo_maximo <= 0) {
            return 0.0;
        }

        return round(($this->cupos_ocupados / $this->cupo_maximo) * 100, 1);
    }

    /**
     * Determina si el paralelo ha llegado al límite de su capacidad.
     */
    public function estaLleno(): bool
    {
        return $this->cupos_disponibles <= 0;
    }

    /**
     * Valida si este paralelo tiene conflicto de horario con otro paralelo.
     * Evalúa: solapamiento de fechas, coincidencia en días de la semana y solapamiento de horario.
     */
    public function tieneConflictoHorarioCon(Paralelo $otro): bool
    {
        if ($this->id && $otro->id && $this->id === $otro->id) {
            return true;
        }

        // 1. Rango de fechas
        $fechaInicioA = Carbon::parse($this->fecha_inicio);
        $fechaFinA = Carbon::parse($this->fecha_fin);
        $fechaInicioB = Carbon::parse($otro->fecha_inicio);
        $fechaFinB = Carbon::parse($otro->fecha_fin);

        if ($fechaInicioA->gt($fechaFinB) || $fechaFinA->lt($fechaInicioB)) {
            return false;
        }

        // 2. Días de la semana
        $diasA = array_map('trim', explode(',', strtolower($this->dias_semana ?? '')));
        $diasB = array_map('trim', explode(',', strtolower($otro->dias_semana ?? '')));
        $diasComunes = array_intersect($diasA, $diasB);

        if (empty($diasComunes)) {
            return false;
        }

        // 3. Rango de horas (traslape: A_inicio < B_fin && A_fin > B_inicio)
        $horaInicioA = substr((string) $this->hora_inicio, 0, 5);
        $horaFinA = substr((string) $this->hora_fin, 0, 5);
        $horaInicioB = substr((string) $otro->hora_inicio, 0, 5);
        $horaFinB = substr((string) $otro->hora_fin, 0, 5);

        return ($horaInicioA < $horaFinB && $horaFinA > $horaInicioB);
    }

    /**
     * Scope para paralelos abiertos para inscripción.
     */
    public function scopeAbiertos($query)
    {
        return $query->where('estado', 'abierto');
    }
}
