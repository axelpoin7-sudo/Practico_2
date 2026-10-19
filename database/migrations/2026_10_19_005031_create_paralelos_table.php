<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paralelos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->restrictOnDelete();
            $table->foreignId('instructor_id')->nullable()->constrained('instructores')->nullOnDelete();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 100);
            $table->string('aula', 80);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('dias', 100)->default('Lunes a Viernes');
            $table->string('dias_semana', 120)->default('lunes,martes,miercoles,jueves,viernes');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedInteger('cupo_maximo')->default(20);
            $table->enum('estado', ['abierto', 'en_curso', 'cerrado', 'finalizado'])->default('abierto')->index();
            $table->timestamps();

            $table->index(['curso_id', 'estado']);
            $table->index(['fecha_inicio', 'fecha_fin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paralelos');
    }
};
