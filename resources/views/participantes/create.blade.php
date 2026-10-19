@extends('layouts.app')

@section('title', 'Registrar Participante')

@section('content')
<div style="max-width: 680px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('participantes.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a participantes
        </a>
        <h1 style="font-size: 1.75rem; font-weight: 800; margin-top: 0.5rem;">Registrar Participante</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">Crea el expediente personal para habilitar inscripciones en paralelos</p>
    </div>

    <div class="glass-panel" style="padding: 2rem;">
        <form action="{{ route('participantes.store') }}" method="POST">
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
                    <label class="form-label" for="telefono">Teléfono / WhatsApp *</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="email">Correo Electrónico *</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="fecha_nacimiento">Fecha Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="direccion">Dirección Domiciliaria / Ciudad</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}" placeholder="Ej. Calle Los Álamos #345, La Paz">
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                <a href="{{ route('participantes.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-save"></i> Registrar Participante
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
