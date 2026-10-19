@extends('layouts.app')

@section('title', 'Categoría: ' . $categoria->nombre)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <div>
        <a href="{{ route('categorias.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a categorías
        </a>
        <div style="display: flex; align-items: center; gap: 1rem; margin-top: 0.75rem;">
            <div style="width: 50px; height: 50px; border-radius: 14px; background: {{ $categoria->color }}25; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-{{ $categoria->icono ?? 'folder' }}" style="font-size: 1.5rem; color: {{ $categoria->color }};"></i>
            </div>
            <div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">{{ $categoria->nombre }}</h1>
                <p style="color: var(--text-muted); font-size: 0.9rem;">{{ $categoria->descripcion }}</p>
            </div>
        </div>
    </div>

    <!-- Cursos bajo esta categoría -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h2 style="font-size: 1.3rem; font-weight: 700;">Cursos en esta Categoría ({{ $categoria->cursos->count() }})</h2>
            <a href="{{ route('cursos.create') }}" class="btn-modern btn-primary" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
                <i class="fa-solid fa-plus-circle"></i> Nuevo Curso
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
            @forelse($categoria->cursos as $curso)
                <div class="glass-panel" style="padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                            <span class="badge badge-info">{{ $curso->codigo }}</span>
                            <span class="badge" style="background: rgba(255, 255, 255, 0.08); color: #e2e8f0;">{{ $curso->nivel }}</span>
                        </div>
                        <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">{{ $curso->nombre }}</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem;">
                            {{ Str::limit($curso->descripcion, 90) }}
                        </p>
                        <div style="font-size: 0.825rem; color: var(--text-dim); margin-bottom: 0.75rem;">
                            <i class="fa-solid fa-user-tie"></i> Dictado por: <span style="color: #ffffff;">{{ $curso->instructor->nombre_completo ?? 'Sin asignar' }}</span>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--border-glass); padding-top: 0.85rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-dim);">Inversión</div>
                            <div style="font-size: 1.15rem; font-weight: 800; color: #34d399; font-family: 'Outfit';">Bs. {{ number_format($curso->costo, 2) }}</div>
                        </div>
                        <a href="{{ route('cursos.show', $curso) }}" class="btn-modern btn-secondary" style="padding: 0.45rem 0.9rem; font-size: 0.8rem;">
                            Ver Paralelos ({{ $curso->paralelos->count() }})
                        </a>
                    </div>
                </div>
            @empty
                <div class="glass-panel" style="grid-column: 1 / -1; padding: 2.5rem; text-align: center; color: var(--text-dim);">
                    No hay cursos registrados en esta categoría aún.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
