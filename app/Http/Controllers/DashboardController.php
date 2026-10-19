<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Services\Reporte\ReporteService;

class DashboardController extends Controller
{
    public function __construct(
        protected ReporteService $reporteService
    ) {}

    public function index()
    {
        $metricas = $this->reporteService->metricasDashboard();
        $ultimasInscripciones = Inscripcion::with(['participante', 'paralelo.curso'])
            ->latest()
            ->take(8)
            ->get();

        $categorias = Categoria::withCount(['cursos', 'paralelos'])->get();
        $cursosDestacados = Curso::with(['categoria', 'instructor'])
            ->withCount(['paralelos', 'inscripciones'])
            ->take(6)
            ->get();

        return view('dashboard.index', compact('metricas', 'ultimasInscripciones', 'categorias', 'cursosDestacados'));
    }
}
