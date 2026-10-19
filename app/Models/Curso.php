<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'categoria_id',
        'instructor_id',
        'codigo',
        'nombre',
        'descripcion',
        'costo',
        'duracion_horas',
        'nivel',
        'activo',
    ];

    protected $casts = [
        'costo' => 'decimal:2',
        'duracion_horas' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * El curso pertenece a una categoría.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * El curso es dictado por un instructor principal.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    /**
     * Un curso tiene varios paralelos.
     */
    public function paralelos(): HasMany
    {
        return $this->hasMany(Paralelo::class, 'curso_id');
    }

    /**
     * Un curso tiene inscripciones a través de sus paralelos.
     */
    public function inscripciones(): HasManyThrough
    {
        return $this->hasManyThrough(Inscripcion::class, Paralelo::class, 'curso_id', 'paralelo_id');
    }

    /**
     * Scope para cursos activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope por categoría.
     */
    public function scopeDeCategoria($query, int $categoriaId)
    {
        return $query->where('categoria_id', $categoriaId);
    }
}
