<?php

namespace App\Http\Controllers\Participante;

use App\Http\Controllers\Controller;
use App\Models\Participante;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->query('buscar');
        $query = Participante::withCount(['inscripciones']);

        if ($buscar) {
            $query->where(function ($q) use ($buscar) {
                $q->where('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%")
                    ->orWhere('documento_identidad', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        $participantes = $query->latest()->paginate(15);

        return view('participantes.index', compact('participantes', 'buscar'));
    }

    public function create()
    {
        return view('participantes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'documento_identidad' => 'required|string|max:20|unique:participantes,documento_identidad',
            'nombres' => 'required|string|max:80',
            'apellidos' => 'required|string|max:80',
            'email' => 'required|email|max:120|unique:participantes,email',
            'telefono' => 'required|string|max:30',
            'direccion' => 'nullable|string|max:150',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        $participante = Participante::create($validated);

        return redirect()->route('participantes.show', $participante)
            ->with('success', 'Participante registrado exitosamente.');
    }

    public function show(Participante $participante)
    {
        $participante->load([
            'inscripciones.paralelo.curso.categoria',
            'inscripciones.paralelo.instructor',
        ]);

        return view('participantes.show', compact('participante'));
    }
}
