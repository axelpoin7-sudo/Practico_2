<?php

namespace App\Http\Controllers\Paralelo;

use App\Http\Controllers\Controller;
use App\Models\Curso;
use App\Models\Instructor;
use App\Models\Paralelo;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    public function index(Request $request)
    {
        $cursoId = $request->query('curso_id');
        $query = Paralelo::with(['curso.categoria', 'instructor', 'inscripciones']);

        if ($cursoId) {
            $query->where('curso_id', $cursoId);
        }

        $paralelos = $query->latest()->get();
        $cursos = Curso::activos()->get();

        return view('paralelos.index', compact('paralelos', 'cursos', 'cursoId'));
    }

    public function create(Request $request)
    {
        $cursos = Curso::activos()->get();
        $instructores = Instructor::activos()->get();
        $selectedCursoId = $request->query('curso_id');

        return view('paralelos.create', compact('cursos', 'instructores', 'selectedCursoId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'instructor_id' => 'nullable|exists:instructores,id',
            'codigo' => 'required|string|max:30|unique:paralelos,codigo',
            'nombre' => 'required|string|max:100',
            'aula' => 'required|string|max:80',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'dias' => 'required|string|max:100',
            'dias_semana' => 'required|string|max:120',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'cupo_maximo' => 'required|integer|min:1|max:100',
            'estado' => 'required|in:abierto,en_curso,cerrado,finalizado',
        ]);

        if (empty($validated['instructor_id'])) {
            $curso = Curso::find($validated['curso_id']);
            $validated['instructor_id'] = $curso->instructor_id;
        }

        Paralelo::create($validated);

        return redirect()->route('paralelos.index')->with('success', 'Paralelo creado exitosamente.');
    }

    public function show(Paralelo $paralelo)
    {
        $paralelo->load(['curso.categoria', 'instructor', 'inscripciones.participante']);

        return view('paralelos.show', compact('paralelo'));
    }

    /**
     * Emite la lista detallada de inscritos por paralelo.
     */
    public function inscritos(Paralelo $paralelo)
    {
        $paralelo->load([
            'curso.categoria',
            'instructor',
            'inscripciones.participante',
        ]);

        $inscripciones = $paralelo->inscripciones()
            ->with('participante')
            ->orderBy('fecha_inscripcion', 'asc')
            ->get();

        $totales = [
            'total' => $inscripciones->count(),
            'pagadas' => $inscripciones->where('estado', 'pagada')->count(),
            'pendientes' => $inscripciones->where('estado', 'pendiente')->count(),
            'anuladas' => $inscripciones->where('estado', 'anulada')->count(),
            'total_recaudado' => $inscripciones->where('estado', 'pagada')->sum('monto_pagado'),
        ];

        return view('paralelos.inscritos', compact('paralelo', 'inscripciones', 'totales'));
    }
}
