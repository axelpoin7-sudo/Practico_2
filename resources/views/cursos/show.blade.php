@extends('layouts.app')

@section('title', 'Curso: ' . $curso->nombre)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <div>
        <a href="{{ route('cursos.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a cursos
        </a>
    </div>

    <!-- Curso Header Banner -->
    <div class="glass-panel" style="padding: 2.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <span class="badge" style="background: {{ $curso->categoria->color ?? '#38bdf8' }}25; color: {{ $curso->categoria->color ?? '#38bdf8' }};">
                    {{ $curso->categoria->nombre ?? 'General' }}
                </span>
                <span class="badge badge-info">{{ $curso->codigo }}</span>
                <span class="badge" style="background: rgba(255,255,255,0.08); color: #e2e8f0;">{{ $curso->nivel }}</span>
            </div>
            <div style="text-align: right;">
                <span style="font-size: 0.8rem; color: var(--text-dim);">Costo Oficial</span>
                <div style="font-size: 2rem; font-weight: 800; color: #34d399; font-family: 'Outfit';">
                    Bs. {{ number_format($curso->costo, 2) }}
                </div>
            </div>
        </div>

        <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-bottom: 0.75rem;">{{ $curso->nombre }}</h1>
        <p style="color: var(--text-muted); font-size: 0.95rem; line-height: 1.6; max-width: 900px; margin-bottom: 1.5rem;">
            {{ $curso->descripcion }}
        </p>

        <div style="display: flex; gap: 2rem; flex-wrap: wrap; border-top: 1px solid var(--border-glass); padding-top: 1.25rem; font-size: 0.85rem; color: var(--text-muted);">
            <div><i class="fa-solid fa-user-tie"></i> Docente Titular: <strong style="color: #ffffff;">{{ $curso->instructor->nombre_completo ?? 'N/A' }}</strong></div>
            <div><i class="fa-solid fa-clock"></i> Duración: <strong style="color: #ffffff;">{{ $curso->duracion_horas }} horas académicas</strong></div>
            <div><i class="fa-solid fa-layer-group"></i> Total Paralelos: <strong style="color: #38bdf8;">{{ $curso->paralelos->count() }}</strong></div>
        </div>
    </div>

    <!-- Paralelos del Curso -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h2 style="font-size: 1.35rem; font-weight: 700;">Paralelos Disponibles</h2>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Horarios, aulas asignadas, fechas y disponibilidad de cupo</p>
            </div>
            <a href="{{ route('paralelos.create', ['curso_id' => $curso->id]) }}" class="btn-modern btn-primary" style="font-size: 0.85rem; padding: 0.5rem 1rem;">
                <i class="fa-solid fa-plus-circle"></i> Aperturar Nuevo Paralelo
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(360px, 1fr)); gap: 1.5rem;">
            @forelse($curso->paralelos as $paralelo)
                <div class="glass-panel" style="padding: 1.75rem; border-top: 4px solid {{ $paralelo->estaLleno() ? '#ef4444' : '#10b981' }};">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <span class="badge badge-info">{{ $paralelo->codigo }}</span>
                        @if($paralelo->estaLleno())
                            <span class="badge badge-danger"><i class="fa-solid fa-ban"></i> Cupo Lleno</span>
                        @else
                            <span class="badge badge-success"><i class="fa-solid fa-check"></i> {{ $paralelo->cupos_disponibles }} cupos libres</span>
                        @endif
                    </div>

                    <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">{{ $paralelo->nombre }}</h3>

                    <div style="display: flex; flex-direction: column; gap: 0.45rem; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                        <div><i class="fa-solid fa-location-dot"></i> Aula: <strong style="color: #ffffff;">{{ $paralelo->aula }}</strong></div>
                        <div><i class="fa-solid fa-calendar-day"></i> Días: <strong style="color: #ffffff;">{{ $paralelo->dias }}</strong></div>
                        <div><i class="fa-solid fa-clock"></i> Horario: <strong style="color: #38bdf8;">{{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}</strong></div>
                        <div><i class="fa-solid fa-calendar-check"></i> Inicio: {{ $paralelo->fecha_inicio ? $paralelo->fecha_inicio->format('d/m/Y') : '' }} | Fin: {{ $paralelo->fecha_fin ? $paralelo->fecha_fin->format('d/m/Y') : '' }}</div>
                    </div>

                    <!-- Barra de Ocupación -->
                    <div style="margin-bottom: 1.25rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; margin-bottom: 0.35rem;">
                            <span>Ocupación de Cupo</span>
                            <span style="font-weight: 700; color: {{ $paralelo->estaLleno() ? '#ef4444' : '#38bdf8' }};">
                                {{ $paralelo->cupos_ocupados }} / {{ $paralelo->cupo_maximo }} ({{ $paralelo->porcentaje_ocupacion }}%)
                            </span>
                        </div>
                        <div class="progress-bar-bg">
                            <div class="progress-bar-fill" style="width: {{ min(100, $paralelo->porcentaje_ocupacion) }}%; background: {{ $paralelo->estaLleno() ? '#ef4444' : 'linear-gradient(90deg, #38bdf8, #10b981)' }};"></div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div style="display: flex; gap: 0.75rem; border-top: 1px solid var(--border-glass); padding-top: 1rem;">
                        <a href="{{ route('paralelos.inscritos', $paralelo) }}" class="btn-modern btn-secondary" style="flex: 1; justify-content: center; font-size: 0.8rem; padding: 0.5rem 0.75rem;">
                            <i class="fa-solid fa-list-ol"></i> Ver Inscritos
                        </a>
                        @if(!$paralelo->estaLleno())
                            <a href="{{ route('inscripciones.create', ['paralelo_id' => $paralelo->id]) }}" class="btn-modern btn-primary" style="flex: 1; justify-content: center; font-size: 0.8rem; padding: 0.5rem 0.75rem;">
                                <i class="fa-solid fa-user-plus"></i> Inscribir
                            </a>
                        @else
                            <button disabled class="btn-modern btn-secondary" style="flex: 1; justify-content: center; font-size: 0.8rem; padding: 0.5rem 0.75rem; opacity: 0.5; cursor: not-allowed;">
                                Lleno
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="glass-panel" style="grid-column: 1 / -1; padding: 2.5rem; text-align: center; color: var(--text-dim);">
                    Este curso no tiene paralelos abiertos todavía.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
