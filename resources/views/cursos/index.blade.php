@extends('layouts.app')

@section('title', 'Cursos Cortos')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Catálogo de Cursos Cortos</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Oferta formativa de especialización técnica y profesional</p>
        </div>
        <a href="{{ route('cursos.create') }}" class="btn-modern btn-primary">
            <i class="fa-solid fa-plus-circle"></i> Nuevo Curso
        </a>
    </div>

    <!-- Filtro por Categorías -->
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.85rem; color: var(--text-dim); margin-right: 0.5rem;">Filtrar por Área:</span>
        <a href="{{ route('cursos.index') }}" class="btn-modern {{ empty($categoriaId) ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8rem;">
            Todas
        </a>
        @foreach($categorias as $cat)
            <a href="{{ route('cursos.index', ['categoria_id' => $cat->id]) }}" class="btn-modern {{ $categoriaId == $cat->id ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.4rem 0.85rem; font-size: 0.8rem;">
                <i class="fa-solid fa-{{ $cat->icono ?? 'tag' }}"></i> {{ $cat->nombre }}
            </a>
        @endforeach
    </div>

    <!-- Grid de Cursos -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap: 1.5rem;">
        @forelse($cursos as $curso)
            <div class="glass-panel" style="padding: 1.75rem; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span class="badge" style="background: {{ $curso->categoria->color ?? '#38bdf8' }}25; color: {{ $curso->categoria->color ?? '#38bdf8' }}; border: 1px solid {{ $curso->categoria->color ?? '#38bdf8' }}40;">
                            {{ $curso->categoria->nombre ?? 'Sin Categoría' }}
                        </span>
                        <span class="badge badge-info">{{ $curso->codigo }}</span>
                    </div>

                    <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">{{ $curso->nombre }}</h2>
                    <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1.25rem;">
                        {{ Str::limit($curso->descripcion, 110) }}
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 0.35rem; font-size: 0.8rem; color: var(--text-dim); margin-bottom: 1.25rem;">
                        <div>
                            <i class="fa-solid fa-user-tie"></i> Instructor: 
                            <strong style="color: #ffffff;">{{ $curso->instructor->nombre_completo ?? 'No asignado' }}</strong>
                        </div>
                        <div style="display: flex; gap: 1rem;">
                            <span><i class="fa-solid fa-clock"></i> {{ $curso->duracion_horas }} horas</span>
                            <span><i class="fa-solid fa-signal"></i> {{ $curso->nivel }}</span>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <span style="font-size: 0.75rem; color: var(--text-dim); text-transform: uppercase;">Inversión</span>
                        <div style="font-size: 1.25rem; font-weight: 800; color: #34d399; font-family: 'Outfit';">
                            Bs. {{ number_format($curso->costo, 2) }}
                        </div>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('cursos.show', $curso) }}" class="btn-modern btn-secondary" style="padding: 0.45rem 0.9rem; font-size: 0.8rem;">
                            <i class="fa-solid fa-calendar-check"></i> {{ $curso->paralelos_count }} Paralelos
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="glass-panel" style="grid-column: 1 / -1; padding: 3rem; text-align: center; color: var(--text-dim);">
                No se encontraron cursos con el filtro seleccionado.
            </div>
        @endforelse
    </div>
</div>
@endsection
