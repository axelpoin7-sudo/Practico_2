@extends('layouts.app')

@section('title', 'Comprobante de Inscripción: ' . $inscripcion->codigo)

@section('content')
<div style="max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <a href="{{ route('inscripciones.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a inscripciones
        </a>
        <button onclick="window.print()" class="btn-modern btn-secondary" style="font-size: 0.85rem; padding: 0.4rem 0.85rem;">
            <i class="fa-solid fa-print"></i> Imprimir Comprobante
        </button>
    </div>

    <!-- Comprobante Card -->
    <div class="glass-panel" style="padding: 2.5rem; border-top: 6px solid {{ $inscripcion->estado === 'pagada' ? '#10b981' : ($inscripcion->estado === 'pendiente' ? '#f59e0b' : '#ef4444') }};">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2rem; border-bottom: 1px solid var(--border-glass); padding-bottom: 1.5rem;">
            <div>
                <div style="font-size: 0.8rem; color: var(--text-dim); text-transform: uppercase; letter-spacing: 0.05em;">Comprobante Oficial de Inscripción</div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                    {{ $inscripcion->codigo }}
                </h1>
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    Fecha de emisión: {{ $inscripcion->fecha_inscripcion ? $inscripcion->fecha_inscripcion->format('d/m/Y H:i:s') : now()->format('d/m/Y H:i') }}
                </div>
            </div>

            <div>
                @if($inscripcion->estado === 'pagada')
                    <span class="badge badge-success" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <i class="fa-solid fa-circle-check"></i> Pagada
                    </span>
                @elseif($inscripcion->estado === 'pendiente')
                    <span class="badge badge-warning" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <i class="fa-solid fa-clock"></i> Pendiente de Pago
                    </span>
                @else
                    <span class="badge badge-danger" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <i class="fa-solid fa-ban"></i> Anulada
                    </span>
                @endif
            </div>
        </div>

        <!-- Datos del Participante -->
        <div style="margin-bottom: 1.75rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; color: #38bdf8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                <i class="fa-solid fa-user-graduate"></i> Datos del Alumno Inscrito
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; background: rgba(15, 23, 42, 0.5); padding: 1.25rem; border-radius: 10px; border: 1px solid var(--border-glass);">
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Nombre Completo</div>
                    <div style="font-weight: 700; color: #ffffff;">{{ $inscripcion->participante->nombre_completo ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Documento de Identidad</div>
                    <div style="font-weight: 700; color: #ffffff;">{{ $inscripcion->participante->documento_identidad ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Correo Electrónico</div>
                    <div style="font-weight: 500; color: #ffffff;">{{ $inscripcion->participante->email ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Teléfono</div>
                    <div style="font-weight: 500; color: #ffffff;">{{ $inscripcion->participante->telefono ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Datos del Curso y Paralelo -->
        <div style="margin-bottom: 2rem;">
            <h3 style="font-size: 0.85rem; font-weight: 700; color: #818cf8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                <i class="fa-solid fa-book-open"></i> Curso y Paralelo Asignado
            </h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; background: rgba(15, 23, 42, 0.5); padding: 1.25rem; border-radius: 10px; border: 1px solid var(--border-glass);">
                <div style="grid-column: 1 / -1;">
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Curso</div>
                    <div style="font-size: 1.15rem; font-weight: 800; color: #ffffff;">{{ $inscripcion->paralelo->curso->nombre ?? 'N/A' }}</div>
                    <div style="font-size: 0.8rem; color: var(--primary);">Categoría: {{ $inscripcion->paralelo->curso->categoria->nombre ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Paralelo</div>
                    <div style="font-weight: 700; color: #ffffff;">{{ $inscripcion->paralelo->nombre ?? 'N/A' }} ({{ $inscripcion->paralelo->codigo ?? '' }})</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Horario & Días</div>
                    <div style="font-weight: 700; color: #38bdf8;">{{ $inscripcion->paralelo->dias ?? '' }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ substr($inscripcion->paralelo->hora_inicio ?? '', 0, 5) }} a {{ substr($inscripcion->paralelo->hora_fin ?? '', 0, 5) }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Aula / Salón</div>
                    <div style="font-weight: 700; color: #ffffff;">{{ $inscripcion->paralelo->aula ?? 'N/A' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.75rem; color: var(--text-dim);">Instructor Responsable</div>
                    <div style="font-weight: 700; color: #ffffff;">{{ $inscripcion->paralelo->instructor->nombre_completo ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Liquidación de Pago -->
        <div style="border-top: 1px dashed var(--border-glass); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="font-size: 0.8rem; color: var(--text-dim);">Método de Pago: <strong style="color: #ffffff;">{{ $inscripcion->metodo_pago ?? 'Pendiente' }}</strong></div>
                @if($inscripcion->comprobante)
                    <div style="font-size: 0.8rem; color: var(--text-dim);">Nro. Transacción: <strong style="color: #ffffff;">{{ $inscripcion->comprobante }}</strong></div>
                @endif
                @if($inscripcion->observaciones)
                    <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">Notas: {{ $inscripcion->observaciones }}</div>
                @endif
            </div>

            <div style="text-align: right;">
                <span style="font-size: 0.85rem; color: var(--text-dim);">Monto Registrado</span>
                <div style="font-size: 2.25rem; font-weight: 800; color: {{ $inscripcion->estado === 'pagada' ? '#34d399' : '#fbbf24' }}; font-family: 'Outfit';">
                    Bs. {{ number_format($inscripcion->monto_pagado, 2) }}
                </div>
            </div>
        </div>

        <!-- Acciones Administrativas -->
        <div style="margin-top: 2rem; border-top: 1px solid var(--border-glass); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                @if($inscripcion->estado !== 'anulada')
                    <form action="{{ route('inscripciones.anular', $inscripcion) }}" method="POST" onsubmit="return confirm('¿Confirma que desea anular esta inscripción? Esta acción liberará el cupo en el paralelo.');">
                        @csrf
                        <button type="submit" class="btn-modern btn-danger" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i class="fa-solid fa-ban"></i> Anular Inscripción (Liberar Cupo)
                        </button>
                    </form>
                @endif
            </div>

            <div>
                @if($inscripcion->estado === 'pendiente')
                    <form action="{{ route('inscripciones.pagar', $inscripcion) }}" method="POST" style="display: flex; gap: 0.5rem; align-items: center;">
                        @csrf
                        <input type="hidden" name="monto_pagado" value="{{ $inscripcion->paralelo->curso->costo ?? 250 }}">
                        <input type="hidden" name="metodo_pago" value="Transferencia QR">
                        <input type="hidden" name="comprobante" value="REG-{{ rand(10000, 99999) }}">
                        <button type="submit" class="btn-modern btn-success" style="font-size: 0.85rem;">
                            <i class="fa-solid fa-check-circle"></i> Confirmar Pago Completo
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
