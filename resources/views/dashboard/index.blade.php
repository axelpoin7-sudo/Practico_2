@extends('layouts.app')

@section('title', 'Panel General')

@section('content')
<div style="display: flex; flex-direction: column; gap: 2rem;">
    <!-- Welcome Hero Banner -->
    <div class="glass-panel" style="padding: 2.25rem; background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(15, 23, 42, 0.95) 100%); position: relative; overflow: hidden; border: 1px solid var(--border-accent);">
        <div style="position: absolute; right: -20px; top: -30px; font-size: 15rem; color: rgba(56, 189, 248, 0.03); pointer-events: none;">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <div style="max-width: 800px; position: relative; z-index: 10;">
            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.75rem;">
                <span class="badge badge-info"><i class="fa-solid fa-code-branch"></i> Laravel 11 + Eloquent</span>
                <span class="badge badge-success"><i class="fa-solid fa-shield-halved"></i> Integridad Referencial Activa</span>
            </div>
            <h1 style="font-size: 2.25rem; font-weight: 800; line-height: 1.2; margin-bottom: 0.75rem;">
                Plataforma de Inscripción a <span style="background: linear-gradient(90deg, #38bdf8, #818cf8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Cursos de Capacitación</span>
            </h1>
            <p style="color: var(--text-muted); font-size: 1rem; line-height: 1.6; margin-bottom: 1.5rem;">
                Centro integral de formación en <strong>Ofimática</strong>, <strong>Programación</strong> y <strong>Diseño</strong>. Sistema validado contra sobrecupo, detección automática de conflicto de horarios cruzados y reportes financieros por curso.
            </p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-primary">
                    <i class="fa-solid fa-user-plus"></i> Inscribir Participante
                </a>
                <a href="{{ route('reportes.ingresos') }}" class="btn-modern btn-secondary">
                    <i class="fa-solid fa-chart-column"></i> Ver Reporte de Ingresos
                </a>
                <a href="{{ route('reportes.tinker') }}" class="btn-modern btn-accent">
                    <i class="fa-solid fa-terminal"></i> 10 Consultas Tinker (Actividad 2)
                </a>
            </div>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 1.25rem;">
        <!-- Ingresos Recaudados -->
        <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-coins" style="font-size: 1.5rem; color: #10b981;"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase;">Ingresos Recaudados</div>
                <div style="font-size: 1.65rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                    Bs. {{ number_format($metricas['total_ingresos'], 2) }}
                </div>
                <div style="font-size: 0.75rem; color: #34d399;"><i class="fa-solid fa-check"></i> Inscripciones pagadas</div>
            </div>
        </div>

        <!-- Inscripciones Activas -->
        <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-user-check" style="font-size: 1.5rem; color: #38bdf8;"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase;">Inscritos Activos</div>
                <div style="font-size: 1.65rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                    {{ $metricas['total_inscritos'] }}
                </div>
                <div style="font-size: 0.75rem; color: #7dd3fc;">En {{ $metricas['total_paralelos'] }} paralelos abiertos</div>
            </div>
        </div>

        <!-- Catálogo de Cursos -->
        <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-graduation-cap" style="font-size: 1.5rem; color: #a855f7;"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase;">Cursos Ofertados</div>
                <div style="font-size: 1.65rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                    {{ $metricas['total_cursos'] }}
                </div>
                <div style="font-size: 0.75rem; color: #c084fc;">En 3 categorías oficiales</div>
            </div>
        </div>

        <!-- Participantes Registrados -->
        <div class="glass-panel" style="padding: 1.5rem; display: flex; align-items: center; gap: 1.25rem;">
            <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-users" style="font-size: 1.5rem; color: #f59e0b;"></i>
            </div>
            <div>
                <div style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500; text-transform: uppercase;">Participantes</div>
                <div style="font-size: 1.65rem; font-weight: 800; color: #ffffff; font-family: 'Outfit';">
                    {{ $metricas['total_participantes'] }}
                </div>
                <div style="font-size: 0.75rem; color: #fbbf24;">Base de datos alumnos</div>
            </div>
        </div>
    </div>

    <!-- Reglas de Negocio en Acción: Probetas Interactivas -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <div class="glass-panel" style="padding: 1.75rem; border-left: 4px solid #ef4444;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                <span class="badge badge-danger"><i class="fa-solid fa-ban"></i> Regla de Negocio 1</span>
                <span style="font-size: 0.8rem; color: var(--text-dim);">Límite de Capacidad</span>
            </div>
            <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">Control de Paralelo Lleno</h3>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.5;">
                El sistema bloquea automáticamente cualquier inscripción cuando los inscritos activos alcanzan el <strong>cupo máximo</strong> definido para el paralelo.
            </p>
            <div style="padding: 0.75rem; background: rgba(239, 68, 68, 0.08); border-radius: 8px; border: 1px dashed rgba(239, 68, 68, 0.3); font-size: 0.8rem; margin-bottom: 1rem;">
                <strong>Paralelo de prueba:</strong> <code>PAR-OFI-01A</code> (Excel Avanzado) se encuentra con cupo lleno (4/4 estudiantes).
            </div>
            <a href="{{ route('paralelos.inscritos', 1) }}" class="btn-modern btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="fa-solid fa-list-ol"></i> Ver Lista de Inscritos del Paralelo Lleno
            </a>
        </div>

        <div class="glass-panel" style="padding: 1.75rem; border-left: 4px solid #f59e0b;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                <span class="badge badge-warning"><i class="fa-solid fa-calendar-xmark"></i> Regla de Negocio 2</span>
                <span style="font-size: 0.8rem; color: var(--text-dim);">Conflicto Horario</span>
            </div>
            <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem; color: #ffffff;">Prevención de Horarios Cruzados</h3>
            <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 1rem; line-height: 1.5;">
                Si un participante intenta inscribirse a dos paralelos en el mismo rango de fechas que compartan días y coincidan en sus horas, la solicitud se rechaza con alerta detallada.
            </p>
            <div style="padding: 0.75rem; background: rgba(245, 158, 11, 0.08); border-radius: 8px; border: 1px dashed rgba(245, 158, 11, 0.3); font-size: 0.8rem; margin-bottom: 1rem;">
                <strong>Paralelos en conflicto:</strong> <code>PAR-OFI-01A</code> y <code>PAR-PRG-01A</code> (Lun-Mié-Vie 08:00 a 10:00).
            </div>
            <a href="{{ route('inscripciones.create') }}" class="btn-modern btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                <i class="fa-solid fa-vial"></i> Probar Formulario de Validación
            </a>
        </div>
    </div>

    <!-- Categorías Oficiales -->
    <div>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h2 style="font-size: 1.35rem; font-weight: 700;">Categorías de Capacitación</h2>
                <p style="font-size: 0.875rem; color: var(--text-muted);">Áreas de especialidad formativa ofertadas</p>
            </div>
            <a href="{{ route('categorias.index') }}" style="color: var(--primary); text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                Ver todas <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            @foreach($categorias as $cat)
                <div class="glass-panel" style="padding: 1.5rem; border-top: 4px solid {{ $cat->color }};">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                        <div style="width: 44px; height: 44px; border-radius: 12px; background: {{ $cat->color }}25; display: flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-{{ $cat->icono ?? 'folder' }}" style="color: {{ $cat->color }}; font-size: 1.25rem;"></i>
                        </div>
                        <span class="badge" style="background: {{ $cat->color }}20; color: {{ $cat->color }}; border: 1px solid {{ $cat->color }}40;">
                            {{ $cat->cursos_count }} Cursos
                        </span>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $cat->nombre }}</h3>
                    <p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 1rem;">
                        {{ Str::limit($cat->descripcion, 95) }}
                    </p>
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-glass); padding-top: 0.75rem; font-size: 0.8rem; color: var(--text-dim);">
                        <span><i class="fa-solid fa-calendar-check"></i> {{ $cat->paralelos_count }} Paralelos</span>
                        <a href="{{ route('cursos.index', ['categoria_id' => $cat->id]) }}" style="color: {{ $cat->color }}; text-decoration: none; font-weight: 600;">
                            Explorar cursos &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Últimas Inscripciones Registradas -->
    <div class="glass-panel" style="padding: 1.75rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 700;">Últimas Inscripciones Registradas</h2>
                <p style="font-size: 0.85rem; color: var(--text-muted);">Movimientos recientes en los paralelos de formación</p>
            </div>
            <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-secondary" style="font-size: 0.8rem; padding: 0.5rem 1rem;">
                Ver Todas las Inscripciones
            </a>
        </div>

        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Participante</th>
                        <th>Curso & Paralelo</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimasInscripciones as $ins)
                        <tr>
                            <td><code>{{ $ins->codigo }}</code></td>
                            <td>
                                <div style="font-weight: 600; color: #ffffff;">{{ $ins->participante->nombre_completo ?? 'N/A' }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-dim);">CI: {{ $ins->participante->documento_identidad ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 500;">{{ $ins->paralelo->curso->nombre ?? 'N/A' }}</div>
                                <div style="font-size: 0.75rem; color: var(--primary);">
                                    <i class="fa-solid fa-clock"></i> {{ $ins->paralelo->nombre ?? 'N/A' }} ({{ $ins->paralelo->dias ?? '' }})
                                </div>
                            </td>
                            <td>{{ $ins->fecha_inscripcion ? $ins->fecha_inscripcion->format('d/m/Y H:i') : '-' }}</td>
                            <td style="font-weight: 700;">Bs. {{ number_format($ins->monto_pagado, 2) }}</td>
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
                                <a href="{{ route('inscripciones.show', $ins) }}" style="color: var(--primary); text-decoration: none; font-weight: 600; font-size: 0.85rem;">
                                    <i class="fa-solid fa-eye"></i> Detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; color: var(--text-dim); padding: 2rem;">
                                No se registran inscripciones aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
