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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete();
            $table->foreignId('instructor_id')->constrained('instructores')->restrictOnDelete();
            $table->string('codigo', 30)->unique();
            $table->string('nombre', 150);
            $table->text('descripcion');
            $table->decimal('costo', 10, 2)->default(0.00);
            $table->unsignedSmallInteger('duracion_horas')->default(20);
            $table->enum('nivel', ['Básico', 'Intermedio', 'Avanzado'])->default('Básico');
            $table->boolean('activo')->default(true)->index();
            $table->timestamps();

            $table->index(['categoria_id', 'activo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
