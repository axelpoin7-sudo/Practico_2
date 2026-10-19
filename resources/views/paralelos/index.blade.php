@extends('layouts.app')

@section('title', 'Paralelos y Horarios')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Paralelos & Control de Cupos</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Gestión de horarios, aulas asignadas, fechas de inicio y disponibilidad de cupo</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('paralelos.create') }}" class="btn-modern btn-primary">
                <i class="fa-solid fa-plus-circle"></i> Nuevo Paralelo
            </a>
        </div>
    </div>

    <!-- Filtro por Curso -->
    <div class="glass-panel" style="padding: 1rem 1.5rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <span style="font-size: 0.85rem; color: var(--text-dim);"><i class="fa-solid fa-filter"></i> Filtrar por Curso:</span>
        <a href="{{ route('paralelos.index') }}" class="btn-modern {{ empty($cursoId) ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
            Todos los Paralelos
        </a>
        @foreach($cursos as $c)
            <a href="{{ route('paralelos.index', ['curso_id' => $c->id]) }}" class="btn-modern {{ $cursoId == $c->id ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                {{ $c->codigo }}
            </a>
        @endforeach
    </div>

    <!-- Lista de Paralelos en Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.5rem;">
        @forelse($paralelos as $paralelo)
            <div class="glass-panel" style="padding: 1.75rem; border-top: 4px solid {{ $paralelo->estaLleno() ? '#ef4444' : '#10b981' }}; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span class="badge" style="background: {{ $paralelo->curso->categoria->color ?? '#38bdf8' }}20; color: {{ $paralelo->curso->categoria->color ?? '#38bdf8' }};">
                            {{ $paralelo->curso->nombre ?? 'Curso' }}
                        </span>
                        <span class="badge badge-info">{{ $paralelo->codigo }}</span>
                    </div>

                    <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">{{ $paralelo->nombre }}</h2>

                    <div style="display: flex; flex-direction: column; gap: 0.45rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                        <div><i class="fa-solid fa-location-dot"></i> Aula: <strong style="color: #ffffff;">{{ $paralelo->aula }}</strong></div>
                        <div><i class="fa-solid fa-calendar-days"></i> Días: <strong style="color: #ffffff;">{{ $paralelo->dias }}</strong></div>
                        <div><i class="fa-solid fa-clock"></i> Horario: <strong style="color: #38bdf8;">{{ substr($paralelo->hora_inicio, 0, 5) }} a {{ substr($paralelo->hora_fin, 0, 5) }}</strong></div>
                        <div><i class="fa-solid fa-user-tie"></i> Docente: {{ $paralelo->instructor->nombre_completo ?? 'Titular del curso' }}</div>
                        <div><i class="fa-solid fa-calendar-check"></i> Inicio: {{ $paralelo->fecha_inicio ? $paralelo->fecha_inicio->format('d/m/Y') : '' }} | Fin: {{ $paralelo->fecha_fin ? $paralelo->fecha_fin->format('d/m/Y') : '' }}</div>
                    </div>

                    <!-- Estado del Cupo -->
                    <div style="margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.8rem; margin-bottom: 0.35rem;">
                            <span>Ocupación de Cupo</span>
                            <span style="font-weight: 700; color: {{ $paralelo->estaLleno() ? '#ef4444' : '#34d399' }};">
                                {{ $paralelo->cupos_ocupados }} / {{ $paralelo->cupo_maximo }} inscritos ({{ $paralelo->porcentaje_ocupacion }}%)
                            </span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ min(100, $paralelo->porcentaje_ocupacion) }}%; background: {{ $paralelo->estaLleno() ? '#ef4444' : 'linear-gradient(90deg, #38bdf8, #10b981)' }};"></div>
                        </div>
                        <div style="margin-top: 0.35rem; font-size: 0.75rem; text-align: right;">
                            @if($paralelo->estaLleno())
                                <span style="color: #ef4444; font-weight: 700;"><i class="fa-solid fa-circle-exclamation"></i> Límite de cupo alcanzado</span>
                            @else
                                <span style="color: #38bdf8;"><i class="fa-solid fa-circle-check"></i> Quedan {{ $paralelo->cupos_disponibles }} cupos libres</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div style="border-top: 1px solid var(--border-glass); padding-top: 1rem; display: flex; gap: 0.75rem;">
                    <a href="{{ route('paralelos.inscritos', $paralelo) }}" class="btn-modern btn-secondary" style="flex: 1; justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.75rem;">
                        <i class="fa-solid fa-users"></i> Lista Inscritos
                    </a>
                    @if(!$paralelo->estaLleno())
                        <a href="{{ route('inscripciones.create', ['paralelo_id' => $paralelo->id]) }}" class="btn-modern btn-primary" style="flex: 1; justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.75rem;">
                            <i class="fa-solid fa-user-plus"></i> Inscribir
                        </a>
                    @else
                        <button disabled class="btn-modern btn-secondary" style="flex: 1; justify-content: center; font-size: 0.825rem; padding: 0.5rem 0.75rem; opacity: 0.5; cursor: not-allowed;">
                            Lleno
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="glass-panel" style="grid-column: 1 / -1; padding: 3rem; text-align: center; color: var(--text-dim);">
                No se encontraron paralelos con los criterios seleccionados.
            </div>
        @endforelse
    </div>
</div>
@endsection
