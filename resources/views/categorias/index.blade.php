@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Categorías de Formación</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Organización temática de la oferta académica: Ofimática, Programación y Diseño</p>
        </div>
        <a href="{{ route('categorias.create') }}" class="btn-modern btn-primary">
            <i class="fa-solid fa-plus-circle"></i> Nueva Categoría
        </a>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
        @foreach($categorias as $categoria)
            <div class="glass-panel" style="padding: 1.75rem; border-top: 4px solid {{ $categoria->color }}; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div style="width: 48px; height: 48px; border-radius: 14px; background: {{ $categoria->color }}20; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-{{ $categoria->icono ?? 'folder' }}" style="font-size: 1.35rem; color: {{ $categoria->color }};"></i>
                        </div>
                        <span class="badge" style="background: {{ $categoria->color }}20; color: {{ $categoria->color }}; border: 1px solid {{ $categoria->color }}40;">
                            {{ $categoria->cursos_count }} Cursos
                        </span>
                    </div>

                    <h2 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">{{ $categoria->nombre }}</h2>
                    <p style="font-size: 0.875rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem;">
                        {{ $categoria->descripcion ?? 'Sin descripción ingresada.' }}
                    </p>
                </div>

                <div style="border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-size: 0.8rem; color: var(--text-dim);">
                        <i class="fa-solid fa-calendar-days"></i> {{ $categoria->paralelos_count }} Paralelos Activos
                    </span>
                    <a href="{{ route('categorias.show', $categoria) }}" class="btn-modern btn-secondary" style="padding: 0.45rem 0.9rem; font-size: 0.8rem;">
                        Ver Cursos <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
