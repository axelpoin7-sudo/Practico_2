<?php

namespace App\Http\Controllers\Inscripcion;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use App\Services\Inscripcion\InscripcionService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InscripcionController extends Controller
{
    public function __construct(
        protected InscripcionService $inscripcionService
    ) {}

    public function index(Request $request)
    {
        $estado = $request->query('estado');
        $paraleloId = $request->query('paralelo_id');

        $query = Inscripcion::with(['participante', 'paralelo.curso.categoria', 'paralelo.instructor']);

        if ($estado) {
            $query->where('estado', $estado);
        }

        if ($paraleloId) {
            $query->where('paralelo_id', $paraleloId);
        }

        $inscripciones = $query->latest('fecha_inscripcion')->paginate(20);
        $paralelos = Paralelo::with('curso')->get();

        return view('inscripciones.index', compact('inscripciones', 'paralelos', 'estado', 'paraleloId'));
    }

    public function create(Request $request)
    {
        $participantes = Participante::orderBy('nombres')->get();
        $paralelos = Paralelo::with(['curso.categoria', 'instructor'])
            ->abiertos()
            ->get();

        $selectedParaleloId = $request->query('paralelo_id');
        $selectedParticipanteId = $request->query('participante_id');

        return view('inscripciones.create', compact('participantes', 'paralelos', 'selectedParaleloId', 'selectedParticipanteId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'participante_id' => 'required|exists:participantes,id',
            'paralelo_id' => 'required|exists:paralelos,id',
            'estado' => 'required|in:pendiente,pagada',
            'monto_pagado' => 'nullable|numeric|min:0',
            'metodo_pago' => 'nullable|string|max:50',
            'comprobante' => 'nullable|string|max:100',
            'observaciones' => 'nullable|string',
        ]);

        try {
            $inscripcion = $this->inscripcionService->inscribir($request->all());

            return redirect()->route('inscripciones.show', $inscripcion)
                ->with('success', "¡Inscripción registrada exitosamente con código {$inscripcion->codigo}!");
        } catch (ValidationException $e) {
            return back()->withInput()->withErrors($e->errors());
        }
    }

    public function show(Inscripcion $inscripcione)
    {
        $inscripcione->load([
            'participante',
            'paralelo.curso.categoria',
            'paralelo.instructor',
        ]);

        return view('inscripciones.show', ['inscripcion' => $inscripcione]);
    }

    public function anular(Request $request, Inscripcion $inscripcione)
    {
        $motivo = $request->input('motivo', 'Cancelación por solicitud del estudiante');
        $this->inscripcionService->anular($inscripcione, $motivo);

        return back()->with('warning', "Inscripción {$inscripcione->codigo} anulada. El cupo ha sido liberado.");
    }

    public function pagar(Request $request, Inscripcion $inscripcione)
    {
        $request->validate([
            'monto_pagado' => 'required|numeric|min:1',
            'metodo_pago' => 'required|string|max:50',
            'comprobante' => 'nullable|string|max:100',
        ]);

        $this->inscripcionService->registrarPago(
            $inscripcione,
            (float) $request->input('monto_pagado'),
            $request->input('metodo_pago'),
            $request->input('comprobante')
        );

        return back()->with('success', "Pago registrado exitosamente para la inscripción {$inscripcione->codigo}.");
    }
}
