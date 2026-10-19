@extends('layouts.app')

@section('title', 'Registrar Instructor')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('instructores.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a instructores
        </a>
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">Registrar Instructor</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Agrega un docente especialista con su formación y credenciales</p>
    </div>

    <div class="glass-panel" style="padding: 2rem;">
        <form action="{{ route('instructores.store') }}" method="POST">
            @csrf

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="nombres">Nombres *</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" value="{{ old('nombres') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="apellidos">Apellidos *</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="documento_identidad">Documento de Identidad (CI) *</label>
                    <input type="text" name="documento_identidad" id="documento_identidad" class="form-control" value="{{ old('documento_identidad') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="telefono">Teléfono / Celular *</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="email">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="experiencia_anos">Años Experiencia *</label>
                    <input type="number" name="experiencia_anos" id="experiencia_anos" class="form-control" value="{{ old('experiencia_anos', 3) }}" min="0" max="50" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="especialidad">Especialidad Principal *</label>
                <input type="text" name="especialidad" id="especialidad" class="form-control" value="{{ old('especialidad') }}" placeholder="Ej. Diseño UI/UX y Prototipado en Figma" required>
            </div>

            <div class="form-group">
                <label class="form-label" for="biografia">Resumen Profesional / Biografía</label>
                <textarea name="biografia" id="biografia" rows="3" class="form-control" placeholder="Trayectoria académica, certificaciones o experiencia docente...">{{ old('biografia') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('instructores.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-save"></i> Guardar Instructor
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
