@extends('layouts.app')

@section('title', 'Expediente: ' . $participante->nombre_completo)

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <div>
        <a href="{{ route('participantes.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a participantes
        </a>
    </div>

    <!-- Header Participante -->
    <div class="glass-panel" style="padding: 2rem; display: flex; gap: 2rem; align-items: center; flex-wrap: wrap;">
        <div style="width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg, #10b981, #38bdf8); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 800; color: #ffffff;">
            {{ substr($participante->nombres, 0, 1) }}{{ substr($participante->apellidos, 0, 1) }}
        </div>
        <div style="flex: 1;">
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin-bottom: 0.25rem;">
                {{ $participante->nombre_completo }}
            </h1>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap; font-size: 0.875rem; color: var(--text-muted);">
                <span><i class="fa-solid fa-id-card"></i> CI: <strong style="color: #ffffff;">{{ $participante->documento_identidad }}</strong></span>
                <span><i class="fa-solid fa-envelope"></i> {{ $participante->email }}</span>
                <span><i class="fa-solid fa-phone"></i> {{ $participante->telefono }}</span>
                @if($participante->direccion)
                    <span><i class="fa-solid fa-location-dot"></i> {{ $participante->direccion }}</span>
                @endif
            </div>
        </div>
        <div>
            <a href="{{ route('inscripciones.create', ['participante_id' => $participante->id]) }}" class="btn-modern btn-primary">
                <i class="fa-solid fa-plus-circle"></i> Inscribir a Paralelo
            </a>
        </div>
    </div>

    <!-- Historial de Inscripciones y Cursos -->
    <div class="glass-panel" style="padding: 1.75rem;">
        <h2 style="font-size: 1.35rem; font-weight: 700; margin-bottom: 1.25rem;">
            Historial de Inscripciones en Paralelos ({{ $participante->inscripciones->count() }})
        </h2>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Código Inscripción</th>
                        <th>Curso</th>
                        <th>Paralelo & Horario</th>
                        <th>Aula</th>
                        <th>Monto Pagado</th>
                        <th>Estado</th>
                        <th>Fecha Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participante->inscripciones as $ins)
                        <tr>
                            <td><code>{{ $ins->codigo }}</code></td>
                            <td>
                                <strong style="color: #ffffff;">{{ $ins->paralelo->curso->nombre ?? 'N/A' }}</strong>
                                <div style="font-size: 0.75rem; color: var(--text-dim);">{{ $ins->paralelo->curso->categoria->nombre ?? '' }}</div>
                            </td>
                            <td>
                                <div>{{ $ins->paralelo->nombre ?? 'N/A' }}</div>
                                <div style="font-size: 0.75rem; color: #38bdf8;">
                                    <i class="fa-solid fa-clock"></i> {{ $ins->paralelo->dias ?? '' }} ({{ substr($ins->paralelo->hora_inicio ?? '', 0, 5) }} - {{ substr($ins->paralelo->hora_fin ?? '', 0, 5) }})
                                </div>
                            </td>
                            <td>{{ $ins->paralelo->aula ?? 'N/A' }}</td>
                            <td style="font-weight: 700; color: {{ $ins->estado === 'pagada' ? '#34d399' : '#fbbf24' }};">
                                Bs. {{ number_format($ins->monto_pagado, 2) }}
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
                            <td>{{ $ins->fecha_inscripcion ? $ins->fecha_inscripcion->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-dim); padding: 2rem;">
                                El participante no registra inscripciones aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
