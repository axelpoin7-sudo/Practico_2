<?php

namespace Database\Factories;

use App\Models\Inscripcion;
use App\Models\Paralelo;
use App\Models\Participante;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inscripcion>
 */
class InscripcionFactory extends Factory
{
    protected $model = Inscripcion::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $estados = ['pagada', 'pagada', 'pagada', 'pendiente', 'anulada'];
        $estado = fake()->randomElement($estados);
        $metodos = ['Transferencia QR', 'Efectivo', 'Tarjeta de Débito', 'Depósito Bancario'];

        return [
            'codigo' => 'INS-' . date('Y') . '-' . strtoupper(fake()->bothify('####??')),
            'participante_id' => Participante::factory(),
            'paralelo_id' => Paralelo::factory(),
            'fecha_inscripcion' => fake()->dateTimeBetween('-30 days', 'now'),
            'monto_pagado' => $estado === 'pagada' ? fake()->randomElement([150, 180, 220, 250, 280, 320, 450]) : ($estado === 'pendiente' ? fake()->randomElement([0, 50, 100]) : 0),
            'estado' => $estado,
            'metodo_pago' => $estado === 'pagada' ? fake()->randomElement($metodos) : null,
            'comprobante' => $estado === 'pagada' ? 'REC-' . fake()->numerify('#####') : null,
            'observaciones' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
