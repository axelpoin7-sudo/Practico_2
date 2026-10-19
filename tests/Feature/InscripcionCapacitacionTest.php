<?php

namespace Tests\Feature;

use App\Models\Paralelo;
use App\Models\Participante;
use App\Services\Inscripcion\InscripcionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class InscripcionCapacitacionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Prueba que el dashboard y los reportes carguen con código 200.
     */
    public function test_vistas_principales_cargan_correctamente(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('CapacitaTech');

        $responseReporte = $this->get(route('reportes.ingresos'));
        $responseReporte->assertStatus(200);
        $responseReporte->assertSee('Reporte Financiero de Ingresos por Curso');

        $responseTinker = $this->get(route('reportes.tinker'));
        $responseTinker->assertStatus(200);
        $responseTinker->assertSee('10 Consultas con Tinker');
    }

    /**
     * Prueba la regla de negocio: Rechazo por cupo máximo lleno.
     */
    public function test_rechaza_inscripcion_cuando_paralelo_esta_lleno(): void
    {
        $paraleloLleno = Paralelo::where('codigo', 'PAR-OFI-01A')->first();
        $this->assertTrue($paraleloLleno->estaLleno(), 'El paralelo de prueba PAR-OFI-01A debe estar lleno con 4/4 cupos.');

        $participante = Participante::create([
            'documento_identidad' => '99887766',
            'nombres' => 'Estudiante',
            'apellidos' => 'Sin Cupo',
            'email' => 'estudiante.sincupo@test.com',
            'telefono' => '71112233',
        ]);

        $this->expectException(ValidationException::class);

        app(InscripcionService::class)->inscribir([
            'participante_id' => $participante->id,
            'paralelo_id' => $paraleloLleno->id,
            'monto_pagado' => 250.00,
            'estado' => 'pagada',
        ]);
    }

    /**
     * Prueba la regla de negocio: Rechazo por conflicto de horario cruzado.
     */
    public function test_rechaza_inscripcion_cuando_existe_horario_cruzado(): void
    {
        // Alejandro Torrez (ID: 1) ya está en PAR-OFI-01A (Lun-Mie-Vie 08:00 a 10:00)
        $participante = Participante::find(1);
        $paraleloConflicto = Paralelo::where('codigo', 'PAR-PRG-01A')->first(); // Lun-Mie-Vie 08:00 a 10:00

        $this->expectException(ValidationException::class);

        app(InscripcionService::class)->inscribir([
            'participante_id' => $participante->id,
            'paralelo_id' => $paraleloConflicto->id,
            'monto_pagado' => 450.00,
            'estado' => 'pagada',
        ]);
    }

    /**
     * Prueba la emisión de la lista de inscritos por paralelo.
     */
    public function test_emite_lista_de_inscritos_por_paralelo(): void
    {
        $paralelo = Paralelo::first();
        $response = $this->get(route('paralelos.inscritos', $paralelo));

        $response->assertStatus(200);
        $response->assertSee('Lista Oficial de Inscritos por Paralelo');
        $response->assertSee($paralelo->nombre);
    }
}
