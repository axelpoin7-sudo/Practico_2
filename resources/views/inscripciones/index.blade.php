@extends('layouts.app')

@section('title', 'Registro de Inscripciones')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.75rem; font-weight: 800;">Registro General de Inscripciones</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem;">Control de matrículas, pagos y validación de reglas de negocio del centro</p>
        </div>
        <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-primary">
            <i class="fa-solid fa-file-signature"></i> Nueva Inscripción
        </a>
    </div>

    <!-- Filtros de Estado y Paralelo -->
    <div class="glass-panel" style="padding: 1.25rem; display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
        <span style="font-size: 0.85rem; color: var(--text-dim);"><i class="fa-solid fa-filter"></i> Estado:</span>
        <a href="{{ route('inscripciones.index') }}" class="btn-modern {{ empty($estado) ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
            Todas
        </a>
        <a href="{{ route('inscripciones.index', ['estado' => 'pagada']) }}" class="btn-modern {{ $estado === 'pagada' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
            <i class="fa-solid fa-check"></i> Pagadas
        </a>
        <a href="{{ route('inscripciones.index', ['estado' => 'pendiente']) }}" class="btn-modern {{ $estado === 'pendiente' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
            <i class="fa-solid fa-clock"></i> Pendientes
        </a>
        <a href="{{ route('inscripciones.index', ['estado' => 'anulada']) }}" class="btn-modern {{ $estado === 'anulada' ? 'btn-primary' : 'btn-secondary' }}" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
            <i class="fa-solid fa-ban"></i> Anuladas
        </a>
    </div>

    <!-- Tabla de Inscripciones -->
    <div class="glass-panel" style="padding: 1.5rem;">
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Participante</th>
                        <th>Curso & Paralelo</th>
                        <th>Fecha Inscripción</th>
                        <th>Monto Pagado</th>
                        <th>Método & Comprobante</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inscripciones as $ins)
                        <tr>
                            <td><code>{{ $ins->codigo }}</code></td>
                            <td>
                                <strong style="color: #ffffff;">{{ $ins->participante->nombre_completo ?? 'N/A' }}</strong>
                                <div style="font-size: 0.75rem; color: var(--text-dim);">CI: {{ $ins->participante->documento_identidad ?? '' }}</div>
                            </td>
                            <td>
                                <div>{{ $ins->paralelo->curso->nombre ?? 'N/A' }}</div>
                                <div style="font-size: 0.75rem; color: var(--primary);">
                                    <i class="fa-solid fa-calendar-days"></i> {{ $ins->paralelo->nombre ?? 'N/A' }} ({{ $ins->paralelo->dias ?? '' }})
                                </div>
                            </td>
                            <td>{{ $ins->fecha_inscripcion ? $ins->fecha_inscripcion->format('d/m/Y H:i') : '-' }}</td>
                            <td style="font-weight: 700; color: {{ $ins->estado === 'pagada' ? '#34d399' : ($ins->estado === 'pendiente' ? '#fbbf24' : '#f87171') }};">
                                Bs. {{ number_format($ins->monto_pagado, 2) }}
                            </td>
                            <td>
                                <div>{{ $ins->metodo_pago ?? 'Sin pago' }}</div>
                                @if($ins->comprobante)
                                    <div style="font-size: 0.75rem; color: var(--text-dim);">{{ $ins->comprobante }}</div>
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
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('inscripciones.show', $ins) }}" class="btn-modern btn-secondary" style="padding: 0.35rem 0.65rem; font-size: 0.8rem;">
                                        <i class="fa-solid fa-eye"></i> Recibo
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: var(--text-dim); padding: 2.5rem;">
                                No se encontraron inscripciones con el filtro seleccionado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 1.25rem;">
            {{ $inscripciones->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
