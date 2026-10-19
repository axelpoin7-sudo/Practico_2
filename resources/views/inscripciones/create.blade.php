@extends('layouts.app')

@section('title', 'Nueva Inscripción')

@section('content')
<div style="max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <div>
        <a href="{{ route('inscripciones.index') }}" style="color: var(--text-dim); text-decoration: none; font-size: 0.85rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver a inscripciones
        </a>
        <h1 style="font-size: 1.85rem; font-weight: 800; margin-top: 0.5rem; color: #ffffff;">Formulario de Inscripción</h1>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            El sistema valida en tiempo de ejecución las reglas de <strong>cupo disponible</strong> y <strong>no cruce de horario</strong>.
        </p>
    </div>

    <!-- Panel de Casos de Prueba Rápida de Integridad de Dominio -->
    <div class="glass-panel" style="padding: 1.25rem 1.75rem; border: 1px dashed var(--border-accent); background: rgba(30, 41, 59, 0.5);">
        <div style="font-size: 0.8rem; font-weight: 700; color: #38bdf8; text-transform: uppercase; margin-bottom: 0.5rem;">
            <i class="fa-solid fa-flask"></i> Pruebas Rápidas de Reglas de Negocio (Haz clic para autocompletar):
        </div>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <button type="button" onclick="cargarEscenarioLleno()" class="btn-modern btn-danger" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                <i class="fa-solid fa-ban"></i> Escenario 1: Probar Paralelo Lleno (PAR-OFI-01A)
            </button>
            <button type="button" onclick="cargarEscenarioCruce()" class="btn-modern btn-warning" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                <i class="fa-solid fa-calendar-xmark"></i> Escenario 2: Probar Horario Cruzado (08:00 - 10:00)
            </button>
        </div>
    </div>

    <div class="glass-panel" style="padding: 2.25rem;">
        <form action="{{ route('inscripciones.store') }}" method="POST" id="formInscripcion">
            @csrf

            <!-- 1. Participante -->
            <div class="form-group">
                <label class="form-label" for="participante_id">
                    <i class="fa-solid fa-user-graduate"></i> Seleccionar Participante *
                </label>
                <select name="participante_id" id="participante_id" class="form-select" required>
                    <option value="">-- Selecciona el alumno por Nombre o CI --</option>
                    @foreach($participantes as $p)
                        <option value="{{ $p->id }}" {{ (old('participante_id', $selectedParticipanteId) == $p->id) ? 'selected' : '' }} data-ci="{{ $p->documento_identidad }}">
                            {{ $p->nombre_completo }} (CI: {{ $p->documento_identidad }})
                        </option>
                    @endforeach
                </select>
                <small style="color: var(--text-dim); font-size: 0.75rem;">¿El participante no está registrado? <a href="{{ route('participantes.create') }}" style="color: var(--primary);">Registrarlo aquí</a></small>
            </div>

            <!-- 2. Paralelo -->
            <div class="form-group">
                <label class="form-label" for="paralelo_id">
                    <i class="fa-solid fa-calendar-days"></i> Seleccionar Paralelo de Curso *
                </label>
                <select name="paralelo_id" id="paralelo_id" class="form-select" onchange="actualizarDetallesParalelo()" required>
                    <option value="">-- Selecciona el curso y horario --</option>
                    @foreach($paralelos as $par)
                        <option value="{{ $par->id }}" 
                            {{ (old('paralelo_id', $selectedParaleloId) == $par->id) ? 'selected' : '' }}
                            data-costo="{{ $par->curso->costo ?? 0 }}"
                            data-codigo="{{ $par->codigo }}"
                            data-curso="{{ $par->curso->nombre ?? '' }}"
                            data-horario="{{ $par->dias }} ({{ substr($par->hora_inicio, 0, 5) }} - {{ substr($par->hora_fin, 0, 5) }})"
                            data-cupos-libres="{{ $par->cupos_disponibles }}"
                            data-cupo-max="{{ $par->cupo_maximo }}"
                            data-lleno="{{ $par->estaLleno() ? '1' : '0' }}">
                            [{{ $par->codigo }}] {{ $par->curso->nombre ?? 'Curso' }} - {{ $par->nombre }} ({{ $par->dias }} {{ substr($par->hora_inicio, 0, 5) }}-{{ substr($par->hora_fin, 0, 5) }}) 
                            — {{ $par->estaLleno() ? '⛔ ¡CUPO LLENO (0 libres)!' : '✓ ' . $par->cupos_disponibles . ' cupos libres' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tarjeta Informativa del Paralelo Seleccionado -->
            <div id="paraleloInfoBox" style="display: none; padding: 1.25rem; background: rgba(15, 23, 42, 0.7); border-radius: 12px; border: 1px solid var(--border-glass); margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                    <div>
                        <div id="infoCursoTitulo" style="font-size: 1.1rem; font-weight: 700; color: #ffffff;"></div>
                        <div id="infoHorario" style="font-size: 0.85rem; color: #38bdf8; margin-top: 0.25rem;"></div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-size: 0.75rem; color: var(--text-dim);">Disponibilidad</div>
                        <div id="infoCupoStatus" style="font-size: 1rem; font-weight: 700;"></div>
                    </div>
                </div>
            </div>

            <!-- 3. Pago y Estado -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="estado">Estado de la Inscripción *</label>
                    <select name="estado" id="estado" class="form-select" onchange="togglePagoFields()" required>
                        <option value="pagada" {{ old('estado', 'pagada') === 'pagada' ? 'selected' : '' }}>Pagada (Completa)</option>
                        <option value="pendiente" {{ old('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente de Pago</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="monto_pagado">Monto Abonado (Bs.) *</label>
                    <input type="number" step="0.5" name="monto_pagado" id="monto_pagado" class="form-control" value="{{ old('monto_pagado') }}" required>
                </div>
            </div>

            <div id="pagoCampos" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label" for="metodo_pago">Método de Pago</label>
                    <select name="metodo_pago" id="metodo_pago" class="form-select">
                        <option value="Transferencia QR" {{ old('metodo_pago') === 'Transferencia QR' ? 'selected' : '' }}>Transferencia QR</option>
                        <option value="Efectivo" {{ old('metodo_pago') === 'Efectivo' ? 'selected' : '' }}>Efectivo en Caja</option>
                        <option value="Tarjeta de Débito" {{ old('metodo_pago') === 'Tarjeta de Débito' ? 'selected' : '' }}>Tarjeta de Débito/Crédito</option>
                        <option value="Depósito Bancario" {{ old('metodo_pago') === 'Depósito Bancario' ? 'selected' : '' }}>Depósito Bancario</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="comprobante">Nro. de Comprobante / Transacción</label>
                    <input type="text" name="comprobante" id="comprobante" class="form-control" value="{{ old('comprobante') }}" placeholder="Ej. QR-891023 / REC-4512">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="observaciones">Observaciones adicionales</label>
                <textarea name="observaciones" id="observaciones" rows="2" class="form-control" placeholder="Anotaciones administrativas opcionales...">{{ old('observaciones') }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem; border-top: 1px solid var(--border-glass); padding-top: 1.5rem;">
                <a href="{{ route('inscripciones.index') }}" class="btn-modern btn-secondary">Cancelar</a>
                <button type="submit" class="btn-modern btn-primary">
                    <i class="fa-solid fa-check-circle"></i> Confirmar Inscripción
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function actualizarDetallesParalelo() {
        const select = document.getElementById('paralelo_id');
        const selected = select.options[select.selectedIndex];
        const infoBox = document.getElementById('paraleloInfoBox');

        if (!selected || !selected.value) {
            infoBox.style.display = 'none';
            return;
        }

        infoBox.style.display = 'block';
        document.getElementById('infoCursoTitulo').innerText = selected.getAttribute('data-curso');
        document.getElementById('infoHorario').innerHTML = '<i class="fa-solid fa-clock"></i> ' + selected.getAttribute('data-horario');

        const esLleno = selected.getAttribute('data-lleno') === '1';
        const libres = selected.getAttribute('data-cupos-libres');
        const total = selected.getAttribute('data-cupo-max');
        const statusEl = document.getElementById('infoCupoStatus');

        if (esLleno) {
            statusEl.innerHTML = '<span style="color: #ef4444;"><i class="fa-solid fa-ban"></i> LLENO (0/' + total + ')</span>';
            infoBox.style.border = '1px solid rgba(239, 68, 68, 0.5)';
        } else {
            statusEl.innerHTML = '<span style="color: #34d399;"><i class="fa-solid fa-check"></i> ' + libres + ' disponibles de ' + total + '</span>';
            infoBox.style.border = '1px solid rgba(16, 185, 129, 0.4)';
        }

        // Autocompletar costo
        const costo = selected.getAttribute('data-costo');
        const montoInput = document.getElementById('monto_pagado');
        if (costo && (!montoInput.value || montoInput.value === '0')) {
            montoInput.value = costo;
        }
    }

    function togglePagoFields() {
        const estado = document.getElementById('estado').value;
        const pagoCampos = document.getElementById('pagoCampos');
        const montoInput = document.getElementById('monto_pagado');

        if (estado === 'pendiente') {
            montoInput.value = '0.00';
        } else {
            const select = document.getElementById('paralelo_id');
            const selected = select.options[select.selectedIndex];
            if (selected && selected.getAttribute('data-costo')) {
                montoInput.value = selected.getAttribute('data-costo');
            }
        }
    }

    // Escenarios automáticos de prueba para el profesor / revisor
    function cargarEscenarioLleno() {
        // Seleccionar participante libre (ej. Diego Fernando Flores CI: 50697889)
        const partSelect = document.getElementById('participante_id');
        for (let i = 0; i < partSelect.options.length; i++) {
            if (partSelect.options[i].text.includes('50697889')) {
                partSelect.selectedIndex = i;
                break;
            }
        }

        // Seleccionar el paralelo lleno PAR-OFI-01A
        const parSelect = document.getElementById('paralelo_id');
        for (let i = 0; i < parSelect.options.length; i++) {
            if (parSelect.options[i].text.includes('PAR-OFI-01A')) {
                parSelect.selectedIndex = i;
                break;
            }
        }
        actualizarDetallesParalelo();
    }

    function cargarEscenarioCruce() {
        // Alejandro Torrez (CI: 10293847) ya está en PAR-OFI-01A (Lun-Mie-Vie 08:00 - 10:00)
        // Intentaremos inscribirlo en PAR-PRG-01A (Lun-Mie-Vie 08:00 - 10:00)
        const partSelect = document.getElementById('participante_id');
        for (let i = 0; i < partSelect.options.length; i++) {
            if (partSelect.options[i].text.includes('10293847')) {
                partSelect.selectedIndex = i;
                break;
            }
        }

        const parSelect = document.getElementById('paralelo_id');
        for (let i = 0; i < parSelect.options.length; i++) {
            if (parSelect.options[i].text.includes('PAR-PRG-01A')) {
                parSelect.selectedIndex = i;
                break;
            }
        }
        actualizarDetallesParalelo();
    }

    // Ejecutar al cargar por si hay valores preseleccionados
    document.addEventListener('DOMContentLoaded', function() {
        actualizarDetallesParalelo();
    });
</script>
@endpush
