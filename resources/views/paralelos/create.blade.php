@extends('layouts.app')

@section('title', 'Aperturar Paralelo')

@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('paralelos.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a paralelos
        </a>
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">Aperturar Nuevo Paralelo</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Configura el horario, días de dictado, aula y cupo máximo de participantes</p>
    </div>

    <div class="glass-panel" style="padding: 2rem;">
        <form action="{{ route('paralelos.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="codigo">Código del Paralelo *</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{ old('codigo', 'PAR-' . strtoupper(Str::random(5))) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre / Denominación *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ej. Paralelo Mañana A" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="curso_id">Curso Asociado *</label>
                    <select name="curso_id" id="curso_id" class="form-select" required>
                        <option value="">-- Seleccionar Curso --</option>
                        @foreach($cursos as $c)
                            <option value="{{ $c->id }}" {{ (old('curso_id', $selectedCursoId) == $c->id) ? 'selected' : '' }}>
                                {{ $c->codigo }} - {{ $c->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="instructor_id">Instructor Asignado (Opcional)</label>
                    <select name="instructor_id" id="instructor_id" class="form-select">
                        <option value="">-- Por defecto (Titular del curso) --</option>
                        @foreach($instructores as $inst)
                            <option value="{{ $inst->id }}" {{ old('instructor_id') == $inst->id ? 'selected' : '' }}>
                                {{ $inst->nombre_completo }} ({{ $inst->especialidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="aula">Aula / Laboratorio Asignado *</label>
                    <input type="text" name="aula" id="aula" class="form-control" value="{{ old('aula') }}" placeholder="Ej. Laboratorio de Cómputo 102" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="cupo_maximo">Cupo Máximo de Alumnos *</label>
                    <input type="number" name="cupo_maximo" id="cupo_maximo" class="form-control" value="{{ old('cupo_maximo', 20) }}" min="1" max="100" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="fecha_inicio">Fecha de Inicio *</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ old('fecha_inicio', date('Y-m-d', strtotime('+7 days'))) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fecha_fin">Fecha de Culminación *</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ old('fecha_fin', date('Y-m-d', strtotime('+35 days'))) }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="dias">Días de Clases (Etiqueta legible) *</label>
                    <input type="text" name="dias" id="dias" class="form-control" value="{{ old('dias', 'Lunes, Miércoles, Viernes') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="dias_semana">Días de Semana (Detección de Cruces) *</label>
                    <input type="text" name="dias_semana" id="dias_semana" class="form-control" value="{{ old('dias_semana', 'lunes,miercoles,viernes') }}" placeholder="lunes,miercoles,viernes" required>
                    <small style="font-size: 0.75rem; color: var(--text-dim);">Valores separados por comas: lunes,martes,miercoles,jueves,viernes,sabados</small>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="hora_inicio">Hora Inicio *</label>
                    <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" value="{{ old('hora_inicio', '08:00') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="hora_fin">Hora Fin *</label>
                    <input type="time" name="hora_fin" id="hora_fin" class="form-control" value="{{ old('hora_fin', '10:00') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="estado">Estado Inicial *</label>
                    <select name="estado" id="estado" class="form-select" required>
                        <option value="abierto" selected>Abierto</option>
                        <option value="en_curso">En Curso</option>
                        <option value="cerrado">Cerrado</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('paralelos.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Paralelo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
