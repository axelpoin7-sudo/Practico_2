<?php

namespace App\Services\Inscripcion;

use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InscripcionService
{
    /**
     * Valida y procesa una nueva inscripción en un paralelo.
     * Aplica las reglas de negocio de:
     * 1. Cupo máximo disponible.
     * 2. Conflicto de horario cruzado con otros paralelos activos del participante.
     * 3. Prevención de inscripción duplicada en el mismo paralelo.
     *
     * @throws ValidationException
     */
    public function inscribir(array $datos): Inscripcion
    {
        return DB::transaction(function () use ($datos) {
            $participanteId = $datos['participante_id'];
            $paraleloId = $datos['paralelo_id'];

            $paralelo = Paralelo::with('curso')->findOrFail($paraleloId);
            $participante = Participante::findOrFail($participanteId);

            // 1. Validar si ya está inscrito en el mismo paralelo
            $yaInscrito = Inscripcion::where('participante_id', $participanteId)
                ->where('paralelo_id', $paraleloId)
                ->whereIn('estado', ['pendiente', 'pagada'])
                ->exists();

            if ($yaInscrito) {
                throw ValidationException::withMessages([
                    'paralelo_id' => [
                        "El participante {$participante->nombre_completo} ya tiene una inscripción activa en el paralelo {$paralelo->nombre} ({$paralelo->codigo}).",
                    ],
                ]);
            }

            // 2. REGLA DE NEGOCIO: Cupo máximo del paralelo
            if ($paralelo->estaLleno()) {
                throw ValidationException::withMessages([
                    'paralelo_id' => [
                        "Inscripción rechazada: El paralelo {$paralelo->nombre} ({$paralelo->codigo}) está lleno. Cupo máximo alcanzado ({$paralelo->cupos_ocupados}/{$paralelo->cupo_maximo}).",
                    ],
                ]);
            }

            // 3. REGLA DE NEGOCIO: Horario cruzado con otro paralelo activo
            $conflicto = $participante->obtenerConflictoConParalelo($paralelo);
            if ($conflicto) {
                $cursoNombre = $conflicto->curso ? $conflicto->curso->nombre : 'Curso';
                throw ValidationException::withMessages([
                    'paralelo_id' => [
                        "Inscripción rechazada por horario cruzado: El participante {$participante->nombre_completo} ya está inscrito en '{$cursoNombre}' ({$conflicto->nombre} - {$conflicto->codigo}), cuyo horario ({$conflicto->dias} {$conflicto->hora_inicio} a {$conflicto->hora_fin}) se cruza con el paralelo seleccionado ({$paralelo->dias} {$paralelo->hora_inicio} a {$paralelo->hora_fin}).",
                    ],
                ]);
            }

            // 4. Registrar inscripción
            $monto = isset($datos['monto_pagado']) ? (float) $datos['monto_pagado'] : (float) $paralelo->curso->costo;
            $estado = $datos['estado'] ?? 'pagada';

            return Inscripcion::create([
                'codigo' => $datos['codigo'] ?? null,
                'participante_id' => $participante->id,
                'paralelo_id' => $paralelo->id,
                'fecha_inscripcion' => $datos['fecha_inscripcion'] ?? now(),
                'monto_pagado' => $monto,
                'estado' => $estado,
                'metodo_pago' => $datos['metodo_pago'] ?? ($estado === 'pagada' ? 'Efectivo' : null),
                'comprobante' => $datos['comprobante'] ?? null,
                'observaciones' => $datos['observaciones'] ?? null,
            ]);
        });
    }

    /**
     * Anula una inscripción y libera el cupo.
     */
    public function anular(Inscripcion $inscripcion, ?string $motivo = null): Inscripcion
    {
        $inscripcion->update([
            'estado' => 'anulada',
            'observaciones' => trim(($inscripcion->observaciones ?? '').' [ANULADA: '.($motivo ?? 'Por solicitud del estudiante').' el '.now()->toDateTimeString().']'),
        ]);

        return $inscripcion;
    }

    /**
     * Confirma el pago de una inscripción pendiente.
     */
    public function registrarPago(Inscripcion $inscripcion, float $monto, string $metodoPago, ?string $comprobante = null): Inscripcion
    {
        $inscripcion->update([
            'monto_pagado' => $monto,
            'estado' => 'pagada',
            'metodo_pago' => $metodoPago,
            'comprobante' => $comprobante,
        ]);

        return $inscripcion;
    }
}
