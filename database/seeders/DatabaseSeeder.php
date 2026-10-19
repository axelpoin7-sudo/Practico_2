<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Instructor;
use App\Models\Paralelo;
use App\Models\Participante;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('=== Iniciando Seeding de Plataforma de Capacitación ===');

        // 1. Categorías del caso de estudio
        $categoriasData = [
            [
                'nombre' => 'Ofimática',
                'slug' => 'ofimatica',
                'descripcion' => 'Herramientas de productividad de oficina, hojas de cálculo avanzadas y gestión documental ejecutiva.',
                'icono' => 'table',
                'color' => '#0284c7',
                'activo' => true,
            ],
            [
                'nombre' => 'Programación',
                'slug' => 'programacion',
                'descripcion' => 'Desarrollo de software web, backend, frontend, lenguajes de programación modernos y bases de datos.',
                'icono' => 'code',
                'color' => '#10b981',
                'activo' => true,
            ],
            [
                'nombre' => 'Diseño',
                'slug' => 'diseno',
                'descripcion' => 'Diseño gráfico editorial, branding corporativo, diseño de interfaces UI/UX y producción audiovisual.',
                'icono' => 'palette',
                'color' => '#8b5cf6',
                'activo' => true,
            ],
        ];

        $categorias = [];
        foreach ($categoriasData as $cat) {
            $categorias[$cat['nombre']] = Categoria::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
        $this->command->info('✓ 3 Categorías creadas (Ofimática, Programación, Diseño)');

        // 2. Instructores con especialidad
        $instructoresData = [
            [
                'documento_identidad' => '4789123',
                'nombres' => 'Carlos Alberto',
                'apellidos' => 'Mendoza Vaca',
                'email' => 'carlos.mendoza@capacitacion.edu.bo',
                'telefono' => '71234567',
                'especialidad' => 'Excel Avanzado, Macros VBA y Power BI',
                'biografia' => 'Especialista certificado en soluciones de inteligencia de negocios con más de 10 años capacitando a empresas líderes.',
                'experiencia_anos' => 10,
                'activo' => true,
            ],
            [
                'documento_identidad' => '5891234',
                'nombres' => 'Marco Antonio',
                'apellidos' => 'Quispe Mamani',
                'email' => 'marco.quispe@capacitacion.edu.bo',
                'telefono' => '72345678',
                'especialidad' => 'Desarrollo Web Full Stack (PHP, Laravel, Vue)',
                'biografia' => 'Arquitecto de software y docente universitario especializado en tecnologías web modernas y arquitecturas limpias.',
                'experiencia_anos' => 8,
                'activo' => true,
            ],
            [
                'documento_identidad' => '6912345',
                'nombres' => 'Elena Patricia',
                'apellidos' => 'Ramos Flores',
                'email' => 'elena.ramos@capacitacion.edu.bo',
                'telefono' => '73456789',
                'especialidad' => 'Diseño UI/UX, Figma y Diseño Gráfico Publicitario',
                'biografia' => 'Diseñadora de experiencia de usuario con amplia trayectoria en productos digitales de impacto internacional.',
                'experiencia_anos' => 7,
                'activo' => true,
            ],
            [
                'documento_identidad' => '7123890',
                'nombres' => 'Roberto Daniel',
                'apellidos' => 'Gómez Fernández',
                'email' => 'roberto.gomez@capacitacion.edu.bo',
                'telefono' => '74567890',
                'especialidad' => 'Python, Análisis de Datos y Algoritmos',
                'biografia' => 'Ingeniero de Sistemas con maestría en Ciencia de Datos y Machine Learning.',
                'experiencia_anos' => 6,
                'activo' => true,
            ],
            [
                'documento_identidad' => '8234901',
                'nombres' => 'Sofía Valeria',
                'apellidos' => 'Alarcón Vargas',
                'email' => 'sofia.alarcon@capacitacion.edu.bo',
                'telefono' => '75678901',
                'especialidad' => 'Edición Audiovisual, Premiere y After Effects',
                'biografia' => 'Realizadora audiovisual y animadora 2D/3D con premios en festivales nacionales de cortometrajes y publicidad.',
                'experiencia_anos' => 9,
                'activo' => true,
            ],
        ];

        $instructores = [];
        foreach ($instructoresData as $inst) {
            $instructores[$inst['documento_identidad']] = Instructor::updateOrCreate(
                ['documento_identidad' => $inst['documento_identidad']],
                $inst
            );
        }
        $this->command->info('✓ 5 Instructores registrados con sus respectivas especialidades');

        // 3. Cursos por Categoría e Instructor
        $cursosData = [
            // Ofimática
            [
                'categoria' => 'Ofimática',
                'instructor_ci' => '4789123',
                'codigo' => 'CUR-OFI-01',
                'nombre' => 'Excel Avanzado con Macros y Automatización VBA',
                'descripcion' => 'Domina el diseño de macros, programación en Visual Basic para Aplicaciones, tablas dinámicas avanzadas y automatización de procesos repetitivos.',
                'costo' => 250.00,
                'duracion_horas' => 36,
                'nivel' => 'Avanzado',
            ],
            [
                'categoria' => 'Ofimática',
                'instructor_ci' => '4789123',
                'codigo' => 'CUR-OFI-02',
                'nombre' => 'Power BI para Análisis de Datos y Dashboards Ejecutivos',
                'descripcion' => 'Aprende a conectar múltiples fuentes de datos, modelar mediante DAX y crear informes interactivos de alto impacto para toma de decisiones.',
                'costo' => 320.00,
                'duracion_horas' => 40,
                'nivel' => 'Intermedio',
            ],
            [
                'categoria' => 'Ofimática',
                'instructor_ci' => '4789123',
                'codigo' => 'CUR-OFI-03',
                'nombre' => 'Ofimática Empresarial y Productividad con Google Workspace',
                'descripcion' => 'Técnicas de redacción formal, presentaciones de impacto, formularios, hojas de cálculo colaborativas y organización en la nube.',
                'costo' => 180.00,
                'duracion_horas' => 24,
                'nivel' => 'Básico',
            ],

            // Programación
            [
                'categoria' => 'Programación',
                'instructor_ci' => '5891234',
                'codigo' => 'CUR-PRG-01',
                'nombre' => 'Desarrollo Web Full Stack con Laravel y Vue.js',
                'descripcion' => 'Construcción integral de aplicaciones web robustas con arquitectura MVC, APIs RESTful, autenticación y componentes reactivos.',
                'costo' => 450.00,
                'duracion_horas' => 60,
                'nivel' => 'Intermedio',
            ],
            [
                'categoria' => 'Programación',
                'instructor_ci' => '7123890',
                'codigo' => 'CUR-PRG-02',
                'nombre' => 'Programación en Python desde Cero hasta Proyectos Reales',
                'descripcion' => 'Fundamentos sólidos de algoritmos, estructuras de datos, programación orientada a objetos y scripts de automatización con Python.',
                'costo' => 280.00,
                'duracion_horas' => 40,
                'nivel' => 'Básico',
            ],
            [
                'categoria' => 'Programación',
                'instructor_ci' => '5891234',
                'codigo' => 'CUR-PRG-03',
                'nombre' => 'Modelado de Bases de Datos Relacionales con MySQL y PostgreSQL',
                'descripcion' => 'Diseño conceptual y lógico, normalización, optimización de consultas SQL, procedimientos almacenados e índices de alto rendimiento.',
                'costo' => 260.00,
                'duracion_horas' => 32,
                'nivel' => 'Intermedio',
            ],

            // Diseño
            [
                'categoria' => 'Diseño',
                'instructor_ci' => '6912345',
                'codigo' => 'CUR-DSN-01',
                'nombre' => 'Diseño Gráfico Publicitario con Photoshop e Illustrator',
                'descripcion' => 'Creación de piezas gráficas comerciales, retoque fotográfico digital, vectorización profesional y preparación de artes finales para imprenta y web.',
                'costo' => 300.00,
                'duracion_horas' => 45,
                'nivel' => 'Básico',
            ],
            [
                'categoria' => 'Diseño',
                'instructor_ci' => '6912345',
                'codigo' => 'CUR-DSN-02',
                'nombre' => 'Diseño de Interfaces UI/UX y Prototipado con Figma',
                'descripcion' => 'Principios de experiencia de usuario, diseño de sistemas de diseño, arquitectura de información y prototipado interactivo para apps móviles y web.',
                'costo' => 350.00,
                'duracion_horas' => 35,
                'nivel' => 'Intermedio',
            ],
            [
                'categoria' => 'Diseño',
                'instructor_ci' => '8234901',
                'codigo' => 'CUR-DSN-03',
                'nombre' => 'Edición Profesional de Video con Premiere y After Effects',
                'descripcion' => 'Montaje narrativo, corrección de color cinemática, efectos visuales dinámicos, títulos animados y exportación multiformato para redes sociales.',
                'costo' => 340.00,
                'duracion_horas' => 40,
                'nivel' => 'Intermedio',
            ],
        ];

        $cursos = [];
        foreach ($cursosData as $c) {
            $catId = $categorias[$c['categoria']]->id;
            $instId = $instructores[$c['instructor_ci']]->id;

            $cursos[$c['codigo']] = Curso::updateOrCreate(
                ['codigo' => $c['codigo']],
                [
                    'categoria_id' => $catId,
                    'instructor_id' => $instId,
                    'nombre' => $c['nombre'],
                    'descripcion' => $c['descripcion'],
                    'costo' => $c['costo'],
                    'duracion_horas' => $c['duracion_horas'],
                    'nivel' => $c['nivel'],
                    'activo' => true,
                ]
            );
        }
        $this->command->info('✓ 9 Cursos creados en Ofimática, Programación y Diseño');

        // 4. Paralelos con horario, aula, fecha inicio y cupo máximo
        $paralelosData = [
            // CUR-OFI-01 (Excel Avanzado)
            [
                'curso_codigo' => 'CUR-OFI-01',
                'codigo' => 'PAR-OFI-01A',
                'nombre' => 'Paralelo Mañana A',
                'aula' => 'Laboratorio de Cómputo 101',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-11-27',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '08:00:00',
                'hora_fin' => '10:00:00',
                'cupo_maximo' => 4, // Cupo pequeño para probar regla de cupo lleno
            ],
            [
                'curso_codigo' => 'CUR-OFI-01',
                'codigo' => 'PAR-OFI-01B',
                'nombre' => 'Paralelo Noche B',
                'aula' => 'Laboratorio de Cómputo 102',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-11-27',
                'dias' => 'Lunes a Viernes',
                'dias_semana' => 'lunes,martes,miercoles,jueves,viernes',
                'hora_inicio' => '19:00:00',
                'hora_fin' => '21:00:00',
                'cupo_maximo' => 15,
            ],
            [
                'curso_codigo' => 'CUR-OFI-01',
                'codigo' => 'PAR-OFI-01C',
                'nombre' => 'Paralelo Intensivo Sábados',
                'aula' => 'Aula Multimedia 201',
                'fecha_inicio' => '2026-11-07',
                'fecha_fin' => '2026-12-12',
                'dias' => 'Sábados',
                'dias_semana' => 'sabados',
                'hora_inicio' => '08:30:00',
                'hora_fin' => '12:30:00',
                'cupo_maximo' => 12,
            ],

            // CUR-PRG-01 (Laravel Full Stack)
            [
                'curso_codigo' => 'CUR-PRG-01',
                'codigo' => 'PAR-PRG-01A',
                'nombre' => 'Paralelo Mañana A (Laravel)',
                'aula' => 'Laboratorio de Cómputo 101',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-18',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '08:00:00', // Coincide con PAR-OFI-01A (para pruebas de cruce)
                'hora_fin' => '10:00:00',
                'cupo_maximo' => 15,
            ],
            [
                'curso_codigo' => 'CUR-PRG-01',
                'codigo' => 'PAR-PRG-01B',
                'nombre' => 'Paralelo Tarde B (Laravel)',
                'aula' => 'Laboratorio de Cómputo 102',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-18',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '14:30:00',
                'hora_fin' => '16:30:00',
                'cupo_maximo' => 18,
            ],
            [
                'curso_codigo' => 'CUR-PRG-01',
                'codigo' => 'PAR-PRG-01C',
                'nombre' => 'Paralelo Noche C (Laravel)',
                'aula' => 'Laboratorio de Cómputo 101',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-18',
                'dias' => 'Lunes a Viernes',
                'dias_semana' => 'lunes,martes,miercoles,jueves,viernes',
                'hora_inicio' => '19:00:00',
                'hora_fin' => '21:00:00',
                'cupo_maximo' => 20,
            ],

            // CUR-DSN-01 (Photoshop e Illustrator)
            [
                'curso_codigo' => 'CUR-DSN-01',
                'codigo' => 'PAR-DSN-01A',
                'nombre' => 'Paralelo Media Mañana A',
                'aula' => 'Taller de Diseño Digital 301',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-04',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '10:30:00',
                'hora_fin' => '12:30:00',
                'cupo_maximo' => 12,
            ],
            [
                'curso_codigo' => 'CUR-DSN-01',
                'codigo' => 'PAR-DSN-01B',
                'nombre' => 'Paralelo Tarde B (Diseño)',
                'aula' => 'Taller de Diseño Digital 301',
                'fecha_inicio' => '2026-11-03',
                'fecha_fin' => '2026-12-10',
                'dias' => 'Martes y Jueves',
                'dias_semana' => 'martes,jueves',
                'hora_inicio' => '16:45:00',
                'hora_fin' => '18:45:00',
                'cupo_maximo' => 14,
            ],

            // CUR-PRG-02 (Python)
            [
                'curso_codigo' => 'CUR-PRG-02',
                'codigo' => 'PAR-PRG-02A',
                'nombre' => 'Paralelo Tarde Python',
                'aula' => 'Aula Multimedia 202',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-04',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '14:30:00',
                'hora_fin' => '16:30:00',
                'cupo_maximo' => 15,
            ],

            // CUR-DSN-02 (UI/UX Figma)
            [
                'curso_codigo' => 'CUR-DSN-02',
                'codigo' => 'PAR-DSN-02A',
                'nombre' => 'Paralelo Noche Figma',
                'aula' => 'Taller de Diseño Digital 301',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-12-04',
                'dias' => 'Lunes, Miércoles, Viernes',
                'dias_semana' => 'lunes,miercoles,viernes',
                'hora_inicio' => '19:00:00',
                'hora_fin' => '21:00:00',
                'cupo_maximo' => 16,
            ],

            // CUR-OFI-02 (Power BI)
            [
                'curso_codigo' => 'CUR-OFI-02',
                'codigo' => 'PAR-OFI-02A',
                'nombre' => 'Paralelo Tarde Power BI',
                'aula' => 'Laboratorio de Cómputo 102',
                'fecha_inicio' => '2026-11-03',
                'fecha_fin' => '2026-12-10',
                'dias' => 'Martes y Jueves',
                'dias_semana' => 'martes,jueves',
                'hora_inicio' => '16:45:00',
                'hora_fin' => '18:45:00',
                'cupo_maximo' => 12,
            ],
        ];

        $paralelos = [];
        foreach ($paralelosData as $p) {
            $curso = $cursos[$p['curso_codigo']];
            $paralelos[$p['codigo']] = Paralelo::updateOrCreate(
                ['codigo' => $p['codigo']],
                [
                    'curso_id' => $curso->id,
                    'instructor_id' => $curso->instructor_id,
                    'nombre' => $p['nombre'],
                    'aula' => $p['aula'],
                    'fecha_inicio' => $p['fecha_inicio'],
                    'fecha_fin' => $p['fecha_fin'],
                    'dias' => $p['dias'],
                    'dias_semana' => $p['dias_semana'],
                    'hora_inicio' => $p['hora_inicio'],
                    'hora_fin' => $p['hora_fin'],
                    'cupo_maximo' => $p['cupo_maximo'],
                    'estado' => 'abierto',
                ]
            );
        }
        $this->command->info('✓ 11 Paralelos configurados con horarios, cupos y aulas');

        // 5. Participantes representativos
        $participantesData = [
            ['ci' => '10293847', 'nombres' => 'Alejandro', 'apellidos' => 'Torrez Morales', 'email' => 'alejandro.torrez@gmail.com', 'telefono' => '71122334', 'ciudad' => 'La Paz'],
            ['ci' => '20394856', 'nombres' => 'Lucía', 'apellidos' => 'Chávez Justiniano', 'email' => 'lucia.chavez@hotmail.com', 'telefono' => '72233445', 'ciudad' => 'Santa Cruz'],
            ['ci' => '30495867', 'nombres' => 'Rodrigo', 'apellidos' => 'Vargas Pinto', 'email' => 'rodrigo.vargas@gmail.com', 'telefono' => '73344556', 'ciudad' => 'Cochabamba'],
            ['ci' => '40596878', 'nombres' => 'Camila', 'apellidos' => 'Rios Salinas', 'email' => 'camila.rios@gmail.com', 'telefono' => '74455667', 'ciudad' => 'Sucre'],
            ['ci' => '50697889', 'nombres' => 'Diego Fernando', 'apellidos' => 'Flores Callisaya', 'email' => 'diego.flores@outlook.com', 'telefono' => '75566778', 'ciudad' => 'El Alto'],
            ['ci' => '60798890', 'nombres' => 'Paola Andrea', 'apellidos' => 'Arias Guzmán', 'email' => 'paola.arias@gmail.com', 'telefono' => '76677889', 'ciudad' => 'Tarija'],
            ['ci' => '70899901', 'nombres' => 'Mateo', 'apellidos' => 'Silva Montaño', 'email' => 'mateo.silva@yahoo.com', 'telefono' => '77788990', 'ciudad' => 'Oruro'],
            ['ci' => '80900012', 'nombres' => 'Valeria', 'apellidos' => 'Peñaranda Soliz', 'email' => 'valeria.penaranda@gmail.com', 'telefono' => '78899001', 'ciudad' => 'Potosí'],
            ['ci' => '91011123', 'nombres' => 'Gabriel', 'apellidos' => 'Castillo Mercado', 'email' => 'gabriel.castillo@gmail.com', 'telefono' => '79900112', 'ciudad' => 'Beni'],
            ['ci' => '11223344', 'nombres' => 'Natalia', 'apellidos' => 'Zenteno Rocha', 'email' => 'natalia.zenteno@outlook.com', 'telefono' => '70011223', 'ciudad' => 'Pando'],
            ['ci' => '22334455', 'nombres' => 'Jorge Luis', 'apellidos' => 'Montes Claros', 'email' => 'jorge.montes@gmail.com', 'telefono' => '71133557', 'ciudad' => 'La Paz'],
            ['ci' => '33445566', 'nombres' => 'Mariana', 'apellidos' => 'Aguilar Benitez', 'email' => 'mariana.aguilar@gmail.com', 'telefono' => '72244668', 'ciudad' => 'Santa Cruz'],
            ['ci' => '44556677', 'nombres' => 'Sebastián', 'apellidos' => 'Peredo Sandoval', 'email' => 'sebastian.peredo@gmail.com', 'telefono' => '73355779', 'ciudad' => 'Cochabamba'],
            ['ci' => '55667788', 'nombres' => 'Daniela Belén', 'apellidos' => 'Coronel Hurtado', 'email' => 'daniela.coronel@gmail.com', 'telefono' => '74466880', 'ciudad' => 'La Paz'],
            ['ci' => '66778899', 'nombres' => 'Andrés Mauricio', 'apellidos' => 'Miranda Siles', 'email' => 'andres.miranda@hotmail.com', 'telefono' => '75577991', 'ciudad' => 'Santa Cruz'],
        ];

        $participantes = [];
        foreach ($participantesData as $part) {
            $participantes[$part['ci']] = Participante::updateOrCreate(
                ['documento_identidad' => $part['ci']],
                [
                    'nombres' => $part['nombres'],
                    'apellidos' => $part['apellidos'],
                    'email' => $part['email'],
                    'telefono' => $part['telefono'],
                    'direccion' => 'Av. Principal #123, ' . $part['ciudad'],
                    'fecha_nacimiento' => '1998-05-15',
                ]
            );
        }
        $this->command->info('✓ 15 Participantes creados');

        // 6. Inscripciones representativas con diferentes estados y montos
        // IMPORTANTE: Llenaremos exactamente PAR-OFI-01A (cupo = 4) con 4 inscritos
        // para tener un caso 100% verídico de paralelo lleno.
        $llenadoParaleloOFI = ['10293847', '20394856', '30495867', '40596878'];
        $paraleloLleno = $paralelos['PAR-OFI-01A'];

        foreach ($llenadoParaleloOFI as $idx => $ci) {
            $participante = $participantes[$ci];
            Inscripcion::updateOrCreate(
                ['participante_id' => $participante->id, 'paralelo_id' => $paraleloLleno->id],
                [
                    'codigo' => 'INS-2026-L' . ($idx + 1),
                    'fecha_inscripcion' => Carbon::now()->subDays(10 - $idx),
                    'monto_pagado' => 250.00,
                    'estado' => 'pagada',
                    'metodo_pago' => 'Transferencia QR',
                    'comprobante' => 'QR-' . (1000 + $idx),
                    'observaciones' => 'Inscripción confirmada y pagada en su totalidad.',
                ]
            );
        }
        $this->command->info('✓ Paralelo PAR-OFI-01A llenado a su cupo máximo (4/4) para pruebas de integridad');

        // Más inscripciones en otros paralelos
        $otrasInscripciones = [
            // PAR-PRG-01A (Laravel Mañana)
            ['ci' => '50697889', 'par' => 'PAR-PRG-01A', 'estado' => 'pagada', 'monto' => 450.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '60798890', 'par' => 'PAR-PRG-01A', 'estado' => 'pagada', 'monto' => 450.00, 'metodo' => 'Tarjeta de Débito'],
            ['ci' => '70899901', 'par' => 'PAR-PRG-01A', 'estado' => 'pendiente', 'monto' => 0.00, 'metodo' => null],

            // PAR-PRG-01B (Laravel Tarde)
            ['ci' => '10293847', 'par' => 'PAR-PRG-01B', 'estado' => 'pagada', 'monto' => 450.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '80900012', 'par' => 'PAR-PRG-01B', 'estado' => 'pagada', 'monto' => 450.00, 'metodo' => 'Efectivo'],
            ['ci' => '91011123', 'par' => 'PAR-PRG-01B', 'estado' => 'pendiente', 'monto' => 200.00, 'metodo' => 'Efectivo'],

            // PAR-DSN-01A (Photoshop Media Mañana)
            ['ci' => '20394856', 'par' => 'PAR-DSN-01A', 'estado' => 'pagada', 'monto' => 300.00, 'metodo' => 'Tarjeta de Débito'],
            ['ci' => '11223344', 'par' => 'PAR-DSN-01A', 'estado' => 'pagada', 'monto' => 300.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '22334455', 'par' => 'PAR-DSN-01A', 'estado' => 'anulada', 'monto' => 0.00, 'metodo' => null],

            // PAR-DSN-02A (Figma Noche)
            ['ci' => '30495867', 'par' => 'PAR-DSN-02A', 'estado' => 'pagada', 'monto' => 350.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '33445566', 'par' => 'PAR-DSN-02A', 'estado' => 'pagada', 'monto' => 350.00, 'metodo' => 'Efectivo'],
            ['ci' => '44556677', 'par' => 'PAR-DSN-02A', 'estado' => 'pendiente', 'monto' => 150.00, 'metodo' => 'Efectivo'],

            // PAR-OFI-02A (Power BI Tarde)
            ['ci' => '55667788', 'par' => 'PAR-OFI-02A', 'estado' => 'pagada', 'monto' => 320.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '66778899', 'par' => 'PAR-OFI-02A', 'estado' => 'pagada', 'monto' => 320.00, 'metodo' => 'Tarjeta de Débito'],
            ['ci' => '40596878', 'par' => 'PAR-OFI-02A', 'estado' => 'pagada', 'monto' => 320.00, 'metodo' => 'Transferencia QR'],

            // PAR-PRG-02A (Python Tarde)
            ['ci' => '50697889', 'par' => 'PAR-PRG-02A', 'estado' => 'pagada', 'monto' => 280.00, 'metodo' => 'Transferencia QR'],
            ['ci' => '11223344', 'par' => 'PAR-PRG-02A', 'estado' => 'pendiente', 'monto' => 0.00, 'metodo' => null],
        ];

        $insCount = count($llenadoParaleloOFI);
        foreach ($otrasInscripciones as $item) {
            $participante = $participantes[$item['ci']];
            $paralelo = $paralelos[$item['par']];
            $insCount++;

            Inscripcion::updateOrCreate(
                ['participante_id' => $participante->id, 'paralelo_id' => $paralelo->id],
                [
                    'codigo' => 'INS-2026-' . str_pad((string) $insCount, 4, '0', STR_PAD_LEFT),
                    'fecha_inscripcion' => Carbon::now()->subDays(rand(1, 20)),
                    'monto_pagado' => $item['monto'],
                    'estado' => $item['estado'],
                    'metodo_pago' => $item['metodo'],
                    'comprobante' => $item['estado'] === 'pagada' ? 'REC-' . rand(10000, 99999) : null,
                    'observaciones' => $item['estado'] === 'anulada' ? 'Cancelado por solicitud del participante antes de iniciar clases.' : null,
                ]
            );
        }

        $this->command->info("✓ Total {$insCount} inscripciones generadas con estados: pagada, pendiente y anulada");
        $this->command->info('=== Seeding completado exitosamente ===');
    }
}
