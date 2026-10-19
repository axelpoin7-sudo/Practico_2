<?php

namespace Database\Factories;

use App\Models\Curso;
use App\Models\Instructor;
use App\Models\Paralelo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paralelo>
 */
class ParaleloFactory extends Factory
{
    protected $model = Paralelo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aulas = [
            'Laboratorio de Cómputo 101',
            'Laboratorio de Cómputo 102',
            'Aula Multimedia 201',
            'Aula Multimedia 202',
            'Taller de Diseño Digital 301',
            'Sala Virtual A (Híbrida)',
        ];

        $horarios = [
            ['inicio' => '08:00:00', 'fin' => '10:00:00', 'nombre' => 'Paralelo Mañana A', 'dias' => 'Lunes, Miércoles, Viernes', 'dias_semana' => 'lunes,miercoles,viernes'],
            ['inicio' => '10:30:00', 'fin' => '12:30:00', 'nombre' => 'Paralelo Mañana B', 'dias' => 'Lunes, Miércoles, Viernes', 'dias_semana' => 'lunes,miercoles,viernes'],
            ['inicio' => '14:30:00', 'fin' => '16:30:00', 'nombre' => 'Paralelo Tarde A', 'dias' => 'Lunes, Miércoles, Viernes', 'dias_semana' => 'lunes,miercoles,viernes'],
            ['inicio' => '16:45:00', 'fin' => '18:45:00', 'nombre' => 'Paralelo Tarde B', 'dias' => 'Martes y Jueves', 'dias_semana' => 'martes,jueves'],
            ['inicio' => '19:00:00', 'fin' => '21:00:00', 'nombre' => 'Paralelo Noche', 'dias' => 'Lunes a Viernes', 'dias_semana' => 'lunes,martes,miercoles,jueves,viernes'],
            ['inicio' => '08:30:00', 'fin' => '12:30:00', 'nombre' => 'Paralelo Intensivo Sabatino', 'dias' => 'Sábados', 'dias_semana' => 'sabados'],
        ];

        $horario = fake()->randomElement($horarios);
        $fechaInicio = Carbon::now()->addDays(fake()->numberBetween(5, 20))->startOfWeek();
        $fechaFin = (clone $fechaInicio)->addWeeks(fake()->numberBetween(4, 8))->endOfWeek();

        return [
            'curso_id' => Curso::factory(),
            'instructor_id' => Instructor::factory(),
            'codigo' => 'PAR-' . strtoupper(fake()->bothify('###??')),
            'nombre' => $horario['nombre'],
            'aula' => fake()->randomElement($aulas),
            'fecha_inicio' => $fechaInicio->toDateString(),
            'fecha_fin' => $fechaFin->toDateString(),
            'dias' => $horario['dias'],
            'dias_semana' => $horario['dias_semana'],
            'hora_inicio' => $horario['inicio'],
            'hora_fin' => $horario['fin'],
            'cupo_maximo' => fake()->randomElement([10, 15, 20, 25]),
            'estado' => 'abierto',
        ];
    }
}
