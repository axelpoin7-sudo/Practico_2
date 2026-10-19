<?php

use App\Http\Controllers\Categoria\CategoriaController;
use App\Http\Controllers\Curso\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Inscripcion\InscripcionController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Paralelo\ParaleloController;
use App\Http\Controllers\Participante\ParticipanteController;
use App\Http\Controllers\Reporte\ReporteController;
use Illuminate\Support\Facades\Route;

// Dashboard principal
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Categorías (Ofimática, Programación, Diseño)
Route::resource('categorias', CategoriaController::class)->only(['index', 'create', 'store', 'show']);

// Instructores y especialidades
Route::resource('instructores', InstructorController::class)->only(['index', 'create', 'store', 'show']);

// Cursos
Route::resource('cursos', CursoController::class)->only(['index', 'create', 'store', 'show']);

// Paralelos y emisión de lista de inscritos
Route::get('paralelos/{paralelo}/inscritos', [ParaleloController::class, 'inscritos'])->name('paralelos.inscritos');
Route::resource('paralelos', ParaleloController::class)->only(['index', 'create', 'store', 'show']);

// Participantes
Route::resource('participantes', ParticipanteController::class)->only(['index', 'create', 'store', 'show']);

// Inscripciones con validación de cupo y horario cruzado
Route::post('inscripciones/{inscripcione}/pagar', [InscripcionController::class, 'pagar'])->name('inscripciones.pagar');
Route::post('inscripciones/{inscripcione}/anular', [InscripcionController::class, 'anular'])->name('inscripciones.anular');
Route::resource('inscripciones', InscripcionController::class)->only(['index', 'create', 'store', 'show']);

// Reportes requeridos por el dominio y la actividad
Route::get('reportes/ingresos', [ReporteController::class, 'ingresos'])->name('reportes.ingresos');
Route::get('reportes/tinker', [ReporteController::class, 'tinker'])->name('reportes.tinker');
