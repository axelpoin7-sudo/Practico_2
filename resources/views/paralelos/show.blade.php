@extends('layouts.app')

@section('title', 'Paralelo: ' . $paralelo->nombre)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <div>
        <a href="{{ route('paralelos.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a paralelos
        </a>
    </div>

    <div class="glass-panel" style="padding: 2.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1rem;">
            <div>
                <span class="badge badge-info">{{ $paralelo->codigo }}</span>
                <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">{{ $paralelo->nombre }}</h1>
                <p style="color: #38bdf8; font-weight: 600; font-size: 1.1rem;">Curso: {{ $paralelo->curso->nombre ?? 'N/A' }}</p>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('paralelos.inscritos', $paralelo) }}" class="btn-modern btn-primary">
                    <i class="fa-solid fa-users"></i> Ver Lista Completa de Inscritos
                </a>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; border-top: 1px solid var(--border-glass); padding-top: 1.5rem; margin-top: 1.5rem;">
            <div>
                <div style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Horario & Días</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-top: 0.25rem;">{{ $paralelo->dias }}</div>
                <div style="color: #38bdf8; font-size: 0.95rem; font-weight: 600;">{{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}</div>
            </div>

            <div>
                <div style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Ubicación & Docente</div>
                <div style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-top: 0.25rem;">{{ $paralelo->aula }}</div>
                <div style="color: var(--text-muted); font-size: 0.9rem;">Prof. {{ $paralelo->instructor->nombre_completo ?? 'N/A' }}</div>
            </div>

            <div>
                <div style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Fechas</div>
                <div style="font-size: 1rem; font-weight: 600; color: #ffffff; margin-top: 0.25rem;">
                    Del {{ $paralelo->fecha_inicio ? $paralelo->fecha_inicio->format('d/m/Y') : '' }} al {{ $paralelo->fecha_fin ? $paralelo->fecha_fin->format('d/m/Y') : '' }}
                </div>
                <div style="font-size: 0.8rem; color: var(--text-dim);">Estado: <span style="text-transform: capitalize; color: #34d399;">{{ $paralelo->estado }}</span></div>
            </div>

            <div>
                <div style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Ocupación</div>
                <div style="font-size: 1.35rem; font-weight: 800; color: {{ $paralelo->estaLleno() ? '#ef4444' : '#34d399' }};">
                    {{ $paralelo->cupos_ocupados }} / {{ $paralelo->cupo_maximo }} ({{ $paralelo->porcentaje_ocupacion }}%)
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
