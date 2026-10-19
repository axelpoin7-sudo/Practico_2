<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Instructor extends Model
{
    use HasFactory;

    protected $table = 'instructores';

    protected $fillable = [
        'documento_identidad',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'especialidad',
        'biografia',
        'experiencia_anos',
        'activo',
    ];

    protected $casts = [
        'experiencia_anos' => 'integer',
        'activo' => 'boolean',
    ];

    /**
     * Un instructor dicta varios cursos.
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'instructor_id');
    }

    /**
     * Un instructor puede dictar paralelos directamente.
     */
    public function paralelos(): HasMany
    {
        return $this->hasMany(Paralelo::class, 'instructor_id');
    }

    /**
     * Accesor para nombre completo.
     */
    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    /**
     * Scope para instructores activos.
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
