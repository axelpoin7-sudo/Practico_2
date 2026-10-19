<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'icono',
        'color',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    /**
     * Un categoría tiene muchos cursos.
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'categoria_id');
    }

    /**
     * Una categoría tiene muchos paralelos a través de sus cursos.
     */
    public function paralelos(): HasManyThrough
    {
        return $this->hasManyThrough(Paralelo::class, Curso::class, 'categoria_id', 'curso_id');
    }

    /**
     * Scope para categorías activas.
     */
    public function scopeActivas($query)
    {
        return $query->where('activo', true);
    }
}
