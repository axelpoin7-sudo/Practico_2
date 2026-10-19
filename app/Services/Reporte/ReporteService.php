<?php

namespace App\Services\Reporte;

use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Illuminate\Support\Collection;

class ReporteService
{
    /**
     * Reporte consolidado de ingresos por curso.
     * Retorna detalles por curso:
     * - Número de paralelos
     * - Total inscripciones
     * - Inscripciones pagadas, pendientes y anuladas
     * - Ingresos recaudados reales (pagadas)
     * - Ingresos potenciales/proyectados
     * - Tasa de recaudación
     */
    public function ingresosPorCurso(): Collection
    {
        return Curso::with(['categoria', 'instructor', 'paralelos.inscripciones'])
            ->get()
            ->map(function (Curso $curso) {
                $todasInscripciones = $curso->paralelos->flatMap(fn ($p) => $p->inscripciones);

                $totalInscritos = $todasInscripciones->count();
                $pagadas = $todasInscripciones->where('estado', 'pagada');
                $pendientes = $todasInscripciones->where('estado', 'pendiente');
                $anuladas = $todasInscripciones->where('estado', 'anulada');

                $recaudado = (float) $pagadas->sum('monto_pagado');
                $montoPendiente = (float) $pendientes->count() * (float) $curso->costo;
                $proyectado = $recaudado + $montoPendiente;

                $totalCupos = $curso->paralelos->sum('cupo_maximo');
                $cuposOcupados = $curso->paralelos->sum(fn ($p) => $p->cupos_ocupados);
                $porcentajeOcupacion = $totalCupos > 0 ? round(($cuposOcupados / $totalCupos) * 100, 1) : 0;

                return [
                    'curso_id' => $curso->id,
                    'codigo' => $curso->codigo,
                    'nombre' => $curso->nombre,
                    'categoria' => $curso->categoria ? $curso->categoria->nombre : 'Sin categoría',
                    'categoria_color' => $curso->categoria ? $curso->categoria->color : '#3b82f6',
                    'instructor' => $curso->instructor ? $curso->instructor->nombre_completo : 'Sin instructor',
                    'costo' => (float) $curso->costo,
                    'total_paralelos' => $curso->paralelos->count(),
                    'total_cupos' => $totalCupos,
                    'cupos_ocupados' => $cuposOcupados,
                    'porcentaje_ocupacion' => $porcentajeOcupacion,
                    'total_inscripciones' => $totalInscritos,
                    'inscripciones_pagadas' => $pagadas->count(),
                    'inscripciones_pendientes' => $pendientes->count(),
                    'inscripciones_anuladas' => $anuladas->count(),
                    'ingresos_recaudados' => $recaudado,
                    'ingresos_proyectados' => $proyectado,
                ];
            });
    }

    /**
     * Estadísticas generales del centro de capacitación para el dashboard.
     */
    public function metricasDashboard(): array
    {
        $totalIngresos = (float) Inscripcion::pagadas()->sum('monto_pagado');
        $totalPendiente = (float) Inscripcion::pendientes()->count() * 250; // promedio
        $totalInscritos = Inscripcion::activas()->count();
        $totalParticipantes = Participante::count();
        $totalCursos = Curso::activos()->count();
        $totalParalelos = Paralelo::count();

        return [
            'total_ingresos' => $totalIngresos,
            'total_pendiente' => $totalPendiente,
            'total_inscritos' => $totalInscritos,
            'total_participantes' => $totalParticipantes,
            'total_cursos' => $totalCursos,
            'total_paralelos' => $totalParalelos,
        ];
    }
}
