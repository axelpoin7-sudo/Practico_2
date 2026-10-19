<?php

namespace Database\Factories;

use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instructor>
 */
class InstructorFactory extends Factory
{
    protected $model = Instructor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $especialidades = [
            'Excel Avanzado y Business Intelligence',
            'Desarrollo Web Full Stack (PHP & Laravel)',
            'Diseño Gráfico Publicitario y Branding',
            'Python & Análisis de Datos',
            'Diseño de Interfaces UI/UX & Prototipado',
            'Bases de Datos Relacionales y SQL',
            'Edición y Postproducción Audiovisual',
            'Automatización de Oficinas y Hojas de Cálculo',
        ];

        return [
            'documento_identidad' => fake()->unique()->numerify('########'),
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'telefono' => fake()->numerify('7#######'),
            'especialidad' => fake()->randomElement($especialidades),
            'biografia' => fake()->paragraph(2),
            'experiencia_anos' => fake()->numberBetween(3, 15),
            'activo' => true,
        ];
    }
}
