@extends('layouts.app')

@section('title', 'Lista de Inscritos - ' . $paralelo->nombre)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <!-- Navigation & Print Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <a href="{{ route('paralelos.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
                <i class="fa-solid fa-arrow-left"></i> Volver a paralelos
            </a>
            <h1 style="font-size: 1.85rem; font-weight: 800; margin-top: 0.5rem; color: #ffffff;">
                Lista Oficial de Inscritos por Paralelo
            </h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Emisión de nómina de alumnos matriculados y control de estados de pago</p>
        </div>

        <div style="display: flex; gap: 0.75rem;">
            <button onclick="window.print()" class="btn-modern btn-secondary">
                <i class="fa-solid fa-print"></i> Imprimir Nómina
            </button>
            @if(!$paralelo->estaLleno())
                <a href="{{ route('inscripciones.create', ['paralelo_id' => $paralelo->id]) }}" class="btn-modern btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Inscribir Alumno
                </a>
            @endif
        </div>
    </div>

    <!-- Ficha del Paralelo -->
    <div class="glass-panel" style="padding: 1.75rem; border-top: 4px solid var(--primary);">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem;">
            <div>
                <span class="badge badge-info" style="margin-bottom: 0.5rem;">{{ $paralelo->codigo }}</span>
                <h2 style="font-size: 1.35rem; font-weight: 800; color: #ffffff;">{{ $paralelo->nombre }}</h2>
                <div style="font-size: 0.95rem; color: #38bdf8; font-weight: 600;">
                    Curso: {{ $paralelo->curso->nombre ?? 'N/A' }}
                </div>
            </div>

            <div style="font-size: 0.875rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.35rem;">
                <div><i class="fa-solid fa-location-dot"></i> Aula: <strong style="color: #ffffff;">{{ $paralelo->aula }}</strong></div>
                <div><i class="fa-solid fa-calendar-days"></i> Días: <strong style="color: #ffffff;">{{ $paralelo->dias }}</strong></div>
                <div><i class="fa-solid fa-clock"></i> Horario: <strong style="color: #38bdf8;">{{ substr($paralelo->hora_inicio, 0, 5) }} - {{ substr($paralelo->hora_fin, 0, 5) }}</strong></div>
            </div>

            <div style="font-size: 0.875rem; color: var(--text-muted); display: flex; flex-direction: column; gap: 0.35rem;">
                <div><i class="fa-solid fa-chalkboard-user"></i> Docente: <strong style="color: #ffffff;">{{ $paralelo->instructor->nombre_completo ?? 'N/A' }}</strong></div>
                <div><i class="fa-solid fa-calendar-check"></i> Fechas: {{ $paralelo->fecha_inicio ? $paralelo->fecha_inicio->format('d/m/Y') : '' }} al {{ $paralelo->fecha_fin ? $paralelo->fecha_fin->format('d/m/Y') : '' }}</div>
                <div><i class="fa-solid fa-tag"></i> Costo Oficial: <strong style="color: #34d399;">Bs. {{ number_format($paralelo->curso->costo ?? 0, 2) }}</strong></div>
            </div>

            <div>
                <div style="font-size: 0.8rem; color: var(--text-dim); margin-bottom: 0.25rem;">Capacidad & Cupos</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: {{ $paralelo->estaLleno() ? '#ef4444' : '#34d399' }}; font-family: 'Outfit';">
                    {{ $paralelo->cupos_ocupados }} / {{ $paralelo->cupo_maximo }}
                </div>
                <div class="progress-bar-bg" style="margin-top: 0.5rem;">
                    <div class="progress-bar-fill" style="width: {{ min(100, $paralelo->porcentaje_ocupacion) }}%; background: {{ $paralelo->estaLleno() ? '#ef4444' : '#10b981' }};"></div>
                </div>
                <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.35rem;">
                    {{ $paralelo->cupos_disponibles }} cupos disponibles
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas del Paralelo -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div class="glass-panel" style="padding: 1.25rem; text-align: center;">
            <div style="font-size: 0.8rem; color: var(--text-dim); text-transform: uppercase;">Total Registrados</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #ffffff;">{{ $totales['total'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 1.25rem; text-align: center;">
            <div style="font-size: 0.8rem; color: #34d399; text-transform: uppercase;">Pagadas</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #34d399;">{{ $totales['pagadas'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 1.25rem; text-align: center;">
            <div style="font-size: 0.8rem; color: #fbbf24; text-transform: uppercase;">Pendientes</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #fbbf24;">{{ $totales['pendientes'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 1.25rem; text-align: center;">
            <div style="font-size: 0.8rem; color: #f87171; text-transform: uppercase;">Anuladas</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #f87171;">{{ $totales['anuladas'] }}</div>
        </div>
        <div class="glass-panel" style="padding: 1.25rem; text-align: center; border: 1px solid rgba(16, 185, 129, 0.4);">
            <div style="font-size: 0.8rem; color: #34d399; text-transform: uppercase;">Total Recaudado</div>
            <div style="font-size: 1.75rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                Bs. {{ number_format($totales['total_recaudado'], 2) }}
            </div>
        </div>
    </div>

    <!-- Nómina de Participantes -->
    <div class="glass-panel" style="padding: 1.75rem;">
        <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 1.25rem;">Nómina de Estudiantes Matriculados</h3>
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Código Inscripción</th>
                        <th>Participante</th>
                        <th>Documento (CI)</th>
                        <th>Fecha Inscripción</th>
                        <th>Monto Pagado</th>
                        <th>Método & Comprobante</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscripciones as $idx => $ins)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td><code>{{ $ins->codigo }}</code></td>
                            <td>
                                <div style="font-weight: 600; color: #ffffff;">{{ $ins->participante->nombre_completo ?? 'N/A' }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-dim);">{{ $ins->participante->email ?? '' }}</div>
                            </td>
                            <td><strong>{{ $ins->participante->documento_identidad ?? 'N/A' }}</strong></td>
                            <td>{{ $ins->fecha_inscripcion ? $ins->fecha_inscripcion->format('d/m/Y H:i') : '-' }}</td>
                            <td style="font-weight: 700; color: {{ $ins->estado === 'pagada' ? '#34d399' : '#fbbf24' }};">
                                Bs. {{ number_format($ins->monto_pagado, 2) }}
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">{{ $ins->metodo_pago ?? 'N/A' }}</div>
                                @if($ins->comprobante)
                                    <div style="font-size: 0.75rem; color: var(--text-dim);"><i class="fa-solid fa-receipt"></i> {{ $ins->comprobante }}</div>
                                @endif
                            </td>
                            <td>
                                @if($ins->estado === 'pagada')
                                    <span class="badge badge-success"><i class="fa-solid fa-check"></i> Pagada</span>
                                @elseif($ins->estado === 'pendiente')
                                    <span class="badge badge-warning"><i class="fa-solid fa-hourglass-half"></i> Pendiente</span>
                                @else
                                    <span class="badge badge-danger"><i class="fa-solid fa-ban"></i> Anulada</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('inscripciones.show', $ins) }}" style="color: var(--primary); text-decoration: none; font-size: 0.85rem; font-weight: 600;">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; color: var(--text-dim); padding: 2.5rem;">
                                No hay participantes inscritos en este paralelo todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
