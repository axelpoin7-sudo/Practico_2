<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount(['cursos', 'paralelos'])->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string',
            'color' => 'required|string|max:20',
            'icono' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['nombre']);
        $validated['activo'] = true;

        Categoria::create($validated);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load(['cursos.instructor', 'cursos.paralelos']);

        return view('categorias.show', compact('categoria'));
    }
}
