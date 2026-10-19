<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructores = Instructor::withCount(['cursos', 'paralelos'])->get();

        return view('instructores.index', compact('instructores'));
    }

    public function create()
    {
        return view('instructores.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento_identidad' => 'required|string|max:20|unique:instructores,documento_identidad',
            'nombres' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'email' => 'required|email|max:120|unique:instructores,email',
            'telefono' => 'required|string|max:30',
            'especialidad' => 'required|string|max:100',
            'experiencia_anos' => 'required|integer|min:0|max:50',
            'biografia' => 'nullable|string',
        ]);

        $validated['activo'] = true;

        Instructor::create($validated);

        return redirect()->route('instructores.index')->with('success', 'Instructor registrado exitosamente.');
    }

    public function show(Instructor $instructore)
    {
        $instructore->load(['cursos.categoria', 'paralelos.curso']);

        return view('instructores.show', ['instructor' => $instructore]);
    }
}
