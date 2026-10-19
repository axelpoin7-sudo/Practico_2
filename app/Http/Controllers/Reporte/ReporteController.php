<?php

namespace App\Http\Controllers\Reporte;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Services\Reporte\ReporteService;

class ReporteController extends Controller
{
    public function __construct(
        protected ReporteService $reporteService
    ) {}

    /**
     * Reporte de ingresos por curso.
     */
    public function ingresos()
    {
        $reporte = $this->reporteService->ingresosPorCurso();

        $totales = [
            'total_cursos' => $reporte->count(),
            'total_paralelos' => $reporte->sum('total_paralelos'),
            'total_cupos' => $reporte->sum('total_cupos'),
            'cupos_ocupados' => $reporte->sum('cupos_ocupados'),
            'inscripciones_pagadas' => $reporte->sum('inscripciones_pagadas'),
            'inscripciones_pendientes' => $reporte->sum('inscripciones_pendientes'),
            'inscripciones_anuladas' => $reporte->sum('inscripciones_anuladas'),
            'ingresos_recaudados' => $reporte->sum('ingresos_recaudados'),
            'ingresos_proyectados' => $reporte->sum('ingresos_proyectados'),
        ];

        return view('reportes.ingresos', compact('reporte', 'totales'));
    }

    /**
     * Vista interactiva de las 10 Consultas de Tinker de la Actividad 2.
     */
    public function tinker()
    {
        $jsonPath = storage_path('app/tinker_actividad2.json');
        $consultas = file_exists($jsonPath) ? json_decode(file_get_contents($jsonPath), true) : [];

        return view('reportes.tinker', compact('consultas'));
    }
}
