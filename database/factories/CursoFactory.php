<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Instructor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    protected $model = Curso::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cursos = [
            // Ofimática
            ['nombre' => 'Excel Profesional: Fórmulas y Tablas Dinámicas', 'nivel' => 'Básico', 'horas' => 24, 'costo' => 180.00],
            ['nombre' => 'Excel Avanzado con Macros y VBA', 'nivel' => 'Avanzado', 'horas' => 36, 'costo' => 250.00],
            ['nombre' => 'Power BI para Análisis de Datos y Dashboards', 'nivel' => 'Intermedio', 'horas' => 40, 'costo' => 320.00],
            ['nombre' => 'Herramientas de Productividad y Documentación Ejecutiva', 'nivel' => 'Básico', 'horas' => 20, 'costo' => 150.00],

            // Programación
            ['nombre' => 'Desarrollo Web Full Stack con Laravel y Vue', 'nivel' => 'Intermedio', 'horas' => 60, 'costo' => 450.00],
            ['nombre' => 'Introducción a la Programación con Python', 'nivel' => 'Básico', 'horas' => 30, 'costo' => 220.00],
            ['nombre' => 'Javascript Moderno y Construcción de SPAs', 'nivel' => 'Intermedio', 'horas' => 45, 'costo' => 350.00],
            ['nombre' => 'Diseño y Modelado de Bases de Datos con MySQL/PostgreSQL', 'nivel' => 'Intermedio', 'horas' => 32, 'costo' => 260.00],

            // Diseño
            ['nombre' => 'Diseño Gráfico Publicitario con Photoshop e Illustrator', 'nivel' => 'Básico', 'horas' => 40, 'costo' => 280.00],
            ['nombre' => 'Diseño de Experiencia de Usuario y Prototipado en Figma', 'nivel' => 'Intermedio', 'horas' => 35, 'costo' => 310.00],
            ['nombre' => 'Edición y Composición de Video con Premiere Pro', 'nivel' => 'Intermedio', 'horas' => 40, 'costo' => 290.00],
            ['nombre' => 'Identidad Visual Corporativa y Branding Digital', 'nivel' => 'Avanzado', 'horas' => 28, 'costo' => 240.00],
        ];

        $curso = fake()->randomElement($cursos);

        return [
            'categoria_id' => Categoria::factory(),
            'instructor_id' => Instructor::factory(),
            'codigo' => 'CUR-' . strtoupper(fake()->bothify('??-###')),
            'nombre' => $curso['nombre'],
            'descripcion' => fake()->paragraph(3),
            'costo' => $curso['costo'],
            'duracion_horas' => $curso['horas'],
            'nivel' => $curso['nivel'],
            'activo' => true,
        ];
    }
}
