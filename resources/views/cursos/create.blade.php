@extends('layouts.app')

@section('title', 'Nuevo Curso')

@section('content')
<div style="max-width: 760px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('cursos.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver al catálogo
        </a>
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">Crear Nuevo Curso Corto</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Define el plan, categoría, instructor titular y costo de la capacitación</p>
    </div>

    <div class="glass-panel" style="padding: 2rem;">
        <form action="{{ route('cursos.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="codigo">Código del Curso *</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', 'CUR-' . strtoupper(Str::random(5))) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre del Curso *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej. Excel Avanzado con Macros" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="categoria_id">Categoría *</label>
                    <select name="categoria_id" id="categoria_id" class="form-select" required>
                        <option value="">-- Seleccionar Categoría --</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="instructor_id">Instructor Titular *</label>
                    <select name="instructor_id" id="instructor_id" class="form-select" required>
                        <option value="">-- Seleccionar Instructor --</option>
                        @foreach($instructores as $inst)
                            <option value="{{ $inst->id }}" {{ old('instructor_id') == $inst->id ? 'selected' : '' }}>
                                {{ $inst->nombre_completo }} ({{ $inst->especialidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="descripcion">Descripción del Contenido *</label>
                <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Temario sintetizado, objetivos de aprendizaje..." required>{{ old('descripcion') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="costo">Costo de Inscripción (Bs.) *</label>
                    <input type="number" step="0.5" name="costo" id="costo" class="form-control" value="{{ old('costo', '250.00') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="duracion_horas">Duración (Horas) *</label>
                    <input type="number" name="duracion_horas" id="duracion_horas" class="form-control" value="{{ old('duracion_horas', 30) }}" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nivel">Nivel Académico *</label>
                    <select name="nivel" id="nivel" class="form-select" required>
                        <option value="Básico" {{ old('nivel') == 'Básico' ? 'selected' : '' }}>Básico</option>
                        <option value="Intermedio" {{ old('nivel') == 'Intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="Avanzado" {{ old('nivel') == 'Avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('cursos.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Curso
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
