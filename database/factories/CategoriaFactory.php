<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = [
            ['nombre' => 'Ofimática', 'descripcion' => 'Cursos cortos en herramientas ofimáticas, hojas de cálculo y productividad empresarial.', 'icono' => 'table', 'color' => '#0284c7'],
            ['nombre' => 'Programación', 'descripcion' => 'Capacitación en desarrollo de software, algoritmos, tecnologías web y bases de datos.', 'icono' => 'code', 'color' => '#10b981'],
            ['nombre' => 'Diseño', 'descripcion' => 'Formación creativa en diseño gráfico, edición multimedia y diseño de interfaces UI/UX.', 'icono' => 'palette', 'color' => '#8b5cf6'],
            ['nombre' => 'Ciberseguridad', 'descripcion' => 'Fundamentos de seguridad informática, redes y protección de datos.', 'icono' => 'shield', 'color' => '#ef4444'],
            ['nombre' => 'Marketing Digital', 'descripcion' => 'Estrategias de contenido, analítica web y campañas en redes sociales.', 'icono' => 'chart-bar', 'color' => '#f59e0b'],
        ];

        $categoria = fake()->unique()->randomElement($categorias);

        return [
            'nombre' => $categoria['nombre'],
            'slug' => Str::slug($categoria['nombre']),
            'descripcion' => $categoria['descripcion'],
            'icono' => $categoria['icono'],
            'color' => $categoria['color'],
            'activo' => true,
        ];
    }
}
