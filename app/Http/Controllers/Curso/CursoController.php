<?php

namespace App\Http\Controllers\Curso;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Instructor;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index(Request $request)
    {
        $categoriaId = $request->query('categoria_id');
        $query = Curso::with(['categoria', 'instructor'])
            ->withCount(['paralelos', 'inscripciones']);

        if ($categoriaId) {
            $query->where('categoria_id', $categoriaId);
        }

        $cursos = $query->get();
        $categorias = Categoria::activas()->get();

        return view('cursos.index', compact('cursos', 'categorias', 'categoriaId'));
    }

    public function create()
    {
        $categorias = Categoria::activas()->get();
        $instructores = Instructor::activos()->get();

        return view('cursos.create', compact('categorias', 'instructores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'instructor_id' => 'required|exists:instructores,id',
            'codigo' => 'required|string|max:30|unique:cursos,codigo',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'costo' => 'required|numeric|min:0',
            'duracion_horas' => 'required|integer|min:1',
            'nivel' => 'required|in:Básico,Intermedio,Avanzado',
        ]);

        $validated['activo'] = true;

        Curso::create($validated);

        return redirect()->route('cursos.index')->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso)
    {
        $curso->load([
            'categoria',
            'instructor',
            'paralelos.instructor',
            'paralelos.inscripciones',
        ]);

        return view('cursos.show', compact('curso'));
    }
}
