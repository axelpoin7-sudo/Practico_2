@extends('layouts.app')

@section('title', 'Participantes')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Participantes Matriculados</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Registro y consulta de alumnos inscritos en los cursos de formación</p>
        </div>
        <a href="{{ route('participantes.create') }}" class="btn-modern btn-primary">
            <i class="fa-solid fa-user-plus"></i> Registrar Participante
        </a>
    </div>

    <!-- Buscador -->
    <div class="glass-panel" style="padding: 1.25rem;">
        <form action="{{ route('participantes.index') }}" method="GET" style="display: flex; gap: 1rem;">
            <div style="position: relative; flex: 1;">
                <input type="text" name="buscar" class="form-control" placeholder="Buscar por documento de identidad, nombre, apellido o correo..." value="{{ $buscar ?? '' }}">
            </div>
            <button type="submit" class="btn-modern btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Buscar
            </button>
            @if(!empty($buscar))
                <a href="{{ route('participantes.index') }}" class="btn-modern btn-secondary">Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Tabla de Participantes -->
    <div class="glass-panel" style="padding: 1.5rem;">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Documento (CI)</th>
                        <th>Nombres y Apellidos</th>
                        <th>Email & Teléfono</th>
                        <th>Inscripciones Activas</th>
                        <th>Fecha Registro</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantes as $p)
                        <tr>
                            <td><strong>{{ $p->documento_identidad }}</strong></td>
                            <td style="font-weight: 600; color: #ffffff;">{{ $p->nombre_completo }}</td>
                            <td>
                                <div>{{ $p->email }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-dim);"><i class="fa-solid fa-phone"></i> {{ $p->telefono }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $p->inscripciones_count > 0 ? 'badge-success' : 'badge-warning' }}">
                                    <i class="fa-solid fa-graduation-cap"></i> {{ $p->inscripciones_count }} cursos
                                </span>
                            </td>
                            <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('participantes.show', $p) }}" class="btn-modern btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.8rem;">
                                        <i class="fa-solid fa-id-badge"></i> Historial
                                    </a>
                                    <a href="{{ route('inscripciones.create', ['participante_id' => $p->id]) }}" class="btn-modern btn-primary" style="padding: 0.35rem 0.65rem; font-size: 0.8rem;">
                                        <i class="fa-solid fa-plus"></i> Inscribir
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-dim); padding: 2.5rem;">
                                No se encontraron participantes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.25rem;">
            {{ $participantes->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
