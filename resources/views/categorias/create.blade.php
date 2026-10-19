@extends('layouts.app')

@section('title', 'Nueva Categoría')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('categorias.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a categorías
        </a>
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">Crear Nueva Categoría</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Define una nueva área temática de especialidad</p>
    </div>

    <div class="glass-panel" style="padding: 2rem;">
        <form action="{{ route('categorias.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label" for="nombre">Nombre de la Categoría *</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej. Robótica & IoT" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="descripcion">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Describe el alcance formativo de los cursos de esta categoría...">{{ old('descripcion') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="color">Color Distintivo *</label>
                    <input type="color" name="color" id="color" class="form-control" value="{{ old('color', '#38bdf8') }}" style="height: 48px; padding: 0.25rem 0.5rem;" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="icono">Nombre de Ícono (FontAwesome)</label>
                    <input type="text" name="icono" id="icono" class="form-control" value="{{ old('icono', 'folder') }}" placeholder="Ej. code, palette, robot, laptop">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('categorias.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Categoría
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
