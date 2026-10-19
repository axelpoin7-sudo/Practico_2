@extends('layouts.app')

@section('title', 'Reporte de Ingresos por Curso')

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Reporte Financiero de Ingresos por Curso</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Consolidado de recaudación, inscripciones pagadas, montos pendientes y proyecciones</p>
        </div>
        <div style="display: flex; gap: 0.75rem;">
            <button onclick="window.print()" class="btn-modern btn-secondary">
                <i class="fa-solid fa-print"></i> Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Resumen Consolidado -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
        <div class="glass-panel" style="padding: 1.5rem; border-left: 4px solid #10b981;">
            <div style="font-size: 0.8rem; color: #34d399; font-weight: 600; text-transform: uppercase;">Total Recaudado (Efectivo)</div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: 'Outfit'; margin-top: 0.25rem;">
                Bs. {{ number_format($totales['ingresos_recaudados'], 2) }}
            </div>
            <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.25rem;">
                <i class="fa-solid fa-circle-check" style="color: #10b981;"></i> {{ $totales['inscripciones_pagadas'] }} inscripciones confirmadas
            </div>
        </div>

        <div class="glass-panel" style="padding: 1.5rem; border-left: 4px solid #f59e0b;">
            <div style="font-size: 0.8rem; color: #fbbf24; font-weight: 600; text-transform: uppercase;">Ingresos Proyectados</div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: 'Outfit'; margin-top: 0.25rem;">
                Bs. {{ number_format($totales['ingresos_proyectados'], 2) }}
            </div>
            <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.25rem;">
                <i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i> Incluye {{ $totales['inscripciones_pendientes'] }} pendientes
            </div>
        </div>

        <div class="glass-panel" style="padding: 1.5rem; border-left: 4px solid #38bdf8;">
            <div style="font-size: 0.8rem; color: #7dd3fc; font-weight: 600; text-transform: uppercase;">Ocupación Global de Cupos</div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: 'Outfit'; margin-top: 0.25rem;">
                {{ $totales['cupos_ocupados'] }} / {{ $totales['total_cupos'] }}
            </div>
            <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.25rem;">
                {{ $totales['total_cupos'] > 0 ? round(($totales['cupos_ocupados'] / $totales['total_cupos']) * 100, 1) : 0 }}% de aforo en {{ $totales['total_paralelos'] }} paralelos
            </div>
        </div>

        <div class="glass-panel" style="padding: 1.5rem; border-left: 4px solid #8b5cf6;">
            <div style="font-size: 0.8rem; color: #c084fc; font-weight: 600; text-transform: uppercase;">Cursos Analizados</div>
            <div style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: 'Outfit'; margin-top: 0.25rem;">
                {{ $totales['total_cursos'] }}
            </div>
            <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 0.25rem;">
                En 3 áreas de formación
            </div>
        </div>
    </div>

    <!-- Tabla Detallada de Ingresos por Curso -->
    <div class="glass-panel" style="padding: 1.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700;">Desglose Financiero por Curso</h2>
            <span class="badge badge-purple">Moneda Oficial: Bolivianos (Bs.)</span>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Código & Curso</th>
                        <th>Área / Categoría</th>
                        <th>Instructor</th>
                        <th>Costo Unit.</th>
                        <th>Paralelos</th>
                        <th>Ocupación</th>
                        <th>Inscripciones (Pag / Pend / Anul)</th>
                        <th>Total Recaudado</th>
                        <th>Proyectado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporte as $item)
                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #ffffff;">{{ $item['nombre'] }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-dim);"><code>{{ $item['codigo'] }}</code></div>
                            </td>
                            <td>
                                <span class="badge" style="background: {{ $item['categoria_color'] }}20; color: {{ $item['categoria_color'] }};">
                                    {{ $item['categoria'] }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size: 0.85rem;">{{ $item['instructor'] }}</div>
                            </td>
                            <td style="font-weight: 600;">Bs. {{ number_format($item['costo'], 2) }}</td>
                            <td style="text-align: center; font-weight: 600;">{{ $item['total_paralelos'] }}</td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div class="progress-bar-bg" style="width: 70px;">
                                        <div class="progress-bar-fill" style="width: {{ min(100, $item['porcentaje_ocupacion']) }}%; background: linear-gradient(90deg, #38bdf8, #10b981);"></div>
                                    </div>
                                    <span style="font-size: 0.75rem; font-weight: 700;">{{ $item['porcentaje_ocupacion'] }}%</span>
                                </div>
                                <div style="font-size: 0.7rem; color: var(--text-dim);">{{ $item['cupos_ocupados'] }}/{{ $item['total_cupos'] }} cupos</div>
                            </td>
                            <td>
                                <span class="badge badge-success" title="Pagadas">{{ $item['inscripciones_pagadas'] }} pag</span>
                                <span class="badge badge-warning" title="Pendientes">{{ $item['inscripciones_pendientes'] }} pend</span>
                                @if($item['inscripciones_anuladas'] > 0)
                                    <span class="badge badge-danger" title="Anuladas">{{ $item['inscripciones_anuladas'] }} anul</span>
                                @endif
                            </td>
                            <td style="font-weight: 800; color: #34d399; font-size: 1rem; font-family: 'Outfit';">
                                Bs. {{ number_format($item['ingresos_recaudados'], 2) }}
                            </td>
                            <td style="font-weight: 700; color: #cbd5e1; font-size: 0.95rem; font-family: 'Outfit';">
                                Bs. {{ number_format($item['ingresos_proyectados'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: rgba(15, 23, 42, 0.9); font-weight: 800; border-top: 2px solid var(--border-accent);">
                        <td colspan="4" style="text-align: right; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">
                            Totales Consolidados:
                        </td>
                        <td style="text-align: center; color: #ffffff;">{{ $totales['total_paralelos'] }}</td>
                        <td>
                            <strong style="color: #38bdf8;">{{ $totales['cupos_ocupados'] }} / {{ $totales['total_cupos'] }}</strong>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ $totales['inscripciones_pagadas'] }} pag</span>
                            <span class="badge badge-warning">{{ $totales['inscripciones_pendientes'] }} pend</span>
                        </td>
                        <td style="font-size: 1.15rem; color: #34d399; font-family: 'Outfit';">
                            Bs. {{ number_format($totales['ingresos_recaudados'], 2) }}
                        </td>
                        <td style="font-size: 1.05rem; color: #ffffff; font-family: 'Outfit';">
                            Bs. {{ number_format($totales['ingresos_proyectados'], 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
